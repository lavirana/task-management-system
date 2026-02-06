@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Edit Task</h2>
    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
        @csrf
        @method('PUT')
        <input type="text" name="title" value="{{ $task->title }}" class="w-full border p-2 mb-3">
        <textarea name="description" class="w-full border p-2 mb-3">{{ $task->description }}</textarea>

        <select name="status" class="w-full border p-2 mb-3">
            <option value="pending" @selected($task->status=='pending')>Pending</option>
            <option value="in_progress" @selected($task->status=='in_progress')>In Progress</option>
            <option value="done" @selected($task->status=='done')>Done</option>
        </select>
    <select name="priority" class="w-full border p-2 mb-3">
        <option value="">All Priority</option>
        <option value="low" @selected($task->priority=='low')>Low</option>
        <option value="medium" @selected($task->priority=='medium')>Medium</option>
        <option value="high" @selected($task->priority=='high')>High</option>
    </select>
        <label for="assigned_date">Assigned Date</label>
        <input type="date" name="assigned_date" value="{{ $task->assigned_date }}" class="w-full border p-2 mb-3">
        <label for="due_date">Due Date</label>
        <input type="date" name="due_date" value="{{ $task->due_date }}" class="w-full border p-2 mb-3">
        
        <label for="">Assigned User</label>
        <select name="assigned_to_user_id" class="w-full border p-2 mb-3">
            <option value="">Select User</option>
            @foreach($users as $user)
            <option value="{{ $user->id }}" @selected($task->assigned_to_user_id == $user->id)>{{ $user->name }}</option>
            @endforeach
        </select>    
        <input type="submit" name="submit" value="Update Task" class="bg-green-600 text-white px-4 py-2 rounded">
    </form>
</div>
@endsection
