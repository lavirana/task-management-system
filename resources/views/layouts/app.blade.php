<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
       <!-- DataTables CSS -->
       <link href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" rel="stylesheet">
       <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">

       <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <nav class="bg-white shadow p-4 mb-6">
        <div class="max-w-8xl mx-auto flex justify-between items-center">
            <!-- App Title -->
            <div class="font-bold text-lg">
                <a href="{{ route('dashboard') }}">
                Task Management System
                </a>
            </div>
            <!-- Menu -->
  <!-- Menu -->
<div class="relative space-x-6" style="margin-left: 23%;"
     x-data="{ open: false }">
     @auth
    <!-- Bell Icon -->
    <button @click="open = !open"
            class="relative focus:outline-none text-lg">
        🔔 
        @if(auth()->user()->unreadNotifications->count())
            <span
                class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-2">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>
    Notifications
    <!-- Dropdown -->
    <div x-show="open"
         @click.outside="open = false"
         class="absolute right-0 mt-2 w-72 bg-white shadow rounded z-50">
        <div class="px-3 py-2 font-semibold border-b">
            🔔 New Notifications
        </div>
        @forelse(auth()->user()->unreadNotifications as $notification)
                <div class="p-2 border-b hover:bg-gray-50">
                    {{-- Task Assigned --}}
                    @if($notification->type === 'App\\Notifications\\TaskAssignedNotification')
                        🧑‍💼 <strong>Task Assigned</strong><br>
                        {{ $notification->data['message'] ?? $notification->data['title'] }}
                    {{-- Task Due Reminder --}}
                    @elseif($notification->type === 'App\\Notifications\\TaskDueReminderNotification')
                        ⏰ <strong>Due Reminder</strong><br>
                        {{ $notification->data['message'] }}
                    @endif
                    <br>
                    <small class="text-gray-500">
                        {{ $notification->created_at->diffForHumans() }}
                    </small>
                </div>
                @empty
                <div class="p-2 text-gray-500 text-center">
                    No new notifications
                </div>
                @endforelse
              <a href="{{ route('notifications.index', auth()->id()) }}" style="padding: 5px;font-size: 14px;font-weight: 300;">All Notifications </a>
    </div>
</div>
@endauth
             <!-- Menu -->
                <div class="space-x-6"> 
                <a href="{{ route('tasks.kanban') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                         Kanban Board
                </a>
                <a href="{{ route('tasks.index') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium">
                    All Tasks
                </a>
                <a href="{{ route('tasks.create') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium">
                    Add Task
                </a>
                <a href="{{ route('tasks.calendar') }}">📅 Calendar</a>
                <a href="{{ route('logs.index') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium">
                    Check Activity Logs
                </a>
                <a href="{{ route('tasks.trash') }}">Trash</a>
                <form method="POST" action="{{ route('logout') }}" style="float: right;">
                    @csrf
                    <button
                        type="submit"
                        class="text-red-600 hover:text-red-800 font-semibold"
                    >Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Page Content -->
    <div class="max-w-7xl mx-auto">
        @yield('content')
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <!-- jQuery -->
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
      
      <!-- DataTables JS -->
      <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>
      <script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: "{{ route('tasks.calendar.data') }}",
        eventClick(info) {
            if (info.event.url) {
                info.jsEvent.preventDefault();
                window.location.href = info.event.url;
            }
        }
    });
    calendar.render();
});
</script>
@if(Route::is('dashboard'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/task_count/pending')
        .then(response => response.json())
        .then(data => {
            const el = document.getElementById('pendingTasks');
            if (el) el.innerText = data.count;
        });
});
document.addEventListener('DOMContentLoaded', function (){
    fetch('/task_count/done')
        .then(response => response.json())
        .then(data => {
            const completed = document.getElementById('completedTasks');
            if (completed) completed.innerText = data.count;
        });
})
document.addEventListener('DOMContentLoaded', function (){
    fetch('/task_count/in_progress')
        .then(response => response.json())
        .then(data => {
            const progress = document.getElementById('progressTasks');
            if (progress) progress.innerText = data.count;
        });
})
</script>
<script>
google.charts.load('current', { packages: ['bar'] });
google.charts.setOnLoadCallback(loadChartData);

function loadChartData() {
    fetch('http://127.0.0.1:8000/tasks/get_task_counts')
        .then(response => response.json())
        .then(data => {
            drawChart(data);
        })
        .catch(error => {
            console.error('Error loading task counts:', error);
        });
}
function drawChart(apiData) {
    var chartData = google.visualization.arrayToDataTable([
        ['Status', 'Numbers'],
        ['Completed', apiData.Done],
        ['Pending', apiData.pending],
        ['In Progress', apiData.in_progress]
    ]);
    var options = {
        width: 600,
        legend: { position: 'none' },
        chart: {
            title: 'All Tasks Status'
        },
        bars: 'horizontal',
        axes: {
            x: {
                0: { side: 'top', label: 'Total Numbers' }
            }
        },
        bar: { groupWidth: "90%" }
    };
    var chart = new google.charts.Bar(
        document.getElementById('top_x_div')
    );
    chart.draw(chartData, options);
}
</script>
@endif







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

<script>
        new DataTable('#example', {
        responsive: true
        });
        new DataTable('#example2', {
        responsive: true
        });
    </script>
  <script>
function kanbanBoard() {
    return {
        draggedTaskId: null,

        dragTask(event, taskId) {
            this.draggedTaskId = taskId;
        },

        dropTask(event, newStatus) {

            fetch("{{ route('tasks.update.status.kanban') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                body: JSON.stringify({
                    task_id: this.draggedTaskId,
                    status: newStatus
                })
            })
            .then(res => res.json())
            .then(data => {
                location.reload(); // simple refresh
            });
        }
    }
}
</script>
</body>
</html>
