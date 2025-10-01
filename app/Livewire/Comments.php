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

        // Ensure we only create replies to top-level comments
        $parentId = null;
        if ($this->reply_to) {
            $parentComment = Comment::find($this->reply_to);
            // If replying to a reply, make it a reply to the original parent
            $parentId = $parentComment->parent_id ?? $this->reply_to;
        }

        $comment = new Comment([
            'post_id' => $this->post->id,
            'content' => $this->content,
            'author_name' => $this->author_name,
            'author_email' => $this->author_email,
            'parent_id' => $parentId,
            'is_approved' => true, // Auto-approve by default
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
        
        // Dispatch event to scroll to form
        $this->dispatch('scroll-to-form');
    }

    public function cancelReply(): void
    {
        $this->reset(['reply_to', 'showReplyForm', 'content']);
    }

    public function deleteComment(int $commentId): void
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $comment = Comment::findOrFail($commentId);
        
        // Delete all replies first
        $comment->replies()->delete();
        
        // Delete the comment
        $comment->delete();

        session()->flash('message', 'Comment deleted successfully!');
    }

    public function toggleApproval(int $commentId): void
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $comment = Comment::findOrFail($commentId);
        $comment->update(['is_approved' => !$comment->is_approved]);

        $status = $comment->is_approved ? 'approved' : 'unapproved';
        session()->flash('message', "Comment {$status} successfully!");
    }

    public function render()
    {
        $isAdmin = auth()->check() && auth()->user()->is_admin;
        
        $query = $this->post->comments()
            ->whereNull('parent_id')
            ->with(['replies' => function($q) use ($isAdmin) {
                if (!$isAdmin) {
                    $q->where('is_approved', true);
                }
                $q->with('user');
            }, 'user']);

        // Show all comments for admins, only approved for others
        if (!$isAdmin) {
            $query->where('is_approved', true);
        }

        $comments = $query->latest()->get();

        return view('livewire.comments', compact('comments'));
    }
}
