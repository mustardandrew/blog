<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function home(): View
    {
        $posts = Post::with(['user', 'tags', 'categories'])
            ->published()
            ->latest('published_at')
            ->limit(6)
            ->get();

        return view('pages.home.index', compact('posts'));
    }
}
