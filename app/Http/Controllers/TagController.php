<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $posts = $tag->posts()
            ->published()
            ->with(['user', 'categories', 'tags'])
            ->latest('published_at')
            ->paginate(12);

        return view('pages.tags.show', compact('tag', 'posts'));
    }
}
