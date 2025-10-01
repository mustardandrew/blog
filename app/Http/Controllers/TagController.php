<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $posts = $tag->posts()
            ->published()
            ->with(['user', 'categories', 'tags'])
            ->latest('published_at')
            ->paginate(12);

        return view('tags.show', compact('tag', 'posts'));
    }
}
