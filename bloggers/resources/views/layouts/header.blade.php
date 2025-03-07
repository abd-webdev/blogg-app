<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>News</title>
 
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <a href="{{ url('/') }}" id="logo"><img src="{{ asset('images/news.jpg') }}"></a>
                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ul class='menu'>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href='{{ url('/') }}'>Entertainment</a></li>
                        <li><a href='{{ url('/') }}'>Sports</a></li>
                        <li><a href='{{ url('/') }}'>Politics</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="menu">
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
    <!-- /Menu Bar -->
    <!-- MDBootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>