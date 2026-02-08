<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use App\Models\Task;
use App\Notifications\TaskDueReminderNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(function () {

    logger('TASK DUE REMINDER SCHEDULER HIT');

    $tasks = Task::whereDate('due_date', Carbon::tomorrow())
    ->where('due_reminder_sent', false)
    ->whereNotNull('assigned_to_user_id')
    ->get();

foreach ($tasks as $task) {
    if ($task->assignedUser) {
        $task->assignedUser->notify(
            new TaskDueReminderNotification($task)
        );

        // 🔒 mark as sent
        $task->update([
            'due_reminder_sent' => true
        ]);
    }
}

})->everyMinute();


