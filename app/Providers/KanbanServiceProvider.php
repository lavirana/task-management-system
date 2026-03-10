<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View; 

use App\Models\Task;

class KanbanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // This 'View Composer' runs whenever any 'kanban.*' view is loaded
        View::composer(['kanban.*','dashboard'], function ($view) {
            $view->with('boardData', [
                'total_tasks' => Task::count(),
                'status_list' => ['pending', 'In Progress', 'Done'],
                'last_updated' => now()->format('H:i')
            ]);
        });
    }
}
