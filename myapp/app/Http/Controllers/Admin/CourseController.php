<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Course::with(['instructor', 'category'])
            ->withCount(['enrollments', 'lessons', 'reviews'])
            ->withAvg('reviews', 'rating');

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $courses = $query->latest()->paginate(20);

        return view('admin.courses.index', compact('courses'));
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->forceDelete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted permanently!');
    }
}
