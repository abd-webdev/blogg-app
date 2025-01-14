<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//Routes for Posts

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts', [PostController::class, 'createPost']);
    Route::get('/posts', [PostController::class, 'listPublishedPosts']);
    Route::get('/posts/{id}', [PostController::class, 'getSinglePost']);
    Route::delete('/posts/{post}', [PostController::class, 'deletePost']);
    Route::put('/posts/{post}', [PostController::class, 'updatePost']);
    Route::patch('/posts/{post}/publish', [PostController::class, 'publishPost']);

});

//Routes for Comments

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
    Route::put('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
});

//Routes for Replies

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/comments/{comment}/replies', [CommentController::class, 'storeReply']);
    Route::get('/comments/{comment}/replies', [CommentController::class, 'getReplies']);
});

