<?php

use App\Models\Comment;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $search = '';

    public function mount()
    {
        $this->search = '';
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function getCommentsProperty()
    {
        return Comment::with(['post:id,title,slug', 'replies'])
            ->where('user_id', auth()->id())
            ->when($this->search, fn ($query) => $query->where(function ($q) {
                $q->whereHas('post', fn ($postQuery) => $postQuery->where('title', 'like', "%{$this->search}%"))
                  ->orWhere('content', 'like', "%{$this->search}%");
            }))
            ->latest()
            ->paginate(10);
    }
}; ?>

<div>
    <!-- Search Bar -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
        <flux:input 
            wire:model.live.debounce.300ms="search"
            placeholder="{{ __('Search comments or posts...') }}"
            class="w-full"
        />
    </div>

    <!-- Comments List -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
        @if($this->comments->count() > 0)
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach($this->comments as $comment)
                    <div class="p-6">
                        <!-- Comment Header -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">
                                    <a href="{{ route('posts.show', $comment->post->slug) }}" 
                                       wire:navigate
                                       class="hover:text-amber-600 dark:hover:text-amber-400">
                                        {{ $comment->post->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $comment->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            <!-- Comment Status -->
                            <div class="flex items-center space-x-2">
                                @if($comment->is_approved)
                                    <flux:badge color="green" size="sm">{{ __('Approved') }}</flux:badge>
                                @else
                                    <flux:badge color="amber" size="sm">{{ __('Pending Review') }}</flux:badge>
                                @endif
                                
                                @if($comment->replies->count() > 0)
                                    <flux:badge color="blue" size="sm">
                                        {{ $comment->replies->count() }} {{ __('replies') }}
                                    </flux:badge>
                                @endif
                            </div>
                        </div>

                        <!-- Comment Content -->
                        <div class="prose prose-sm max-w-none dark:prose-invert">
                            {!! nl2br(e($comment->content)) !!}
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 flex items-center space-x-4">
                            <a href="{{ route('posts.show', $comment->post->slug) }}#comment-{{ $comment->id }}" 
                               wire:navigate
                               class="text-sm text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                                {{ __('View in Post') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                {{ $this->comments->links('pagination::comments') }}
            </div>
        @else
            <!-- Empty State -->
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-zinc-400 dark:text-zinc-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">
                    @if($search)
                        {{ __('No comments found') }}
                    @else
                        {{ __('You have no comments yet') }}
                    @endif
                </h3>
                <p class="text-zinc-500 dark:text-zinc-400">
                    @if($search)
                        {{ __('Try changing your search query.') }}
                    @else
                        {{ __('Leave comments on posts to see them here.') }}
                    @endif
                </p>
                @if(!$search)
                    <flux:button 
                        href="{{ route('posts.index') }}" 
                        wire:navigate 
                        variant="primary" 
                        class="mt-4"
                    >
                        {{ __('View Posts') }}
                    </flux:button>
                @endif
            </div>
        @endif
    </div>
</div>
