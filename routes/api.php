<?php


use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;

Route::prefix('v1')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', fn(Request $r) => $r->user());
        Route::get('/tasks', [TaskController::class, 'index']);

        Route::middleware('role:admin')->group(function() {
             //Route::delete('/tasks/{id}',[AuthController::class, 'destroy']);
             //Route::get('/tasks-trash', [AuthController::class, 'trash']);
        //Route::post('/tasks-restore/{id}', [AuthController::class, 'restore']);
       //Route::delete('/tasks-force/{id}', [AuthController::class, 'forceDelete']);
        });

    });
});