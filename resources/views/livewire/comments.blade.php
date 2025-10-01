<div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-lg p-8" 
     x-data="{}" 
     @scroll-to-form.window="$nextTick(() => $refs.commentForm.scrollIntoView({ behavior: 'smooth', block: 'center' }))">
    <flux:heading size="lg" class="mb-6">Comments ({{ $comments->count() }})</flux:heading>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <p class="text-green-800 dark:text-green-200">{{ session('message') }}</p>
        </div>
    @endif

    <!-- Comment Form -->
    <form wire:submit="addComment" class="mb-8 space-y-4" x-ref="commentForm">
        @if (!auth()->check())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:field>
                        <flux:label>Name *</flux:label>
                        <flux:input wire:model="author_name" placeholder="Your name" />
                        <flux:error name="author_name" />
                    </flux:field>
                </div>
                <div>
                    <flux:field>
                        <flux:label>Email *</flux:label>
                        <flux:input type="email" wire:model="author_email" placeholder="your@email.com" />
                        <flux:error name="author_email" />
                    </flux:field>
                </div>
            </div>
        @endif

        <div>
            <flux:field>
                <flux:label>
                    @if ($reply_to)
                        Reply to comment
                        <span class="text-sm text-zinc-500 dark:text-zinc-400 ml-1">
                            ({{ $comments->flatMap(fn($c) => [$c, ...$c->replies])->firstWhere('id', $reply_to)?->author_name ?? 'comment' }})
                        </span>
                    @else
                        Your comment *
                    @endif
                </flux:label>
                <flux:textarea 
                    wire:model="content" 
                    placeholder="Write your comment..." 
                    rows="4"
                />
                <flux:error name="content" />
            </flux:field>
        </div>

        <div class="flex items-center gap-3">
            <button 
                type="submit" 
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-lg shadow-lg shadow-amber-500/25 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>
                    @if ($reply_to)
                        Post Reply
                    @else
                        Post Comment
                    @endif
                </span>
                <span wire:loading>Posting...</span>
            </button>

            @if ($reply_to)
                <flux:button type="button" variant="ghost" wire:click="cancelReply">
                    Cancel Reply
                </flux:button>
            @endif
        </div>
    </form>

    <!-- Comments List -->
    <div class="space-y-6">
        @forelse ($comments as $comment)
            <div class="comment-item {{ $reply_to === $comment->id ? 'ring-2 ring-blue-500 ring-opacity-50 rounded-lg' : '' }}" wire:key="comment-{{ $comment->id }}">
                <!-- Main Comment -->
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-sm">
                            @if ($comment->user)
                                {{ $comment->user->initials() }}
                            @else
                                {{ substr($comment->author_name, 0, 1) }}
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="bg-zinc-50 dark:bg-zinc-800 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-zinc-900 dark:text-zinc-100">
                                    {{ $comment->user->name ?? $comment->author_name }}
                                </h4>
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-zinc-700 dark:text-zinc-300 leading-relaxed">
                                {{ $comment->content }}
                            </p>
                        </div>
                        
                        <div class="mt-2 flex items-center gap-4">
                            <button 
                                wire:click="replyTo({{ $comment->id }})"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white text-sm font-semibold rounded-lg shadow-md shadow-amber-500/25 transition-all duration-200 transform hover:scale-105"
                            >
                                Reply
                            </button>
                        </div>

                        <!-- Replies -->
                        @if ($comment->replies->count() > 0)
                            <div class="mt-4 space-y-4">
                                @foreach ($comment->replies as $reply)
                                    <div class="flex items-start space-x-4 {{ $reply_to === $reply->id ? 'ring-2 ring-blue-500 ring-opacity-50 rounded-lg p-2' : '' }}" wire:key="reply-{{ $reply->id }}">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-bold text-xs">
                                                @if ($reply->user)
                                                    {{ $reply->user->initials() }}
                                                @else
                                                    {{ substr($reply->author_name, 0, 1) }}
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <div class="bg-zinc-50 dark:bg-zinc-800 rounded-lg p-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h5 class="font-semibold text-zinc-900 dark:text-zinc-100">
                                                        {{ $reply->user->name ?? $reply->author_name }}
                                                    </h5>
                                                    <span class="text-sm text-zinc-500 dark:text-zinc-400">
                                                        {{ $reply->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                                <p class="text-zinc-700 dark:text-zinc-300 leading-relaxed">
                                                    {{ $reply->content }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <p class="text-zinc-500 dark:text-zinc-400">No comments yet. Be the first to comment!</p>
            </div>
        @endforelse
    </div>
</div>
