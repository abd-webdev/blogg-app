@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <a href="{{ route('posts.index') }}" class="btn btn-secondary mb-3">Back to Posts</a>

    <div class="card">
        @if($post->attachments->count() > 0)
            <img src="{{ Storage::url($post->attachments->first()->path) }}" class="card-img-top" alt="Post Image">
        @endif
        <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>
            <p class="card-text">{{ $post->description }}</p>
            <p><strong>Author:</strong> {{ $post->author->name }}</p>
        </div>
    </div>
</div>
@endsection
