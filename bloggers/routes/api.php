<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

require __DIR__ . '/auth.php';

Route::middleware('auth:sanctum')->group(function () {

    //Route::resource('posts', PostController::class);
    Route::prefix('/posts')->group(function () {
        //Routes for Posts
        Route::post('/', [PostController::class, 'createPost']);
        Route::get('/', [PostController::class, 'listPublishedPosts']);
        Route::get('/{id}', [PostController::class, 'getSinglePost']);
        Route::delete('/{post}', [PostController::class, 'deletePost']);
        Route::put('/{post}', [PostController::class, 'updatePost']);
        Route::patch('/{post}/publish', [PostController::class, 'publishPost']);

        //Routes for Comments
        Route::post('/{post}/comments', [CommentController::class, 'store']);
        Route::get('/{post}/comments', [CommentController::class, 'index']);

        Route::prefix('/comments')->group(function () {
            Route::put('/{comment}', [CommentController::class, 'update']);
            Route::delete('/{comment}', [CommentController::class, 'destroy']);

            //Routes for Replies
            Route::post('/{comment}/replies', [CommentController::class, 'storeReply']);
            Route::get('/{comment}/replies', [CommentController::class, 'getReplies']);
        });
    });

    Route::get('/protected-route', function () {
        return response()->json(['message' => 'You are verified!']);
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});