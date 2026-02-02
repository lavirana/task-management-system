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
                  
        
                <td>  
                    <select name="task_status" data-task-id="{{ $task->id }}">
                        <option value="in_progress" <?php if(isset($task->status) && $task->status == 'in_progress') echo 'selected'; ?>>In Progress</option>
                        <option value="pending" <?php if(isset($task->status) && $task->status == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="done" <?php if(isset($task->status) && $task->status == 'done') echo 'selected'; ?>>Completed</option>
                    </select>
                </td>
                <td>{{ ucfirst($task->priority) }}</td>
                <td>{{ $task->assigned_date }}</td>
                <td>{{ $task->due_date }}</td>
                <td>
                <select name="assign_user" data-task-id="{{ $task->id }}">
                <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" <?php if(isset($task->assignedUser) && $task->assignedUser->id == $user->id) echo 'selected'; ?>>
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

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection


<script>
document.addEventListener('change', function (e) { 
    // document = poora HTML page 👉 addEventListener('change', …) = jab bhi page par koi input / select change ho
    //e = ek event object hai jo batata hai: kaunsa element, kab aur kaise change hua.
    if (e.target.name === 'assign_user') {
        let user_id = e.target.value;
        let task_id = e.target.dataset.taskId;
        if (!user_id || !task_id) return;
        fetch('/tasks/assign_user', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                user_id: user_id,
                task_id: task_id
            })
        })
        .then(res => res.json())
        .then(data => {
           // console.log('Assigned successfully');
            alert('User assigned successfully');
        })
        .catch(err => console.error(err));
    }

    if(e.target.name === 'task_status'){
         let status = e.target.value;
        let task_id = e.target.dataset.taskId;
        if (!status || !task_id) return;
        fetch('/tasks/change_status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                status: status,
                task_id: task_id
            })
        })
        .then(res => res.json())
        .then(data => {
            //console.log('Status updated successfully');
            alert('Task status updated successfully');
        })
        .catch(err => console.error(err));
    }

});
</script>

