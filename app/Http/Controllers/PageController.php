<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function show(Page $page) {
        // Check if user can access this page
        if (! $this->canAccess($page)) {
            abort(404);
        }

        return view('pages.pages.show', compact('page'));
    }

    protected function canAccess(Page $page)
    {
        return $page->isPublished() || $this->isAdmin();
    }

    protected function isAdmin()
    {
        return auth()->check() 
            && auth()->user()->is_admin;
    }
}
