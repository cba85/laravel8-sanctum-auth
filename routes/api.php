<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('auth/register', [ApiTokenController::class, 'register']);
Route::post('auth/login', [ApiTokenController::class, 'login']);
Route::middleware('auth:sanctum')->post('auth/me', [ApiTokenController::class, 'me']);
Route::middleware('auth:sanctum')->post('auth/logout', [ApiTokenController::class, 'logout']);

//Route::middleware('auth:sanctum')->get('/posts', [PostController::class, 'index']);
//Route::middleware('auth:sanctum')->get('/posts/{post}', [PostController::class, 'show']);

Route::middleware('auth:sanctum')->apiResource('posts', PostController::class);
