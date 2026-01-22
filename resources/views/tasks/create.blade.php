@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">

    <h2 class="text-xl font-bold mb-4">Create Task</h2>

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <input type="text" name="title" placeholder="Task Title"
               class="w-full border p-2 mb-3">

        <textarea name="description" placeholder="Description"
                  class="w-full border p-2 mb-3"></textarea>

        <select name="priority" class="w-full border p-2 mb-3">
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>

        <input type="date" name="due_date"
               class="w-full border p-2 mb-3">

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Save Task
        </button>
    </form>

</div>
@endsection
