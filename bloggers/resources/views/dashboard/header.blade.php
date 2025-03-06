<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ADMIN Panel</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('font/font-awesome-4.7.0/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- HEADER -->
    <div id="header-admin">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-2">
                    <a href="post.php"><img class="logo" src="{{ url('images/news.jpg') }}"></a>
                </div>
                <!-- /LOGO -->
                <!-- LOGO-Out -->

                <!-- /LOGO-Out -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="admin-menubar">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ul class="admin-menu">
                        <li>
                            <a href="{{ route('dashboard.home') }}">Post</a>
                        </li>
                        <li>
                            <a href="category.php">Category</a>
                        </li>
                        <li>
                            <a href="users.php">Users</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="admin-menu">
                        @auth
                        <li><a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <li><a href="#">{{ Auth::user()->name }}</a></li>
                    @else
                    <li><a href="{{ route('register-form') }}">Signup</a></li>
                    <li><a href="{{ route('login-form') }}">Login</a></li>
                    @endauth
                </ul>
            </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /Menu Bar -->