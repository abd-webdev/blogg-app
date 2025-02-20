<?php

use Illuminate\Support\Facades\Route;

Route::view("/", "layouts.app");

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/create-post', function () {
        return view('posts.create');
    })->name('posts.create'); 
    
});

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
