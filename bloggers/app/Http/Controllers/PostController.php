<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PostService;

class PostController extends Controller
{
    use AuthorizesRequests;
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the posts (Supports JSON & Blade View)
     */
    public function index(Request $request)
    {
        $posts = Post::where('status', 1)
            ->with(['author:id,name,email', 'attachments', 'comments' => function ($query) {
                $query->latest()->take(3);
            }])
            ->latest()
            ->get();

        // Return JSON if request is from API
        if ($request->wantsJson()) {
            return response()->json($posts, Response::HTTP_OK);
        }

        // Return Blade View for Web
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Delegate post creation to PostService
        $post = $this->postService->createPost($validated, $request->file('image'));

        // Handle API Response
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Post created successfully', 'post' => $post->load('attachments')], Response::HTTP_OK);
        }

        // Redirect to post list with success message
        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified post (Supports JSON & Blade View)
     */
    public function show(Request $request, $id)
    {
        $post = Post::where('id', $id)
            ->with(['author:id,name,email', 'attachments', 'comments'])
            ->first();

        if (!$post) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
            }
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }

        // Return JSON if request is from API
        if ($request->wantsJson()) {
            return response()->json($post, Response::HTTP_OK);
        }

        // Return Blade View for Web
        return view('posts.show', compact('post'));
    }

    /**
     * Publish a post.
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

        // Handle API Response
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Post updated successfully', 'post' => $post->load('attachments')], Response::HTTP_OK);
        }

        // Redirect to post list with success message
        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
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

        // Handle API Response
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Post deleted successfully'], Response::HTTP_OK);
        }

        // Redirect to post list with success message
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}
