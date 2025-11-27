<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->group(function () {
    // Get the authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // User Management API Routes
    Route::get('/users/list', [UserController::class, 'list']); // Get list of users for table
    Route::post('/users', [UserController::class, 'store']); // Create a new user
    Route::get('/users/{user}', [UserController::class, 'show']); // Get a single user for editing
    Route::put('/users/{user}', [UserController::class, 'update']); // Update a user
    Route::delete('/users/{user}', [UserController::class, 'destroy']); // Delete a user
    Route::post('/users/{user}/suspend', [UserController::class, 'suspend']); // Suspend a user
    Route::post('/users/{user}/activate', [UserController::class, 'activate']); // Activate a user
});
