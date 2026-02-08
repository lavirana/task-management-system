<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskDueReminderNotification extends Notification
{
    public function __construct(public $task) {}

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'message' => 'Reminder: Task "' . $this->task->title . '" is due tomorrow',
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Task Due Tomorrow')
            ->line('Your task "' . $this->task->title . '" is due tomorrow.')
            ->action('View Task', url('/tasks/' . $this->task->id));
    }
}
