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
        ->whereNotNull('assigned_to_user_id')
        ->get();

    foreach ($tasks as $task) {
        logger('Sending reminder for task ID: '.$task->id);

        if ($task->assignedUser) {
            $task->assignedUser->notify(
                new TaskDueReminderNotification($task)
            );
        }
    }

})->everyMinute();


