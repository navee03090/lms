<?php

namespace App\Notifications;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class QuizResultNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Quiz $quiz,
        public QuizAttempt $attempt
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'quiz_result',
            'message' => $this->attempt->passed
                ? "Congratulations! You passed the quiz: {$this->quiz->title}"
                : "Quiz completed: {$this->quiz->title}. Score: {$this->attempt->percentage}%",
            'quiz_id' => $this->quiz->id,
            'attempt_id' => $this->attempt->id,
            'passed' => $this->attempt->passed,
            'percentage' => $this->attempt->percentage,
            'url' => route('courses.learn', $this->quiz->course),
        ];
    }
}
