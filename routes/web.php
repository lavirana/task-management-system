<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Models\Task;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $tasks = Task::latest()->take(5)->get();
    return view('dashboard', compact('tasks'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tasks',[TaskController::class, 'index'])->name('tasks.index');
Route::get('/create',[TaskController::class, 'create'])->name('tasks.create');
Route::post('/store',[TaskController::class, 'store'])->name('tasks.store');
Route::get('/edit/{id}',[TaskController::class, 'edit'])->name('tasks.edit');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])
    ->name('tasks.destroy');

Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::get('/task_count/{status?}', [TaskController::class, 'taskCount'])->name('tasks.count');
Route::post('/tasks/assign_user', [TaskController::class, 'assignTask'])->name('tasks.assign');
Route::post('/tasks/change_status', [TaskController::class, 'changeStatus'])->name('tasks.change_status');
Route::post('/tasks/change_priority', [TaskController::class, 'changePriority'])->name('tasks.change_priority');
Route::post('/tasks/update_assigned_date', [TaskController::class, 'updateAssignedDate'])->name('tasks.update_assigned_date');
Route::get('/tasks/get_task_counts', [TaskController::class, 'taskCountStatusWise'])->name('tasks.get_counts');
Route::get('/tasks/view/{id}', [TaskController::class, 'view'])->name('tasks.view');
Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('tasks.comments.store');


require __DIR__.'/auth.php';
