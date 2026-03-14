<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function index(Course $course): View
    {
        $this->authorize('update', $course);
        $enrollments = $course->enrollments()->with('user')->latest()->paginate(20);

        return view('instructor.enrollments.index', compact('course', 'enrollments'));
    }
}
