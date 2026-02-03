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
    <hr>
    <br>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div id="top_x_div" style="width: 600px; height: 400px;"></div>
    </div>
   

</div>
@endsection

