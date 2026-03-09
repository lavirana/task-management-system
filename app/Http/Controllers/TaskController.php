<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Tag;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Support\Facades\Cache;
use App\Services\TaskService;
use Illuminate\Support\Facades\Log;
use App\TaskRepositoryInterface;
use App\Contexts\SessionContext;
use App\NotifierInterface;


class TaskController extends Controller
{
    protected $taskService;
    protected $taskRepository;
    protected $notifier;

    public function __construct(TaskService $taskService, TaskRepositoryInterface $taskRepository, NotifierInterface $notifier)
    {
        $this->taskService = $taskService;
        $this->taskRepository = $taskRepository;
        //$this->middleware('auth');
    }


    public function allTasks(){
        return $this->taskRepository->getAllTasks();
    }

    public function viewtaskById($id){
        return $this->taskService->getTaskById($id);
    }

    public function index(Request $request, SessionContext $context){
        $userId = auth()->id();
        $status = $request->get('status', '');
        $priority = $request->get('priority', '');
        $workspaceid = $context->getActiveWorkspaceId();
        //dd($workspaceid);

        // unique cache key per user + filters
        $cachekey = "task_list_{$userId}_status_{$status}_priority_{$priority}";
        $tasks = Cache::remember($cachekey, 60, function() use ($request, $userId){
            $query = Task::with('assignedUser');

            if(auth()->user()->role !== 'admin'){
                $query->where('assigned_to_user_id', $userId);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('priority')) {
                $query->where('priority', $request->priority);
            }
        return $query->latest()->paginate(10);
        });
        $users = Cache::remember('all_users_list',120,function(){
            return User::select('id', 'name')->get();
        });

        $projects = Cache::remember('all_projects_list', 120, function () {
            return Project::select('id', 'name')->get();
        });
        return view('tasks.index',compact('tasks', 'users', 'projects', 'workspaceid'));
    }

  /*  public function index(Request $request)
    {
        $query = Task::with('assignedUser');

        if (auth()->user()->role !== 'admin') {
            $query->where('assigned_to_user_id', auth()->id());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        $tasks = $query->latest()->paginate(10);
        $users = User::select('id', 'name')->get();
        $projects = Project::select('id', 'name')->get();

        return view('tasks.index', compact('tasks', 'users', 'projects'));
    }
*/

