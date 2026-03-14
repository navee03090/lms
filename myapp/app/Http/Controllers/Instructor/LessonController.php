<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonMaterial;
use App\Notifications\NewLessonNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LessonController extends Controller
{
    public function index(Course $course): View
    {
        $this->authorize('update', $course);
        $lessons = $course->lessons()->with('materials')->orderBy('order')->get();

        return view('instructor.lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course): View
    {
        $this->authorize('update', $course);

        return view('instructor.lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video' => 'nullable|file|mimes:mp4,webm|max:102400', // 100MB
            'duration_minutes' => 'nullable|integer|min:0',
            'is_free' => 'boolean',
        ]);

        $order = $course->lessons()->max('order') + 1;
        $validated['order'] = $order;
        $validated['is_free'] = $request->boolean('is_free');

        if ($request->hasFile('video')) {
            $validated['video_path'] = $request->file('video')->store('lessons/videos', 'public');
        }

        $lesson = $course->lessons()->create($validated);

        // Notify enrolled students
        foreach ($course->enrollments as $enrollment) {
            $enrollment->user->notify(new NewLessonNotification($course, $lesson));
        }

        if ($request->hasFile('materials')) {
            foreach ($request->file('materials') as $index => $file) {
                $path = $file->store('lessons/materials', 'public');
                $lesson->materials()->create([
                    'title' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('instructor.courses.lessons.index', $course)
            ->with('success', 'Lesson created successfully!');
    }

    public function edit(Lesson $lesson): View
    {
        $course = $lesson->course;
        $this->authorize('update', $course);
        $lesson->load('materials');

        return view('instructor.lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Lesson $lesson): RedirectResponse
    {
        $course = $lesson->course;
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video' => 'nullable|file|mimes:mp4,webm|max:102400',
            'duration_minutes' => 'nullable|integer|min:0',
            'order' => 'nullable|integer|min:0',
            'is_free' => 'boolean',
        ]);

        $validated['is_free'] = $request->boolean('is_free');

        if ($request->hasFile('video')) {
            Storage::disk('public')->delete($lesson->video_path);
            $validated['video_path'] = $request->file('video')->store('lessons/videos', 'public');
        }

        $lesson->update($validated);

        return redirect()->route('instructor.courses.lessons.index', $course)
            ->with('success', 'Lesson updated successfully!');
    }

    public function destroy(Lesson $lesson): RedirectResponse
    {
        $course = $lesson->course;
        $this->authorize('update', $course);
        $lesson->delete();

        return redirect()->route('instructor.courses.lessons.index', $course)
            ->with('success', 'Lesson deleted successfully!');
    }

    public function addMaterial(Request $request, Lesson $lesson): RedirectResponse
    {
        $course = $lesson->course;
        $this->authorize('update', $course);

        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = $request->file('file')->store('lessons/materials', 'public');
        $lesson->materials()->create([
            'title' => $request->title,
            'file_path' => $path,
            'file_type' => $request->file('file')->getClientOriginalExtension(),
            'order' => $lesson->materials()->max('order') + 1,
        ]);

        return back()->with('success', 'Material added successfully!');
    }

    public function removeMaterial(Lesson $lesson, LessonMaterial $material): RedirectResponse
    {
        if ($material->lesson_id !== $lesson->id) {
            abort(404);
        }
        $course = $lesson->course;
        $this->authorize('update', $course);
        Storage::disk('public')->delete($material->file_path);
        $material->delete();

        return back()->with('success', 'Material removed!');
    }
}
