<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function home(): View
    {
        $posts = Post::with('user')
            ->published()
            ->latest('published_at')
            ->limit(6)
            ->get();

        return view('welcome', compact('posts'));
    }

    public function index(): View
    {
        $posts = Post::with('user')
            ->published()
            ->latest('published_at')
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post): View
    {
        // Check if user can view this post
        if (!$post->isPublished() && (!auth()->check() || !auth()->user()->is_admin)) {
            abort(404);
        }

        // Load relationships
        $post->load(['user', 'tags', 'categories']);

        return view('posts.show', compact('post'));
    }
}
