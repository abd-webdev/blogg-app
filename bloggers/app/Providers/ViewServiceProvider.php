<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Post;

class ViewServiceProvider extends ServiceProvider
{
    public function register(){

    }
    public function boot()
    {
        View::composer('layouts.home', function ($view) {
            $posts = Post::orderBy("created_at", "asc")
                ->where("status","1")
                ->with('attachments')
                ->whereNull('deleted_at')
                ->paginate(2);

            $view->with('posts', $posts);
        });

        View::composer('layouts.sidebar', function ($view) {
            $posts = Post::orderBy("created_at", "desc") 
                ->with('attachments')
                ->whereNull('deleted_at')->get()
                ->take(5);

            $view->with('posts', $posts);
        });
    }
}
