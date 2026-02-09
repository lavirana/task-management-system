@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto p-6">

<h1>User All Notifications</h1>


<table id="example2" class="table table-striped nowrap">
        <thead >
            <tr>
                <th>Type</th>
                <th>Notifiable Type</th>
                <th>Notifiable Id</th>
                <th>Data</th>
                <th>Tomorrow</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
        @foreach($notifications as $notification)
<tr>
    <td>{{ class_basename($notification->type) }}</td>
    <td>{{ class_basename($notification->notifiable_type) }}</td>
    <td>{{ $notification->notifiableUser->name }}</td>

    <!-- DATA COLUMN -->
    <td>
    @php
        $data = is_array($notification->data)
            ? $notification->data
            : json_decode($notification->data, true);
    @endphp

    <table class="table table-bordered table-sm mb-0">
        @foreach($data as $key => $value)
            <tr>
                <th style="width:120px;float:right">
                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                </th>
                <td>{{ $value }}</td>
            </tr>
        @endforeach
    </table>
</td>

    <td>
        {{ $notification->read_at ? 'Yes' : 'No' }}
    </td>
    <td>{{ $notification->created_at->format('d M Y, h:i A') }}</td>
</tr>
@endforeach 
        </tbody>
    </table>

@endsection