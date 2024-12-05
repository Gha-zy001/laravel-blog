<?php

// use App\Http\Controllers\Dashboard\PostController;

use App\Http\Controllers\Website\CommentController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\PostController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Auth::routes();
Route::middleware('auth')->group(function () {
  // Route::get('/posts/{post}', [PostController::class, 'showPost'])->name('post.view');
  Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('post.comment.store');});

Route::resource('posts', PostController::class);
Route::get('/', [HomeController::class, 'index'])->name('home');
