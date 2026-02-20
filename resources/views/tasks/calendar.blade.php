@extends('layouts.app')

@section('content')
<div class="container">
    <h3>📅 Task Calendar</h3>
    <div id="calendar"></div>
    <!-- Create Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-3">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Create New Task</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form id="calendarTaskForm">
        @csrf

        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label fw-semibold">Task Title</label>
            <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter task title" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Due Date</label>
            <input type="date" name="due_date" id="modal_due_date" class="form-control form-control-lg" required>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary px-4">Save Task</button>
        </div>

      </form>

    </div>
  </div>
</div>
</div>

@endsection