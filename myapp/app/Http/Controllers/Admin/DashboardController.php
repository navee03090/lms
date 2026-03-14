<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalUsers = User::count();
        $totalStudents = User::whereHas('role', fn ($q) => $q->where('slug', 'student'))->count();
        $totalInstructors = User::whereHas('role', fn ($q) => $q->where('slug', 'instructor'))->count();
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $pendingInstructors = User::whereHas('role', fn ($q) => $q->where('slug', 'instructor'))
            ->where('is_approved', false)
            ->count();

        $recentUsers = User::with('role')->latest()->take(10)->get();
        $recentCourses = Course::with('instructor')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalInstructors',
            'totalCourses',
            'totalEnrollments',
            'pendingInstructors',
            'recentUsers',
            'recentCourses'
        ));
    }
}
