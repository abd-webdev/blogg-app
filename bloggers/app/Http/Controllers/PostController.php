<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $posts = Post::where('status', 1)
            ->with(['author:id,name,email', 'attachments', 'comments' => function ($query) {
                $query->latest()->take(3);
            }])
            ->get();

        return response()->json($posts, Response::HTTP_OK);
    }

    public function show($id): JsonResponse
    {
        $post = Post::where('id', $id)
            ->with(['author:id,name,email', 'attachments', 'comments'])
            ->first();

        if (!$post) {
            return response()->json(['message' => 'Post not found'], response::HTTP_NOT_FOUND);
        }

        return response()->json($post, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Create post
        $post = Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 0,
            'author_id' => auth()->id(),
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/posts');
            $post->attachments()->create([
                'path' => $path,
                'type' => 'image'
            ]);
        }

        return response()->json(['message' => 'Post created successfully', 'post' => $post->load('attachments')], Response::HTTP_OK);
    }


    /**
     * @throws AuthorizationException
     */
    public function publishPost(Post $post)
    {
        $this->authorize('update', $post);

        $post->update(['status' => 1]);

        return response()->json(['message' => 'Post published successfully'], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status' => 'sometimes|boolean',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Update post details
        $post->update($validated);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->attachments()->exists()) {
                $oldAttachment = $post->attachments()->first();
                Storage::delete($oldAttachment->path);
                $oldAttachment->delete();
            }

            // Save new image
            $path = $request->file('image')->store('public/posts');
            $post->attachments()->create([
                'path' => $path,
                'type' => 'image'
            ]);
        }

        return response()->json(['message' => 'Post updated successfully', 'post' => $post->load('attachments')], Response::HTTP_OK);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        // Delete associated attachments
        $post->attachments()->delete();

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], Response::HTTP_OK);
    }

}
