<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/   ', function () {
    return view('welcome');
});
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [PostController::class, 'dashboard'])->name('dashboard');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');



