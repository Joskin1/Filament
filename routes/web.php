<?php

use App\Http\Controllers\PostController;
use App\Livewire\CreatePostForm;
use App\Livewire\InfoList;
use App\Livewire\ShowPostTable;
use App\Livewire\UserInfolist;
use Illuminate\Support\Facades\Route;

Route::get('/   ', function () {
    return view('welcome');
});
Route::get('posts/create', CreatePostForm::class );
Route::get('posts/table', ShowPostTable::class );
Route::get('/inforlist/{user}', UserInfolist::class);


// Route::view('posts/create', 'livewire/create-post-form' );
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [PostController::class, 'dashboard'])->name('dashboard');
Route::get('/users/{user}', UserInfolist::class);
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');





