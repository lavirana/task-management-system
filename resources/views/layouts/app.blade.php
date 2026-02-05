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
let currentPage = 1;
let rowsPerPage = 5;
let rows = [];

document.addEventListener("DOMContentLoaded", () => {
    rows = Array.from(document.querySelectorAll("#tableBody tr"));
    renderTable();
});

function renderTable() {
    let start = (currentPage - 1) * rowsPerPage;
    let end = start + rowsPerPage;

    rows.forEach((row, index) => {
        row.style.display = index >= start && index < end ? "" : "none";
    });

    document.getElementById("pageInfo").innerText =
        `Page ${currentPage} of ${Math.ceil(rows.length / rowsPerPage)}`;
}

function nextPage() {
    if (currentPage < Math.ceil(rows.length / rowsPerPage)) {
        currentPage++;
        renderTable();
    }
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        renderTable();
    }
}

document.getElementById("searchInput").addEventListener("keyup", function () {
    let value = this.value.toLowerCase();
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value)
            ? ""
            : "none";
    });
});

function sortTable(colIndex) {
    rows.sort((a, b) => {
        let A = a.children[colIndex].innerText.toLowerCase();
        let B = b.children[colIndex].innerText.toLowerCase();
        return A.localeCompare(B);
    });

    let tbody = document.getElementById("tableBody");
    tbody.innerHTML = "";
    rows.forEach(row => tbody.appendChild(row));
    renderTable();
}

</script>

</body>
</html>
