<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::with('user')->get();
        return view('tasks.index', compact('tasks'));
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
    

  
}
