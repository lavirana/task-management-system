<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskDueReminderNotification extends Notification
{
    use Queueable;

    public function __construct(public $task)
    {
    }

    public function via($notifiable)
    {
        return ['database']; // testing ke liye only database
    }

    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'title'   => $this->task->title,
            'message' => 'Task due tomorrow: ' . $this->task->title,
        ];
    }
}
