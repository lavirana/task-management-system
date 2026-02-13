@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-4">Activity Logs</h1>

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">User</th>
                <th class="text-left">Action</th>
                <th class="text-left">Task Title</th>
                <th class="text-left">Date</th>
            </tr>
        </thead>
        <tbody>
            @if($logs->isNotEmpty())
            @foreach($logs as $log)
            <tr class="border-t">
                <td class="p-3">{{ $log->user->name ?? 'Not Found' }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $log->action)) }}</td>
                <td>
                    {{ 
                        optional($log->task)->title 
                        ?? $log->old_values['title']
                        ?? 'N/A' 
                    }}
                </td>
                <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
            @else
                <tr colspan="4">
                <td></td>
                    <td></td>
                    <td class="p-3">
                    No Logs Found
                    </td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>

</div>

@endsection