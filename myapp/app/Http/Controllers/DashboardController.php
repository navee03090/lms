<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        $user = auth()->user();

        if (! $user->role) {
            return redirect()->route('profile.edit')
                ->with('warning', 'Please complete your profile. Your role will be assigned by an administrator.');
        }

        return match ($user->role->slug) {
            'admin' => redirect()->route('admin.dashboard'),
            'instructor' => redirect()->route('instructor.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            default => redirect()->route('profile.edit'),
        };
    }
}
