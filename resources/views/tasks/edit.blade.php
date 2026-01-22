@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">

    <h2 class="text-xl font-bold mb-4">Edit Task</h2>

    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
        @csrf
        @method('PUT')

        <input type="text" name="title"
               value="{{ $task->title }}"
               class="w-full border p-2 mb-3">

        <textarea name="description"
                  class="w-full border p-2 mb-3">{{ $task->description }}</textarea>

        <select name="status" class="w-full border p-2 mb-3">
            <option value="pending" @selected($task->status=='pending')>Pending</option>
            <option value="in_progress" @selected($task->status=='in_progress')>In Progress</option>
            <option value="done" @selected($task->status=='done')>Done</option>
        </select>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Update Task
        </button>
    </form>

</div>
@endsection
