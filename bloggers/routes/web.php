<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get("/", [HomeController::class,"index"])->name("home");

    Route::get('/create-post', function () {
        return view('posts.create');
    })->name('posts.create'); 

    Route::get('/update-post/{id}', function () {
        return view('posts.update');
    })->name('posts.update'); 
    


Route::view("/about", "layouts.app")->name('about');

Route::get('/login', function () {
    return view('auth.login');
})->name('login-form'); 

Route::get('/register', function () {
    return view('auth.register');
})->name('register-form'); 

Route::get('/login-form', function () {
    return redirect()->route('login-form');
});

Route::get('/register-form', function () {
    return redirect()->route('register-form');
});


require __DIR__.'/auth.php';
