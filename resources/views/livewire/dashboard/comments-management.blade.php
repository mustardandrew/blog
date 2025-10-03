<div class="space-y-6">
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <flux:text color="green">
                {{ session('message') }}
            </flux:text>
        </div>
    @endif

    {{-- Error Messages --}}
    @error('general')
        <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <flux:text color="red">
                {{ $message }}
            </flux:text>
        </div>
    @enderror

    {{-- Search Input --}}
    <flux:input 
        wire:model.live.debounce.300ms="search" 
        placeholder="Search comments..." 
        icon="magnifying-glass"
        label="Search Comments"
    />

    {{-- Comments List --}}
    <div class="space-y-4">
        @forelse ($this->comments as $comment)
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-6 space-y-4">
                {{-- Comment Header --}}
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <flux:heading size="sm" class="mb-1">
                            {{ $comment->post->title }}
                        </flux:heading>
                        <flux:text size="sm" variant="muted">
                            {{ $comment->created_at->format('M j, Y \a\t g:i A') }}
                        </flux:text>
                    </div>
                    <flux:badge 
                        color="{{ $comment->is_approved ? 'green' : 'yellow' }}" 
                        size="sm"
                    >
                        {{ $comment->is_approved ? 'Approved' : 'Pending Review' }}
                    </flux:badge>
                </div>
                
                {{-- Comment Content --}}
                <div>
                    <flux:text class="text-zinc-700 dark:text-zinc-300">
                        {{ $comment->content }}
                    </flux:text>
                </div>
                
                {{-- Comment Actions --}}
                <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-2">
                        <flux:button 
                            variant="ghost" 
                            size="sm"
                            href="{{ route('posts.show', $comment->post) }}#comment-{{ $comment->id }}"
                            icon:trailing="arrow-top-right-on-square"
                        >
                            View on post
                        </flux:button>
                        
                        <flux:button 
                            variant="ghost" 
                            size="sm"
                            color="red"
                            icon="trash"
                            wire:click="deleteComment({{ $comment->id }})"
                            wire:confirm="Are you sure you want to delete this comment?"
                        >
                            Delete
                        </flux:button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg">
                <flux:text variant="muted" class="text-center">
                    You have no comments yet.
                </flux:text>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($this->comments->hasPages())
        {{ $this->comments->links('vendor.pagination.comments') }}
    @endif
</div>
