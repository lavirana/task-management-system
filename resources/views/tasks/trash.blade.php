@extends('layouts.app')

@section('content')
<div class="container">
    <h3>🗑 Trash Tasks</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Deleted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->deleted_at }}</td>
                <td>
                    <form action="{{ route('tasks.restore', $task->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-success btn-sm">Restore</button>
                    </form>

                    <form action="{{ route('tasks.forceDelete', $task->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete Permanently</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
