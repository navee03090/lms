<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function index(Course $course): View
    {
        $this->authorize('update', $course);
        $quizzes = $course->quizzes()->withCount('questions')->orderBy('order')->get();

        return view('instructor.quizzes.index', compact('course', 'quizzes'));
    }

    public function create(Course $course): View
    {
        $this->authorize('update', $course);

        return view('instructor.quizzes.create', compact('course'));
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'nullable|integer|min:1',
            'pass_percentage' => 'required|integer|min:1|max:100',
        ]);

        $validated['order'] = $course->quizzes()->max('order') + 1;
        $course->quizzes()->create($validated);

        return redirect()->route('instructor.quizzes.index', $course)
            ->with('success', 'Quiz created successfully!');
    }

    public function edit(Course $course, Quiz $quiz): View
    {
        $this->authorize('update', $course);
        $quiz->load('questions.options');

        return view('instructor.quizzes.edit', compact('course', 'quiz'));
    }

    public function update(Request $request, Course $course, Quiz $quiz): RedirectResponse
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'nullable|integer|min:1',
            'pass_percentage' => 'required|integer|min:1|max:100',
        ]);

        $quiz->update($validated);

        return redirect()->route('instructor.quizzes.index', $course)
            ->with('success', 'Quiz updated successfully!');
    }

    public function destroy(Course $course, Quiz $quiz): RedirectResponse
    {
        $this->authorize('update', $course);
        $quiz->delete();

        return redirect()->route('instructor.quizzes.index', $course)
            ->with('success', 'Quiz deleted successfully!');
    }

    public function addQuestion(Request $request, Course $course, Quiz $quiz): RedirectResponse
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'points' => 'required|integer|min:1',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string',
            'options.*.is_correct' => 'boolean',
        ]);

        $order = $quiz->questions()->max('order') + 1;
        $question = $quiz->questions()->create([
            'question_text' => $validated['question_text'],
            'points' => $validated['points'],
            'order' => $order,
        ]);

        $optionKeys = ['A', 'B', 'C', 'D'];
        foreach ($validated['options'] as $index => $optionData) {
            $question->options()->create([
                'option_text' => $optionData['text'],
                'is_correct' => $optionData['is_correct'] ?? false,
                'option_key' => $optionKeys[$index] ?? $optionKeys[0],
                'order' => $index,
            ]);
        }

        return back()->with('success', 'Question added successfully!');
    }

    public function removeQuestion(Course $course, Quiz $quiz, Question $question): RedirectResponse
    {
        $this->authorize('update', $course);
        $question->options()->delete();
        $question->delete();

        return back()->with('success', 'Question removed!');
    }
}
