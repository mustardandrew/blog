<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    public function home(): View
    {
        $posts = Post::with(['user', 'tags', 'categories'])
            ->published()
            ->latest('published_at')
            ->limit(6)
            ->get();

        return view('welcome', compact('posts'));
    }

    public function index(Request $request): View
    {
        $query = Post::with(['user', 'tags', 'categories'])
            ->published()
            ->latest('published_at');

        // Add search functionality
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $posts = $query->paginate(12);

        return view('posts.index', compact('posts', 'search'));
    }

    public function show(Post $post): View
    {
        // Check if user can view this post
        if (!$post->isPublished() && (!Auth::check() || !Auth::user()->is_admin)) {
            abort(404);
        }

        // Load relationships
        $post->load(['user', 'tags', 'categories']);

        return view('posts.show', compact('post'));
    }
}
