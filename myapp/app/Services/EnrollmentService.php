<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Notifications\CourseEnrolledNotification;

class EnrollmentService
{
    public function enroll(User $user, Course $course): Enrollment
    {
        $enrollment = Enrollment::firstOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['progress_percentage' => 0]
        );

        $user->notify(new CourseEnrolledNotification($course));

        return $enrollment;
    }

    public function updateProgress(Enrollment $enrollment): void
    {
        $course = $enrollment->course;
        $totalLessons = $course->lessons()->count();
        $completedLessons = $enrollment->user->lessonProgress()
            ->whereIn('lesson_id', $course->lessons->pluck('id'))
            ->where('completed', true)
            ->count();

        $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 2) : 0;
        $enrollment->update([
            'progress_percentage' => $progress,
            'completed_at' => $progress >= 100 ? now() : null,
        ]);
    }

    public function isEnrolled(User $user, Course $course): bool
    {
        return Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists();
    }
}
