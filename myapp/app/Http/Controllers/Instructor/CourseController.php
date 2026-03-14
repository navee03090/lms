<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService
    ) {}

    public function index(): View
    {
        $courses = auth()->user()->coursesAsInstructor()
            ->withCount(['lessons', 'enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->latest()
            ->paginate(10);

        return view('instructor.courses.index', compact('courses'));
    }

    public function create(): View
    {
        $categories = Category::all();

        return view('instructor.courses.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'is_published' => 'boolean',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $course = $this->courseService->create($validated, auth()->user());

        if ($request->hasFile('thumbnail')) {
            $this->courseService->uploadThumbnail($course, $request->file('thumbnail'));
        }

        return redirect()->route('instructor.courses.edit', $course)
            ->with('success', 'Course created successfully!');
    }

    public function edit(Course $course): View|RedirectResponse
    {
        $this->authorize('update', $course);
        $course->load(['lessons', 'quizzes.questions.options']);
        $categories = Category::all();

        return view('instructor.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'is_published' => 'boolean',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $this->courseService->update($course, $validated);

        if ($request->hasFile('thumbnail')) {
            $this->courseService->uploadThumbnail($course, $request->file('thumbnail'));
        }

        return redirect()->route('instructor.courses.edit', $course)
            ->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $this->authorize('delete', $course);
        $course->delete();

        return redirect()->route('instructor.courses.index')
            ->with('success', 'Course deleted successfully!');
    }

    public function analytics(Course $course): View
    {
        $this->authorize('update', $course);
        $course->loadCount(['enrollments', 'lessons', 'reviews']);
        $course->loadAvg('reviews', 'rating');
        $enrollments = $course->enrollments()->with('user')->latest()->paginate(20);

        return view('instructor.courses.analytics', compact('course', 'enrollments'));
    }
}
