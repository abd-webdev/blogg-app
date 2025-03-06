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
                        <th>Category</th>
                        <th>Date</th>
                        <th>Author</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php $serial = 1; ?>
                        @foreach($posts as $post)
                        <tr> 
                            <td class='id'>{{ $serial }}</td>
                            <td>{{ $post->title }}</td>
                            <td>Html</td>
                            <td>{{ $post->created_at }}</td>
                            <td>{{ $post->author->name}}</td>
                            <td class='edit'><a href='{{ route('posts.update' , $post->id) }}'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-post.php'><i class="fa-solid fa-trash"></i></a></td>
                            <?php $serial++; ?>
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
    