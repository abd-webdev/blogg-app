<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function listPublishedPosts()
    {
        $posts = Post::where('status', 1)
            ->with(['author:id,name,email', 'attachments', 'comments' => function ($query) {
                $query->latest()->take(3);
            }])
            ->get();

        return response()->json($posts, 200);
    }

    public function getSinglePost($id)
    {
        $post = Post::where('id', $id)
            ->with(['author:id,name,email', 'attachments', 'comments'])
            ->first();

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createPost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Create post
        $post = Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
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

        return response()->json(['message' => 'Post created successfully', 'post' => $post->load('attachments')], 201);
    }


    public function publishPost(Post $post)
    {
        $this->authorize('update', $post);

        $post->update(['status' => 1]);

        return response()->json(['message' => 'Post published successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePost(Request $request, Post $post)
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
                \Storage::delete($oldAttachment->path);
                $oldAttachment->delete();
            }

            // Save new image
            $path = $request->file('image')->store('public/posts');
            $post->attachments()->create([
                'path' => $path,
                'type' => 'image'
            ]);
        }

        return response()->json(['message' => 'Post updated successfully', 'post' => $post->load('attachments')], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function deletePost(Post $post)
    {
        $this->authorize('delete', $post);

        // Delete associated attachments
        $post->attachments()->delete();

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }

}
