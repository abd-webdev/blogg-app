<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post): JsonResponse
    {
        $comments = $post->comments()
            ->with('user')
            ->whereNull('parent_id')
            ->latest()
            ->paginate(10);

        return response()->json([
            'message' => 'Comments retrieved successfully.',
            'comments' => $comments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create([
            'message' => $validated['message'],
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Comment added successfully.',
            'comment' => $comment,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(Request $request, Comment $comment): JsonResponse
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $comment->update($validated);

        return response()->json([
            'message' => 'Comment updated successfully.',
            'comment' => $comment,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully.',
        ]);
    }

//    Code for replies

    public function storeReply(Request $request, Comment $comment): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $reply = $comment->replies()->create([
            'message' => $validated['message'],
            'user_id' => Auth::id(),
            'post_id' => $comment->post_id,
        ]);

        return response()->json([
            'message' => 'Reply added successfully.',
            'reply' => $reply,
        ], 201);
    }

    public function getReplies(Comment $comment): JsonResponse
    {
        $replies = $comment->replies()->with('replies.user')->get();

        return response()->json([
            'message' => 'Replies retrieved successfully.',
            'replies' => $replies,
        ]);
    }

}
