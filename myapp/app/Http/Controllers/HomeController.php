<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private CourseService $courseService
    ) {}

    public function index(): View
    {
        $featuredCourses = Course::with(['instructor', 'category'])
            ->where('is_published', true)
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::withCount('courses')->get();

        return view('home', compact('featuredCourses', 'categories'));
    }

    public function catalog(Request $request): View
    {
        $courses = $this->courseService->getPublishedCourses($request->all());
        $categories = Category::withCount('courses')->get();

        return view('courses.catalog', compact('courses', 'categories'));
    }
}
