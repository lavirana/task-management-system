@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Tasks</h1>
        <a href="{{ route('tasks.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Create Task
        </a>
    </div>
    <!-- Filters -->
    <form method="GET" action="{{ route('tasks.index') }}" class="flex gap-4 mb-6">
    <select name="status" class="border rounded p-2">
        <option value="">All Status</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
            Pending
        </option>
        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>
            In Progress
        </option>
        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>
            Done
        </option>
    </select>
    <select name="priority" class="border rounded p-2">
        <option value="">All Priority</option>
        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>
            Low
        </option>
        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>
            Medium
        </option>
        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>
            High
        </option>
    </select>
        <button class="bg-gray-800 text-white px-4 rounded">
            Filter
        </button>
    </form>
    {{ $tasks->links() }}
    <br>
    <!-- Task Table -->
    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th>Project</th>
                <th class="p-3 text-left">Title</th>
                <th>Status</th>
                <th>Tags</th>
                <th>Priority</th>
                <th>Assigned Date</th>
                <th>Due Date</th>
                <th>Assigned User</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
        
            <tr class="border-t">
                <td class="p-3">{{ $task->project?->name ?? 'No Project' }}</td>
                <td>{{ $task->title }}</td>
                <td>  
                    <select name="task_status" data-task-id="{{ $task->id }}">
                        <option value="in_progress" <?php if(isset($task->status) && $task->status == 'in_progress') echo 'selected'; ?>>In Progress</option>
                        <option value="pending" <?php if(isset($task->status) && $task->status == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="done" <?php if(isset($task->status) && $task->status == 'done') echo 'selected'; ?>>Completed</option>
                    </select>
                </td>
                <td>
                @foreach($task->tags as $tag)
                    <span class="badge bg-info">
                        #{{ $tag->name }}
                    </span>
                @endforeach
                </td>
                <td>
                    <select name="task_priority" data-task-id="{{ $task->id }}">
                    <option value="low" <?php if(isset($task->priority) && $task->priority == 'low') echo 'selected'; ?>>Low</option>
                        <option value="medium" <?php if(isset($task->priority) && $task->priority == 'medium') echo 'selected'; ?>>Medium</option>
                        <option value="high" <?php if(isset($task->priority) && $task->priority == 'high') echo 'selected'; ?>>High</option>
                    </select>         
               </td>
                <td>
                    <input type="date" value="{{ $task->assigned_date }}" name="assigned_date" id="assigned_date" data-task-id="{{ $task->id }}">
                </td>
                <td>
                <input type="date" value="{{ $task->due_date }}" name="due_date" id="due_date" data-task-id="{{ $task->id }}">
                </td>
                <td>
                <select name="assign_user" data-task-id="{{ $task->id }}">
                <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" <?php if(isset($task->assignedUser) && $task->assignedUser->id == $user->id) echo 'selected'; ?>  <?php if(isset($task->assignedUser) && $task->assignedUser->role != 'admin') echo 'disabled'; ?>  >
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                </td>
                <td class="flex gap-2 p-2">
                    @can('update', $task)
                    <a href="{{ route('tasks.edit', $task->id) }}"
                       class="text-blue-600">Edit</a>
                    @endcan

                    @can('delete', $task)
                    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                    @endcan
                   <a href="{{ route('tasks.view', $task->id) }}"><button class="btn border-t-neutral-200">View Task</button></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection



