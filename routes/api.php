<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Public routes (tidak butuh token)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Protected routes (butuh token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user',          [AuthController::class, 'user']);
    Route::post('/logout',       [AuthController::class, 'logout']);

    Route::get('/posts',         [PostController::class, 'index']);
    Route::post('/posts',        [PostController::class, 'store']);
    Route::get('/posts/{id}',    [PostController::class, 'show']);
    Route::put('/posts/{id}',    [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});
