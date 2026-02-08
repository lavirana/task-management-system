<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;

class TaskController extends Controller
{
    public function index(Request $request){
        $query = Task::with('assignedUser'); 
            if($request->filled('status')){
                $query->where('status',$request->status);
            }
            if($request->filled('priority')){
                $query->where('priority', $request->priority);
            }
            $tasks = $query->latest()->paginate(10);
            $users = User::select('id', 'name')->get();
            return view('tasks.index', compact('tasks', 'users'));
    }
    public function create(){
        $users = User::select('id', 'name')->get();
           return view('tasks.create', compact('users'));
    }
    public function store(Request $request)
{
    $validate = $request->validate([
        'title' => 'required',
        'description' => 'required',
        'priority' => 'required',
        'due_date' => 'required',
        'assigned_to_user_id' => 'nullable|exists:users,id'
    ]);

    $task = Task::create([
        'title' => $validate['title'],
        'description' => $validate['description'],
        'priority' => $validate['priority'],
        'assigned_to_user_id' => $validate['assigned_to_user_id'] ?? null,
        'due_date' => $validate['due_date'],
        'status' => 'pending',
        'created_by_admin_id' => auth()->id(),
    ]);

    logActivity(
        'Task created',
        $task,
        null,
        $validate
    );

    $assignedUser = User::find($request->assigned_to_user_id);
    $assignedUser->notify(new TaskAssignedNotification($task));

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
    //dd($validated);

    $task = Task::findOrFail($id);
    $oldValues = $task->only([
        'title',
        'description',
        'status'
    ]);

    $task->update($validated);

    logActivity(
        'Task updated',
        $task,
        $oldValues,
        $validated
    );

    return redirect()
        ->route('tasks.index')
        ->with('success', 'Task updated successfully!');
}

    public function edit($id){
        $query = Task::with('assignedUser'); 
        $task = $query->findOrFail($id);
        $users = User::select('id', 'name')->get();
        return view('tasks.edit',compact('task', 'users'));
    }
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
    
        // save task data BEFORE delete
        $oldValues = $task->toArray();
    
        $task->delete();
    
        logActivity(
            'Task Deleted',
            null,          // task is gone
            $oldValues,    // <-- THIS is important
            null
        );
    
        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }
    
    
    public function view($id){
        $task = Task::with('comments.user')->findOrFail($id);
        return view('tasks.show', compact('task'));
    }
    public function taskCount(Request $request, $status = null)
    {
        $query = Task::query();
        if (!empty($status)) {
            $query->where('status', $status);
        }
        $taskCount = $query->count();
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
        try{
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
        try{
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
    public function updateAssignedDate(Request $request){
        try{
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
}
