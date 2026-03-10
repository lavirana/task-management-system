<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Stats for the top cards
        $stats = Cache::remember('dashboard_stats', 60, function () {
            return [
                'pending_tasks' => Task::where('status', 'pending')->count(),
                'in_progress_tasks' => Task::where('status', 'in_progress')->count(),
                'completed_tasks' => Task::where('status', 'done')->count(),
                'total_task' => Task::count(),
                'total_users' => User::count(),
            ];
        });
    
        // 2. Fetch ALL tasks (no ->take(5) and no status filter)
        $tasks = Task::with('assignedUser')->get();
    
        // 3. Use your macro on the full list
        $groupedTasks = $tasks->groupByStatus();
    
        return view('dashboard', compact('tasks', 'stats', 'groupedTasks'));
    }
}