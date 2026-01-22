<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

</body>
</html>
