<?php

namespace App\Notifications;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseEnrolledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Course $course
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'course_enrolled',
            'message' => "You have successfully enrolled in {$this->course->title}",
            'course_id' => $this->course->id,
            'course_title' => $this->course->title,
            'url' => route('courses.learn', $this->course),
        ];
    }
}
