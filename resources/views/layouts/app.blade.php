<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
 
    
</head>

<body class="bg-gray-100">

    <!-- Header -->
    <nav class="bg-white shadow p-4 mb-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">

            <!-- App Title -->
            <div class="font-bold text-lg">
                <a href="{{ route('dashboard') }}">
                Task Management System
                </a>
            </div>

            <!-- Menu -->
            <div class="space-x-4">
                <a href="{{ route('tasks.index') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium">
                    All Tasks
                </a>

                <a href="{{ route('tasks.create') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium">
                    Add Task
                </a>
            </div>

        </div>
    </nav>

    <!-- Page Content -->
    <div class="max-w-7xl mx-auto">
        @yield('content')
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/task_count/pending')
        .then(response => response.json())
        .then(data => {
            document.getElementById('pendingTasks').innerText = data.count;
        })
        .catch(error => {
            console.error('Error fetching pending tasks:', error);
        });
});
document.addEventListener('DOMContentLoaded', function (){
    fetch('/task_count/done')
        .then(response => response.json())
        .then(data => {
            document.getElementById('completedTasks').innerText = data.count;
        })
        .catch(error => {
            console.error('Error fetching completed tasks:', error);
        });
})
document.addEventListener('DOMContentLoaded', function (){
    fetch('/task_count/in_progress')
        .then(response => response.json())
        .then(data => {
            document.getElementById('progressTasks').innerText = data.count;
        })
        .catch(error => {
            console.error('Error fetching in progress tasks:', error);
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


</body>
</html>
