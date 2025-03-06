<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
   public function index()
   {
      if (!Auth::check()) {
         return redirect()->route('login-form')->with('error', 'You need to log in first.');
      }

      $posts = Post::where("author_id", Auth::id())->with('author')->get();

      Log::info("Posts are: ", [$posts, Auth::id()]);

      return view('dashboard.home')->with(['posts' => $posts]);
   }
}
