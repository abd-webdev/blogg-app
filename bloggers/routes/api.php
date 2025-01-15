<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

require __DIR__ . '/auth.php';

Route::middleware('auth:sanctum')->group(function () {

            //Routes for Posts
      Route::resource('posts', PostController::class)
                ->only(['index', 'store', 'show', 'update', 'destroy']);
      Route::patch('posts/{post}/publish', [PostController::class, 'publishPost']);

      //Routes for Comments
      Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
      Route::get('/posts/{post}/comments', [CommentController::class, 'index']);

      Route::prefix('/comments')->group(function () {
          Route::put('/{comment}', [CommentController::class, 'update']);
          Route::delete('/{comment}', [CommentController::class, 'destroy']);

          //Routes for Replies
          Route::post('/{comment}/replies', [CommentController::class, 'storeReply']);
          Route::get('/{comment}/replies', [CommentController::class, 'getReplies']);

      });
    });


Route::get('/user', function (Request $request) {
    return $request->user();
});

