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
     * The Trigger: You use View::composer(['kanban.*', 'dashboard'], ...). This tells Laravel: "Every time someone opens a page inside the kanban folder or the dashboard page, run this logic first".
     * The Data Fetching: Inside that block, the code asks the database for information, like the total number of tasks using Task::count().
     * The Delivery: Using $view->with('boardData', ...), Laravel "injects" that data into your Blade file.
     * The Result: Now, in your dashboard.blade.php, you can simply type {{ $boardData['total_tasks'] }} without ever passing it from your Controller.
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
