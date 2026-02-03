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
                <td>
                    <select name="task_priority" data-task-id="{{ $task->id }}">
                    <option value="low" <?php if(isset($task->priority) && $task->priority == 'low') echo 'selected'; ?>>Low</option>
                        <option value="medium" <?php if(isset($task->priority) && $task->priority == 'medium') echo 'selected'; ?>>Medium</option>
                        <option value="high" <?php if(isset($task->priority) && $task->priority == 'high') echo 'selected'; ?>>High</option>
                    </select>
                
               </td>
                <td>
                    <input type="date" value="{{ $task->assigned_date }}" name="assigned_date" id="assigned_date" data-task-id="{{ $task->id }}">
                </td>
                <td>
                <input type="date" value="{{ $task->due_date }}" name="due_date" id="due_date" data-task-id="{{ $task->id }}">
                </td>
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
            //alert('User assigned successfully');
            Toastify({
                    text: "User Assigned successfully",
                    className: "info",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                }).showToast();
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
                Toastify({
                    text: "Task status updated successfully",
                    className: "info",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                }).showToast();
        })
        .catch(err => console.error(err));
    }
    if(e.target.name === 'task_priority'){
         let priority = e.target.value;
        let task_id = e.target.dataset.taskId;
        if (!priority || !task_id) return;
        fetch('/tasks/change_priority', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                priority: priority,
                task_id: task_id
            })
        })
        .then(res => res.json())
        .then(data => {
                Toastify({
                    text: "Task priority updated successfully",
                    className: "info",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                }).showToast();
        })
        .catch(err => console.error(err));
    }
    if(e.target.name === 'assigned_date'){
        let assigned_date = e.target.value;
        let task_id = e.target.dataset.taskId;
        if (!assigned_date || !task_id) return;

        fetch('/tasks/update_assigned_date', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({
                task_id: task_id,
                assigned_date: assigned_date
            })
        })
        .then(res => res.json())
        .then(data => {
           //alert('Assigned date updated successfully');
            Toastify({
                    text: "Assigned date updated successfully",
                    className: "info",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                }).showToast();
        })
        .catch(err => console.error(err));
    }
});



</script>

