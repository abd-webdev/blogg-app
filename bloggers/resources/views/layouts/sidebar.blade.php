<div id="sidebar">
    <!-- search box -->
    <div class="search-box-container" style="width: 400px">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
        <div class="recent-post">
            @foreach ($posts as $post) 
            <a class="post-img" href="">
                <img src="{{ asset('storage/' . optional($post->attachments->first())->path) }}" alt=""/>
            </a>
            
            <div class="post-content">
                <h5><a href="single.php">{{ $post->title }}</a></h5>
                <span>
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <a href='category.php'>Html</a>
                </span>
                <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    {{ $post->created_at }}
                </span>
                <a class="read-more" href="{{ route('posts.show', $post->id) }}">read more</a>
            </div>
            @endforeach
        </div>
    </div>
    <!-- /recent posts box -->
</div>
