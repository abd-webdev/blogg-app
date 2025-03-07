<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
{
    return view("layouts.home"); // No need to manually pass posts!
}
}
