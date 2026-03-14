<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function update(User $user, Course $course): bool
    {
        return $user->id === $course->instructor_id || $user->isAdmin();
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->id === $course->instructor_id || $user->isAdmin();
    }

    public function enroll(User $user, Course $course): bool
    {
        return $user->isStudent() && ! $user->hasEnrolledIn($course);
    }
}
