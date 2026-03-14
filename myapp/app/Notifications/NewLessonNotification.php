<?php

namespace App\Notifications;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewLessonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Course $course,
        public Lesson $lesson
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_lesson',
            'message' => "New lesson added to {$this->course->title}: {$this->lesson->title}",
            'course_id' => $this->course->id,
            'lesson_id' => $this->lesson->id,
            'url' => route('courses.learn', ['course' => $this->course, 'lesson' => $this->lesson]),
        ];
    }
}
