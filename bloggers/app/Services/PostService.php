<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\UploadedFile;

class PostService
{
    public function createPost(array $data, ?UploadedFile $image = null): Post
    {
        $post = Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => 0,
            'author_id' => auth()->id(),
        ]);

        if ($image) {
            $path = $image->store('public/posts');
            $post->attachments()->create([
                'path' => $path,
                'type' => 'image'
            ]);
        }

        return $post;
    }
}
