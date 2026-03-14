<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();
        $courses = $user->coursesAsInstructor()->withCount('enrollments')->get();

        $totalCourses = $courses->count();
        $totalEnrollments = $courses->sum('enrollments_count');
        $recentEnrollments = $user->coursesAsInstructor()
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();

        return view('instructor.dashboard', compact(
            'totalCourses',
            'totalEnrollments',
            'recentEnrollments'
        ));
    }
}
