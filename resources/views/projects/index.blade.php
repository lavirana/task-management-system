@extends('layouts.app')
@section('content')
<h3>My Projects</h3>

<form method="POST" action="{{ route('projects.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Project name" required>
    <textarea name="description" placeholder="Description"></textarea>
    <button type="submit">Add Project</button>
</form>
<hr>
<ul>
@if($projects->isNotEmpty())
@foreach($projects as $project)
    <li>
        <strong>{{ $project->name }}</strong>
        ({{ $project->tasks->count() }} tasks)
    </li>
@endforeach
    @else
        <li>No projects found.</li>
    @endif
</ul>
@endsection