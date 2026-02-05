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

    <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 border-b">
                Pending Tasks
                </th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 border-b">
                Priority
                </th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 border-b">
                Assigned Date
                </th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 border-b">
                Assigned User	
                </th>
            </tr>
        </thead>

        <tbody class="bg-white">
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border-b">The Sliding</td>
                <td class="px-4 py-2 border-b">High</td>
                <td class="px-4 py-2 border-b">28-02-2026</td>
                <td class="px-4 py-2 border-b">Ashish</td>
            </tr>
        </tbody>
    </table>
<br>
    <table class="min-w-full border border-gray-200 rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 border-b">
                Recently Added Tasks
                </th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 border-b">
                    Artist
                </th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 border-b">
                    Year
                </th>
            </tr>
        </thead>

        <tbody class="bg-white">
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border-b">The Sliding</td>
                <td class="px-4 py-2 border-b">Malcolm Lockyer</td>
                <td class="px-4 py-2 border-b">1961</td>
            </tr>
        </tbody>
    </table>

</div>

    </div>

   

</div>
@endsection

