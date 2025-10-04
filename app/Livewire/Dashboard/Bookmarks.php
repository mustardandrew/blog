<?php

namespace App\Livewire\Dashboard;

use App\Models\Bookmark;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Bookmarks extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function getBookmarksProperty(): LengthAwarePaginator
    {
        $query = Auth::user()->bookmarkedPosts()
            ->with(['user', 'categories', 'tags'])
            ->published();

        // Search functionality
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('posts.title', 'like', '%' . $this->search . '%')
                  ->orWhere('posts.excerpt', 'like', '%' . $this->search . '%');
            });
        }

        // Sorting
        switch ($this->sortBy) {
            case 'title':
                $query->orderBy('posts.title', $this->sortDirection);
                break;
            case 'published_at':
                $query->orderBy('posts.published_at', $this->sortDirection);
                break;
            default:
                $query->orderBy('bookmarks.created_at', $this->sortDirection);
        }

        return $query->paginate(12);
    }

    public function removeBookmark(int $postId): void
    {
        Bookmark::where('user_id', Auth::id())
            ->where('post_id', $postId)
            ->delete();

        session()->flash('message', 'Закладку видалено');
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.dashboard.bookmarks', [
            'bookmarks' => $this->bookmarks,
        ]);
    }
}
