@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Task Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-5 rounded shadow">
    <h2 class="text-gray-600">In Progress Tasks</h2>
    <p class="text-3xl font-bold" id="progressTasks">
        {{ $stats['in_progress_tasks'] }}
    </p>
</div>

<div class="bg-yellow-100 p-5 rounded shadow">
    <h2 class="text-gray-600">Pending Tasks</h2>
    <p class="text-3xl font-bold" id="pendingTasks">
        {{ $stats['pending_tasks'] }}
    </p>
</div>

<div class="bg-green-100 p-5 rounded shadow">
    <h2 class="text-gray-600">Completed Tasks</h2>
    <p class="text-3xl font-bold" id="completedTasks">
        {{ $stats['completed_tasks'] }}
    </p>
</div>

<div class="bg-gray-100 p-5 rounded shadow">
    <h2 class="text-blue-600">Total Tasks</h2>
    <p class="text-3xl font-bold" id="totalTasks">
        {{ $stats['total_task'] }}
    </p>
</div>

<div class="bg-gray-100 p-5 rounded shadow">
    <h2 class="text-blue-600">Total Users</h2>
    <p class="text-3xl font-bold" id="totalUsers">
        {{ $stats['total_users'] }}
    </p>
</div>
<div class="bg-gray-100 p-5 rounded shadow kanban-header">
    <h2 class="text-blue-600">Project Board</h2>
    <p class="text-3xl font-bold">Total Tasks: {{ $boardData['total_tasks'] }}</p>
    <p class="text-3xl font-bold">Last Sync: {{ $boardData['last_updated'] }}</p>
</div>
    </div>
    <br>
    <hr>
    <br>
    <div class="grid grid-cols-2 gap-6">
    <div id="top_x_div" style="width: 600px; height: 480px;"></div>

<div id="tableWrapper" class="overflow-x-auto bg-white shadow rounded-lg dark:bg-gray-800" style="padding: 10px;">
        <table id="example" class="table table-striped nowrap" style="width:100%;">
        <thead >
            <tr>
                <th>Task</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ ucfirst($task->title) }}</td>
                <td>{{ $task->due_date }}</td>
                <td>
                    @if($task->status == 'in_progress')
                        In Progress
                    @elseif($task->status == 'pending')
                        Pending
                    @else
                        Completed
                    @endif
                </td>
              
                <td>{{ $task->assignedUser->name ?? 'Not Assigned' }}</td>
                
            </tr>
        @endforeach 
        </tbody>
    </table>
</div>
    </div>
    <br>
<br>


<div class="grid grid-cols-1">
<div class="flex gap-4 p-12 bg-slate-900">
    @foreach($groupedTasks as $status => $tasks)
        <div class="flex-1 min-w-[300px] bg-slate-800 rounded-lg p-4 border-t-4 border-emerald-400">
            <h3 class="text-white font-bold uppercase mb-4">{{ $status }}</h3>

            <div class="space-y-3">
                {{-- Ab us status ke andar ke tasks ka loop chalayein --}}
                @foreach($tasks as $task)
                    <div class="bg-slate-700 p-3 rounded">
                        <p class="text-slate-200">{{ $task->title }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
    </div>

</div>
@endsection

