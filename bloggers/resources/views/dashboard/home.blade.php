@extends('dashboard.index');

@section('content')

    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="admin-heading">All Posts</h1>
                </div>
                <div class="col-md-2">
                    <a class="add-new" href="{{ route('posts.create') }}">add post</a>
                </div>
                <div class="col-md-12">
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Action</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php $serial = 1; ?>
                            @foreach($posts as $post)
                                <tr>
                                    <td class='id'>{{ $serial }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->created_at }}</td>
                                    <td>{{ $post->author->name}}</td>
                                    <td>
                                        @if ($post->status == '0')
                                           <a href="{{ route('posts.publish', $post->id) }}" class="btn btn-success">Publish</a>
                                        @else
                                           <a href="{{ route('posts.publish', $post->id) }}" class="btn btn-danger">Unpublish</a>
                                        @endif
                                    </td>
                                    <td class='edit'><a href='{{ route('posts.edit', $post->id) }}'><i
                                                class='fa fa-edit'></i></a></td>
                                    <td class='delete'>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="padding: 0; display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="text-decoration: none">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>

                                    <?php    $serial++; ?>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <ul class='pagination admin-pagination'>
                        <li class="active"><a>1</a></li>
                        <li><a>2</a></li>
                        <li><a>3</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection