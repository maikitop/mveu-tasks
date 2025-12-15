<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'apiIndex']);
Route::get('/posts/{id}', [PostController::class, 'apiShow']);
Route::post('/posts', [PostController::class, 'apiStore']);
Route::put('/posts/{id}', [PostController::class, 'apiUpdate']);
Route::delete('/posts/{id}', [PostController::class, 'apiDestroy']);