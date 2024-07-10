<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function dashboard()
    {
        $posts = Post::with('category')->latest()->paginate(10);

        return view('dashboard', [
            'posts' => $posts
        ]);
    }
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

}
