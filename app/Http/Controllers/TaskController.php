<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

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
           return view('tasks.create');
    }

    public function store(Request $request){
        $validate = $request->validate([
            'title' => 'required|max:20',
            'description' => 'required',
            'priority' => 'required',
            'due_date' => 'required'
        ]);

        // create task
        Task::create([
            'title' => $validate['title'],
            'description' => $validate['description'],
            'priority' => $validate['priority'],
            'due_date' => $validate['due_date'],
            'status' => 'pending',
            'created_by_admin_id' => auth()->id(),
        ]);
        return redirect()->route('tasks.index')->with('success', 'Task Created successfully!');

    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:20',
            'description' => 'required',
            'status' => 'required',
        ]);
    
        $task = Task::findOrFail($id);
        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }
    
    

    public function edit($id){
        $task = Task::findOrFail($id);
        return view('tasks.edit',compact('task'));
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }
    
    public function show($id){
        $task = Task::findOrFail($id);
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
    


  
}
