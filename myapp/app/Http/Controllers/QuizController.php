<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Notifications\QuizResultNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function start(Quiz $quiz): View
    {
        $course = $quiz->course;
        if (! auth()->user()->hasEnrolledIn($course)) {
            abort(403, 'You must be enrolled in this course to take the quiz.');
        }

        $quiz->load('questions.options');

        return view('quizzes.start', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz): RedirectResponse
    {
        $course = $quiz->course;
        if (! auth()->user()->hasEnrolledIn($course)) {
            abort(403);
        }

        $quiz->load('questions.options');
        $answers = $request->input('answers', []);
        $score = 0;
        $totalPoints = 0;

        foreach ($quiz->questions as $question) {
            $totalPoints += $question->points;
            $selectedOptionId = $answers[$question->id] ?? null;
            if ($selectedOptionId) {
                $correctOption = $question->options->firstWhere('is_correct', true);
                if ($correctOption && $correctOption->id == $selectedOptionId) {
                    $score += $question->points;
                }
            }
        }

        $percentage = $totalPoints > 0 ? round(($score / $totalPoints) * 100, 2) : 0;
        $passed = $percentage >= $quiz->pass_percentage;

        $attempt = QuizAttempt::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total_questions' => $quiz->questions->count(),
            'percentage' => $percentage,
            'passed' => $passed,
            'time_taken_seconds' => $request->input('time_taken'),
            'answers' => $answers,
            'started_at' => now()->subSeconds($request->input('time_taken', 0)),
            'completed_at' => now(),
        ]);

        auth()->user()->notify(new QuizResultNotification($quiz, $attempt));

        return redirect()->route('quizzes.result', $attempt)
            ->with('success', $passed ? 'Congratulations! You passed!' : 'Quiz completed. Better luck next time!');
    }

    public function result(QuizAttempt $attempt): View
    {
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        $attempt->load('quiz.course');

        return view('quizzes.result', compact('attempt'));
    }
}