    public function create()
    {
        $users = User::select('id', 'name')->get();
        $projects = Project::select('id', 'name')->get();
        $tags = Tag::all();

        return view('tasks.create', compact('users', 'projects', 'tags'));
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'project_id' => 'nullable|exists:projects,id',
            'description' => 'required',
            'priority' => 'required',
            'due_date' => 'required',
            'assigned_to_user_id' => 'nullable|exists:users,id'
        ]);

        $task = Task::create([
            'title' => $validate['title'],
            'project_id' => $validate['project_id'],
            'description' => $validate['description'],
            'priority' => $validate['priority'],
            'assigned_to_user_id' => $validate['assigned_to_user_id'] ?? null,
            'due_date' => $validate['due_date'],
            'attachments.*' => 'nullable|file|max:2048',
            'status' => 'pending',
            'created_by_admin_id' => auth()->id(),
        ]);

        //Attach Tags
        if ($request->filled('tags')) {
            $task->tags()->attach($request->tags);
        }

        //store file
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $task->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                ]);
            }
        }

        //maintain log activity
        logActivity(
            'Task created',
            $task,
            null,
            $validate
        );

        // --- CONTEXTUAL BINDING NOTIFICATION START ---
        $this->notifier->send("New Task: " . $task->title . " has been assigned to you.");
        // --- CONTEXTUAL BINDING NOTIFICATION END ---

        $assignedUser = User::find($request->assigned_to_user_id);
        $assignedUser->notify(new TaskAssignedNotification($task));
        $this->clearCache();
        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task Created successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required|in:pending,in_progress,done',
            'priority' => 'required|in:low,medium,high',
            'assigned_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'assigned_to_user_id' => 'nullable|exists:users,id',
        ]);

        $task = Task::findOrFail($id);

        // 🔥 OLD values for activity log
        $oldValues = $task->only([
            'title',
            'description',
            'status',
            'due_date',
        ]);

        // 🔥 IMPORTANT PART (REMINDER RESET LOGIC)
        if (
            isset($validated['due_date']) &&
            $task->due_date != $validated['due_date']
        ) {
            $task->due_reminder_sent = false;
        }

        // 🔥 Update task
        $task->update($validated);

        logActivity(
            'Task updated',
            $task,
            $oldValues,
            $validated
        );
        $this->clearCache();
        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }


    public function edit($id)
    {
        $query = Task::with('assignedUser');
        $task = $query->findOrFail($id);
        $users = User::select('id', 'name')->get();
        return view('tasks.edit', compact('task', 'users'));
    }
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only Admin can delete tasks');
        }

        // save task data BEFORE delete
        $oldValues = $task->toArray();

        $task->delete();

        logActivity(
            'Task Deleted',
            null,          // task is gone
            $oldValues,    // <-- THIS is important
            null
        );
        $this->clearCache();
        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }


    public function view($id)
    {
        $task = Task::with('comments.user')->findOrFail($id);
        return view('tasks.show', compact('task'));
    }
    public function taskCount(Request $request, $status = null)
    {
        $cacheKey = 'task_count_' . ($status ?? 'all');
        $taskCount = Cache::remember($cacheKey, 60, function () use ($status) {

            $query = Task::query();
            if (!empty($status)) {
                $query->where('status', $status);
            }
            return $query->count();
        });

        return response()->json(['count' => $taskCount]);
    }
    public function taskCountStatusWise(Request $request)
    {
        $statuses = ['pending', 'in_progress', 'Done'];
        $statusCounts = [];

        foreach ($statuses as $status) {
            $count = Task::where('status', $status)->count();
            $statusCounts[$status] = $count;
        }
        return response()->json($statusCounts);
    }
    public function assignTask(Request $request)
    {
        try {
            $task = Task::find($request->task_id);

            if (!$task) {
                return response()->json([
                    'error' => 'Task not found'
                ], 404);
            }

            $task->assigned_to_user_id = $request->user_id;
            $task->save();

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function changeStatus(Request $request)
    {
        try {
            $task = Task::find($request->task_id);

            if (!$task) {
                return response()->json([
                    'error' => 'Task not found'
                ], 404);
            }

            $task->status = $request->status;
            $task->save();

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function changePriority(Request $request)
    {
        try {
            $task = Task::find($request->task_id);

            if (!$task) {
                return response()->json([
                    'error' => 'Task not found'
                ], 404);
            }
            $task->priority = $request->priority;
            $task->save();

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateAssignedDate(Request $request)
    {
        try {
            $task = Task::find($request->task_id);

            if (!$task) {
                return response()->json([
                    'error' => 'Task not found'
                ], 404);
            }
            $task->assigned_date = $request->assigned_date;
            $task->save();

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function calendar()
    {
        return view('tasks.calendar');
    }
    public function calendarData()
    {
        $tasks = Task::whereNotNull('due_date')->get();
        return response()->json(
            $tasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'start' => $task->due_date,
                    'url' => route('tasks.edit', $task->id), // optional
                ];
            })
        );
    }

    public function updateStatusKanban(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->update([
            'status' => $request->status
        ]);
        Cache::forget('task_count_all');
        Cache::forget('task_count_pending');
        Cache::forget('task_count_in_progress');
        Cache::forget('task_count_done');
        return response()->json(['success' => true]);
    }

    public function kanban()
    {
        $tasks = Task::all();
        return view('tasks.kanban', compact('tasks'));
    }

    public function trash()
    {
        $tasks = Task::onlyTrashed()->get();
        return view('tasks.trash', compact('tasks'));
    }
    public function restore($id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task->restore();
        return redirect()->route('tasks.trash')->with('success', 'Task restored successfully.');
    }
    public function forceDelete($id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task->forceDelete();

        return redirect()->route('tasks.trash')->with('success', 'Task permanently deleted.');
    }

    // Add this private method at bottom of TaskController:
    private function clearCache()
    {

        $userId = auth()->id();

    // Clear dashboard cache
    Cache::forget('dashboard_stats');
    Cache::forget('dashboard_recent_tasks');

    $statuses   = ['', 'pending', 'in_progress', 'done'];
    $priorities = ['', 'low', 'medium', 'high'];

    foreach ($statuses as $status) {
        foreach ($priorities as $priority) {
                Cache::forget("task_list_{$userId}_status_{$status}_priority_{$priority}");
        }
    }

        Cache::forget('dashboard_stats');
        Cache::forget('dashboard_recent_tasks');
        // Also clear existing cache keys you already have:
        Cache::forget('task_count_all');
        Cache::forget('task_count_pending');
        Cache::forget('task_count_in_progress');
        Cache::forget('task_count_done');
    }
}
