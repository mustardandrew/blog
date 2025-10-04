<?php

namespace App\Livewire;

use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookmarkButton extends Component
{
    public Post $post;
    public bool $isBookmarked = false;
    public string $variant = 'outline';
    public string $size = 'sm';

    public function mount(Post $post, string $size = 'sm', string $variant = 'outline'): void
    {
        $this->post = $post;
        // Ensure valid Flux sizes
        $this->size = in_array($size, ['xs', 'sm', 'lg', 'xl']) ? $size : 'sm';
        $this->variant = $variant;
        $this->updateBookmarkState();
    }

    public function toggle(): void
    {
        if (!Auth::check()) {
            $this->redirect(route('login'), navigate: true);
            return;
        }

        $result = Bookmark::toggle(Auth::id(), $this->post->id);
        
        $this->isBookmarked = $result['bookmarked'];
        
        $this->dispatch('bookmark-toggled', [
            'postId' => $this->post->id,
            'bookmarked' => $this->isBookmarked,
            'message' => $result['message'],
        ]);

        // Show notification
        session()->flash('message', $result['message']);
    }

    public function updatedPost(): void
    {
        $this->updateBookmarkState();
    }

    private function updateBookmarkState(): void
    {
        $this->isBookmarked = Auth::check() && 
            Bookmark::isBookmarked(Auth::id(), $this->post->id);
    }

    public function render()
    {
        return view('livewire.bookmark-button');
    }
}
