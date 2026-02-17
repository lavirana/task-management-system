<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function index(Request $request){
        $query = Task::query();
        if($request->status){
            $query->where('status', $request->status);
        }
        if($request->search){
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if($request->sort_by){
            $query->orderBy($request->sort_by, 'desc');
        }
        return TaskResource::collection($query->paginate(10));
    }

    public function store(Request $request){
        $task = Task::create([
            'title' => $request->title,
            'status' => 'pending',
            'user_id' => $request->user()->id
        ]);
        return response()->json($task);
    }
}
