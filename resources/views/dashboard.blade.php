@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Task Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded shadow">
            <h2 class="text-gray-600">In Progress Tasks</h2>
            <p class="text-3xl font-bold" id="progressTasks">0</p>
        </div>

        <div class="bg-yellow-100 p-5 rounded shadow">
            <h2 class="text-gray-600">Pending Tasks</h2>
            <p class="text-3xl font-bold" id="pendingTasks">0</p>
        </div>

        <div class="bg-green-100 p-5 rounded shadow">
            <h2 class="text-gray-600">Completed Tasks</h2>
            <p class="text-3xl font-bold" id="completedTasks">0</p>
        </div>
    </div>

</div>
@endsection


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
    fetch('/task_count/completed')
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

