<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\NotifierInterface;
use App\Services\EmailNotifier;
use App\Services\DatabaseNotifier;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bindings for Task Management System
        $this->app->when(TaskController::class)
                  ->needs(NotifierInterface::class)
                  ->give(EmailNotifier::class);

        $this->app->when(CommentController::class)
                  ->needs(NotifierInterface::class)
                  ->give(DatabaseNotifier::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
