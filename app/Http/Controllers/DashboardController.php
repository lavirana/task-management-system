<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = Cache::remember('dashboard_stats', 60, function () {
            return [
                'pending_tasks'     => Task::where('status', 'pending')->count(),
                'in_progress_tasks' => Task::where('status', 'in_progress')->count(),
                'completed_tasks'   => Task::where('status', 'done')->count(),
                'total_task'        => Task::count(),
                'total_users'       => User::count(),
            ];
        });

        $tasks = Cache::remember('dashboard_recent_tasks', 30, function () {
            return Task::with('assignedUser')
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();
        });

        return view('dashboard', compact('stats', 'tasks'));
    }
}