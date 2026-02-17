<?php


use App\Http\Controllers\Api\AuthController;




Route::prefix('v1')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', fn(Request $r) => $r->user());


        Route::middleware('role:admin')->group(function() {
             Route::delete('/tasks/{id}',[AuthController::class, 'destroy']);
             Route::get('/tasks-trash', [TaskController::class, 'trash']);
        Route::post('/tasks-restore/{id}', [TaskController::class, 'restore']);
        Route::delete('/tasks-force/{id}', [TaskController::class, 'forceDelete']);
        });

    });
});