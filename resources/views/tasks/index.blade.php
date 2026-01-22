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
    <form method="GET" class="flex gap-4 mb-6">
        <select name="status" class="border rounded p-2">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="done">Done</option>
        </select>

        <select name="priority" class="border rounded p-2">
            <option value="">All Priority</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
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
                <th>Due Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($tasks as $task)
            <tr class="border-t">
                <td class="p-3">{{ $task->title }}</td>
                <td>{{ ucfirst($task->status) }}</td>
                <td>{{ ucfirst($task->priority) }}</td>
                <td>{{ $task->due_date }}</td>
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
