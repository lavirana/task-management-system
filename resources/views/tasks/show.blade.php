@extends('layouts.app')
@section('content')
<!-- Content -->
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Task Details</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <p class="text-gray-500">Title</p>
            <p class="font-semibold">{{ $task->title }}</p>
        </div>
        <div>
            <p class="text-gray-500">Status</p>
            <?php 
            if($task->status == 'in_progress'){
                $tstatus = 'In Progress';
            }elseif($task->status == 'done'){
                $tstatus = 'Completed';
            }else{
                $tstatus = 'Pending';
            }
            ?>
            <p class="font-semibold capitalize">{{ $tstatus }}</p>
        </div>

        <div>
            <p class="text-gray-500">Priority</p>
            <p class="font-semibold capitalize">{{ $task->priority }}</p>
        </div>

        <div>
            <p class="text-gray-500">Assigned User</p>
            <p class="font-semibold">
                {{ $task->assignedUser->name ?? 'Not Assigned' }}
            </p>
        </div>

        <div>
            <p class="text-gray-500">Assigned Date</p>
            <p class="font-semibold">
                {{ $task->assigned_date ?? '-' }}
            </p>
        </div>

        <div>
            <p class="text-gray-500">Due Date</p>
            <p class="font-semibold">
                {{ $task->due_date ?? '-' }}
            </p>
        </div>

        <div class="md:col-span-2">
            <p class="text-gray-500">Description</p>
            <p class="font-semibold">
                {{ $task->description ?? 'No description provided.' }}
            </p>
        </div> 
        @if($task->attachments->count())
                @foreach($task->attachments as $file)   
                        <img src="{{ asset('storage/'.$file->file_path) }}" alt="">   
                @endforeach       
        @endif
    </div>

    <!-- Actions -->
    <div class="mt-6 flex gap-4">
        <a href="{{ url('/tasks') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded">
            ← Back
        </a>

        <a href="{{ url('/edit/'.$task->id) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            Edit Task
        </a>
    </div>

</div>

<!-- Comments Section -->
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow mt-6">

    <h2 class="text-xl font-bold mb-4">Comments</h2>

    @if($task->comments->count())
        <div class="space-y-4">
            @foreach($task->comments as $comment)
                <div class="border-b pb-2">
                    <p class="text-sm text-gray-600">
                        {{ $comment->user->name ?? 'Guest' }}
                        · {{ $comment->created_at->diffForHumans() }}
                    </p>
                    <p class="mt-1">{{ $comment->comment }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">No comments yet.</p>
    @endif

    <!-- Add Comment -->
    <form method="POST"
          action="{{ route('tasks.comments.store', $task->id) }}"
          class="mt-4">
        @csrf

        <textarea name="comment"
                  rows="3"
                  class="w-full border rounded p-2"
                  placeholder="Write a comment..."></textarea>

        <button class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">
            Add Comment
        </button>
    </form>

</div>


@endsection

