<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Comments extends Component
{
    public Post $post;
    
    #[Validate('required|min:3')]
    public string $content = '';
    
    #[Validate('required|string|max:255')]
    public string $author_name = '';
    
    #[Validate('required|email')]
    public string $author_email = '';
    
    public ?int $reply_to = null;
    public bool $showReplyForm = false;

    public function mount(Post $post): void
    {
        $this->post = $post;
        
        // Pre-fill for authenticated users
        if (auth()->check()) {
            $this->author_name = auth()->user()->name;
            $this->author_email = auth()->user()->email;
        }
    }

    public function addComment(): void
    {
        $this->validate();

        $comment = new Comment([
            'post_id' => $this->post->id,
            'content' => $this->content,
            'author_name' => $this->author_name,
            'author_email' => $this->author_email,
            'parent_id' => $this->reply_to,
            'is_approved' => true, // Auto-approve for now
        ]);

        if (auth()->check()) {
            $comment->user_id = auth()->id();
        }

        $comment->save();

        $this->reset(['content', 'reply_to', 'showReplyForm']);
        
        if (!auth()->check()) {
            $this->reset(['author_name', 'author_email']);
        }

        session()->flash('message', 'Comment added successfully!');
    }

    public function replyTo(int $commentId): void
    {
        $this->reply_to = $commentId;
        $this->showReplyForm = true;
    }

    public function cancelReply(): void
    {
        $this->reset(['reply_to', 'showReplyForm', 'content']);
    }

    public function render()
    {
        $comments = $this->post->approvedComments()
            ->whereNull('parent_id')
            ->with(['replies.user', 'user'])
            ->latest()
            ->get();

        return view('livewire.comments', compact('comments'));
    }
}
