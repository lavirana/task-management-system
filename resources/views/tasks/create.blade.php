@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">

    <h2 class="text-xl font-bold mb-4">Create Task</h2>
    @if ($errors->any())
    <div class="relative mb-4 rounded-lg border border-red-300 bg-red-50 p-4 text-red-700">
        <button class="absolute top-2 right-2 text-red-500 hover:text-red-700"
                onclick="this.parentElement.remove()">
            ✕
        </button>

        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif




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
