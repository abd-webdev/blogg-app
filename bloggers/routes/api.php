<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts', [PostController::class, 'createPost']);
    Route::get('/posts', [PostController::class, 'listPublishedPosts']);
    Route::get('/posts/{id}', [PostController::class, 'getSinglePost']);
    Route::delete('/posts/{post}', [PostController::class, 'deletePost']);
    Route::put('/posts/{post}', [PostController::class, 'updatePost']);
    Route::patch('/posts/{post}/publish', [PostController::class, 'publishPost']);

});
