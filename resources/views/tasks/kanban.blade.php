@extends('layouts.app')
@section('content')
<div class="container" x-data="kanbanBoard()">
    <h2 class="text-xl font-bold mb-4">Kanban Board</h2>
    <div class="grid grid-cols-3 gap-4">
        <!-- Pending -->
        <div class="bg-gray-200 p-3 rounded"
             @dragover.prevent
             @drop="dropTask($event, 'pending')">   
            <h3 class="font-semibold mb-2">Pending</h3>
            @foreach($tasks->where('status','pending') as $task)
                <div class="bg-white p-2 mb-2 shadow rounded cursor-move"
                     draggable="true"
                     @dragstart="dragTask($event, {{ $task->id }})">
                    {{ $task->title }}
                </div>
            @endforeach
        </div>
        <!-- In Progress -->
        <div class="bg-blue-100 p-3 rounded"
             @dragover.prevent
             @drop="dropTask($event, 'in_progress')">
            <h3 class="font-semibold mb-2">In Progress</h3>
            @foreach($tasks->where('status','in_progress') as $task)
                <div class="bg-white p-2 mb-2 shadow rounded cursor-move"
                     draggable="true"
                     @dragstart="dragTask($event, {{ $task->id }})">
                    {{ $task->title }}
                </div>
            @endforeach
        </div>
        <!-- Done -->
        <div class="bg-green-100 p-3 rounded"
             @dragover.prevent
             @drop="dropTask($event, 'done')">
            <h3 class="font-semibold mb-2">Completed</h3>
            @foreach($tasks->where('status','done') as $task)
                <div class="bg-white p-2 mb-2 shadow rounded cursor-move"
                     draggable="true"
                     @dragstart="dragTask($event, {{ $task->id }})">
                    {{ $task->title }}
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
