@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>All Posts</h2>
    <a href="{{ route('posts.create') }}" class="btn btn-success mb-3">Create New Post</a>

    @if($posts->count() > 0)
        <div class="row">
            @foreach($posts as $post)
                <div class="col-md-4">
                    <div class="card mb-3">
                        @if($post->attachments->count() > 0)
                            <img src="{{ Storage::url($post->attachments->first()->path) }}" class="card-img-top" alt="Post Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit($post->description, 100) }}</p>
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No posts available.</p>
    @endif
</div>
@endsection
