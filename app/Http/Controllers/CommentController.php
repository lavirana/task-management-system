<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    
    public function store (Request $request, $taskId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);
        Comment::create([
            'task_id' => $taskId,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);
     return back()->with('success', 'Comment added');
    }
}
