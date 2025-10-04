<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\On;

class SearchPanel extends Component
{
    public string $query = '';
    public bool $isOpen = false;
    public $results = [];

    public function mount(): void
    {
        $this->results = collect();
    }

    #[On('open-search')]
    public function openSearch(): void
    {
        $this->isOpen = true;
        $this->dispatch('focus-search-input');
    }

    #[On('close-search')]
    public function closeSearch(): void
    {
        $this->isOpen = false;
        $this->query = '';
        $this->results = collect();
    }

    public function updatedQuery(): void
    {
        if (strlen($this->query) >= 2) {
            $this->search();
        } else {
            $this->results = collect();
        }
    }

    public function search(): void
    {
        $this->results = Post::published()
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->query . '%')
                    ->orWhere('excerpt', 'like', '%' . $this->query . '%')
                    ->orWhere('content', 'like', '%' . $this->query . '%');
            })
            ->with(['user', 'categories', 'tags'])
            ->orderBy('published_at', 'desc')
            ->limit(8)
            ->get();
    }

    public function render()
    {
        return view('livewire.search-panel');
    }
}
