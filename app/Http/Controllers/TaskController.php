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

    public function create(Request $request){
           
    }

    public function update(){

    }

    public function delete(){

    }
}
