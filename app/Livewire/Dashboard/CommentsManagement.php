<?php

namespace App\Livewire\Dashboard;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class CommentsManagement extends Component
{
    use WithPagination;

    public string $search = '';

    public function mount(): void
    {
        $this->search = '';
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function deleteComment(Comment $comment): void
    {
        // Перевіряємо, що коментар належить поточному користувачу
        if ($comment->user_id !== auth()->id()) {
            $this->addError('general', 'You can only delete your own comments.');

            return;
        }

        $comment->delete();

        session()->flash('message', 'Comment deleted successfully.');
        $this->resetPage();
    }

    public function getCommentsProperty()
    {
        return Comment::with(['post:id,title,slug'])
            ->where('user_id', auth()->id())
            ->when($this->search, fn ($query) => $query->where(function ($q) {
                $q->whereHas('post', fn ($postQuery) => $postQuery->where('title', 'like', "%{$this->search}%"))
                    ->orWhere('content', 'like', "%{$this->search}%");
            }))
            ->latest()
            ->paginate(10, pageName: 'page');
    }

    public function render()
    {
        return view('livewire.dashboard.comments-management');
    }
}
