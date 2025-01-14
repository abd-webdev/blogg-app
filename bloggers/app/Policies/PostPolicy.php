<?php

namespace App\Policies;
use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function update(User $user, Post $post)
    {
        // Allow updates only if the user is the author of the post
        return $user->id === $post->author_id;
    }

    public function delete(User $user, Post $post)
    {
        return $user->id === $post->author_id;
    }
}
