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

    <!-- Task Table -->
    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">Title</th>
                <th>Status</th>
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
                <td class="p-3">{{ $task->title }}</td>
     
                @php
                    if ($task->status === 'pending') {
                        $task_status = 'Pending';
                    } elseif ($task->status === 'in_progress') {
                        $task_status = 'In Progress';
                    } else {
                        $task_status = 'Completed';
                    }
             @endphp

                <td>{{ ucfirst($task_status) }}</td>
                <td>{{ ucfirst($task->priority) }}</td>
                <td>{{ $task->assigned_date }}</td>
                <td>{{ $task->due_date }}</td>
                <td>{{ $task->assignedUser->name ?? 'Not Assigned' }}</td>
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

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
