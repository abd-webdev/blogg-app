@extends('layouts.app');

@section('content')
  <div id="main-content">
        <div class="container">
            <div class="row">
                <div>
                    <!-- post-container -->
                    <div class="post-container">
                        @foreach ($posts as $post)
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="{{ route('posts.show', $post->id) }}"><img src="{{ asset('storage/' . optional($post->attachments->first())->path) }}" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='{{ route('posts.show', $post->id) }}'>{{ $post->title }}</a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php'>PHP</a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php'>{{ $post->author->name }}</a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                {{ $post->created_at }}
                                            </span>
                                        </div>
                                        <p class="description">
                                        {{ $post->description }}
                                        </p>
                                        <a class='read-more pull-right' href='{{ route('posts.show', $post->id) }}'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{ $posts->links() }}
                    </div><!-- /post-container -->
                </div>
            </div>
        </div>
    </div>

    @endsection
