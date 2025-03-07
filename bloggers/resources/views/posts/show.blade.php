@extends('layouts.app')

@section('content')
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div>
                  <!-- post-container -->
                    <div class="post-container">
                        <div class="post-content single-post">
                            <h3>{{ $post->title }}</h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <a href='author.php'>{{ $post->author->name }}</a>
                                </span>
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    Html
                                </span>
                                <span>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    {{ $post->created_at }}
                                </span>
                            </div>
                            <img class="single-feature-image" src="{{ asset('storage/' . optional($post->attachments->first())->path) }}" alt=""/>
                            <p class="description">
                                {{ $post->description }}
                            </p>
                        </div>
                    </div>
                    <!-- /post-container -->
                </div>
            </div>
        </div>
    </div>
    @endsection
