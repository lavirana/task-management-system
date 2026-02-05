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
    <div class="grid grid-cols-2 gap-6">
    <div id="top_x_div" style="width: 600px; height: 480px;"></div>



<div id="tableWrapper" class="overflow-x-auto bg-white shadow rounded-lg dark:bg-gray-800">
    <table class="min-w-full border border-gray-200 dark:border-gray-700">
        
        <!-- Table Head -->
        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm">
            <tr>
                <th onclick="sortTable(0)" class="px-6 py-3 cursor-pointer">Task ⬍</th>
                <th onclick="sortTable(1)" class="px-6 py-3 cursor-pointer">Assigned ⬍</th>
                <th onclick="sortTable(2)" class="px-6 py-3 cursor-pointer">Status ⬍</th>
                <th onclick="sortTable(3)" class="px-6 py-3 cursor-pointer">Priority ⬍</th>
                <th class="px-6 py-3 text-center">Action</th>
            </tr>
        </thead>

        <!-- Table Body -->
        <tbody id="tableBody" class="divide-y divide-gray-200 dark:divide-gray-700">

        @foreach($tasks as $task)
            <tr>
                <td class="px-6 py-4">Design Login Page</td>
                <td class="px-6 py-4">Rahul</td>
                <td class="px-6 py-4">Pending</td>
                <td class="px-6 py-4">High</td>
                <td class="px-6 py-4 text-center text-blue-600">View</td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>



    </div>

   

</div>
@endsection

