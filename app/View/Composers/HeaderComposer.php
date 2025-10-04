<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Models\Page;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view): void
    {
        // Завантажуємо головні категорії з їх дочірніми категоріями
        $categories = Category::query()
            ->whereNull('parent_id') // Тільки головні категорії
            ->where('is_active', true)
            ->with(['children' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug', 'parent_id', 'color']);

        // Завантажуємо опубліковані сторінки
        $pages = Page::where('is_published', true)
            ->orderBy('title')
            ->get(['id', 'title', 'slug']);

        $view->with([
            'categories' => $categories,
            'pages' => $pages,
        ]);
    }
}