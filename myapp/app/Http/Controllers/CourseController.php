<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Services\CourseService;
use App\Services\EnrollmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService,
        private EnrollmentService $enrollmentService
    ) {}

    public function show(Course $course): View|RedirectResponse
    {
        if (! $course->is_published && ! optional(auth()->user())->isAdmin()) {
            if (auth()->user()?->id !== $course->instructor_id) {
                abort(404);
            }
        }

        $course->load(['instructor', 'category', 'lessons', 'reviews.user']);
        $course->loadCount('reviews');
        $course->loadAvg('reviews', 'rating');
        $isEnrolled = auth()->user() ? $this->enrollmentService->isEnrolled(auth()->user(), $course) : false;

        return view('courses.show', compact('course', 'isEnrolled'));
    }

    public function enroll(Course $course): RedirectResponse
    {
        $this->authorize('enroll', $course);
        $this->enrollmentService->enroll(auth()->user(), $course);

        return redirect()->route('courses.learn', $course)
            ->with('success', 'Successfully enrolled in the course!');
    }
}
