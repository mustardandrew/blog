<x-layouts.app title="Blog Posts">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <flux:heading size="xl">Blog Posts</flux:heading>
            <flux:text class="mt-2 text-zinc-600 dark:text-zinc-400">
                Discover our latest articles and insights
            </flux:text>
        </div>

        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($posts as $post)
                    <article class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:shadow-md transition-shadow">
                        @if($post->featured_image_url)
                            <img src="{{ $post->featured_image_url }}" 
                                 alt="{{ $post->title }}"
                                 class="w-full h-48 object-cover">
                        @endif
                        
                        <div class="p-6">
                            <div class="flex items-center text-sm text-zinc-500 dark:text-zinc-400 mb-2">
                                <span>{{ $post->user->name }}</span>
                                <span class="mx-2">•</span>
                                <time datetime="{{ $post->published_at->toISOString() }}">
                                    {{ $post->published_at->format('M j, Y') }}
                                </time>
                            </div>
                            
                            <flux:heading size="lg" class="mb-2">
                                <a href="{{ route('posts.show', $post->slug) }}" 
                                   class="text-zinc-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                                   wire:navigate>
                                    {{ $post->title }}
                                </a>
                            </flux:heading>
                            
                            @if($post->excerpt)
                                <flux:text class="text-zinc-600 dark:text-zinc-400 mb-4">
                                    {{ $post->excerpt }}
                                </flux:text>
                            @endif
                            
                            <flux:button href="{{ route('posts.show', $post->slug) }}" 
                                        variant="outline" 
                                        size="sm"
                                        wire:navigate>
                                Read more
                            </flux:button>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <flux:text size="lg" class="text-zinc-500 dark:text-zinc-400">
                    No posts published yet.
                </flux:text>
            </div>
        @endif
    </div>
</x-layouts.app>