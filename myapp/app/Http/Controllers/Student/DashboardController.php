<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $enrollments = auth()->user()->enrollments()
            ->with(['course.instructor', 'course.lessons'])
            ->latest()
            ->paginate(10);

        $certificates = auth()->user()->certificates()->with('course')->latest()->get();

        return view('student.dashboard', compact('enrollments', 'certificates'));
    }
}
