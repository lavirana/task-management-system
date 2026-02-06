@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-4">Activity Logs</h1>

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">User</th>
                <th class="text-left">Action</th>
                <th class="text-left">Task Title</th>
                <th class="text-left">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr class="border-t">
                <td class="p-3">{{ $log->user->name }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $log->action)) }}</td>
                <td>{{ $log->task ? $log->task->title : 'N/A' }}</td>
                <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection