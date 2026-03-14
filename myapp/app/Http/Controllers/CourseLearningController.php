<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Services\EnrollmentService;
use App\Services\CertificateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseLearningController extends Controller
{
    public function __construct(
        private EnrollmentService $enrollmentService,
        private CertificateService $certificateService
    ) {}

    public function show(Request $request, Course $course, ?Lesson $lesson = null): View|RedirectResponse
    {
        if (! $this->enrollmentService->isEnrolled(auth()->user(), $course)) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You must enroll in this course first.');
        }

        $course->load(['lessons' => fn ($q) => $q->orderBy('order'), 'quizzes.questions.options']);
        $lessons = $course->lessons;
        $quizzes = $course->quizzes;

        $currentLesson = $lesson ?? $lessons->first();
        $enrollment = auth()->user()->enrollments()->where('course_id', $course->id)->first();

        // Get next/prev lesson
        $currentIndex = $currentLesson ? $lessons->search(fn ($l) => $l->id === $currentLesson->id) : false;
        $nextLesson = $currentIndex !== false && isset($lessons[$currentIndex + 1]) ? $lessons[$currentIndex + 1] : null;
        $prevLesson = $currentIndex !== false && $currentIndex > 0 ? $lessons[$currentIndex - 1] : null;

        $certificate = auth()->user()->certificates()->where('course_id', $course->id)->first();

        return view('courses.learn', compact(
            'course',
            'lessons',
            'quizzes',
            'currentLesson',
            'nextLesson',
            'prevLesson',
            'enrollment',
            'certificate'
        ));
    }

    public function completeLesson(Request $request, Course $course, Lesson $lesson): RedirectResponse
    {
        $enrollment = auth()->user()->enrollments()->where('course_id', $course->id)->first();
        if (! $enrollment) {
            abort(403);
        }

        $progress = auth()->user()->lessonProgress()->firstOrCreate(
            ['lesson_id' => $lesson->id],
            ['completed' => false]
        );
        $progress->update([
            'completed' => true,
            'completed_at' => now(),
            'watch_time_seconds' => $progress->watch_time_seconds + ($request->input('seconds', 0)),
        ]);

        $this->enrollmentService->updateProgress($enrollment);

        // Check if course completed - generate certificate
        $enrollment->refresh();
        if ($enrollment->progress_percentage >= 100) {
            $this->certificateService->generateCertificate(auth()->user(), $course);
        }

        return back()->with('success', 'Lesson marked as complete!');
    }
}
