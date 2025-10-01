<x-layouts.app title="Welcome to Our Blog">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <flux:heading size="2xl" class="mb-4">Welcome to Our Blog</flux:heading>
            <flux:text class="text-lg text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto">
                Discover the latest insights, tutorials, and stories from our team. Stay updated with cutting-edge technology and industry trends.
            </flux:text>
        </div>

        <!-- Latest Posts Section -->
        @if($posts->count() > 0)
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <flux:heading size="xl">Latest Posts</flux:heading>
                    <flux:button href="{{ route('posts.index') }}" variant="outline" wire:navigate>
                        View All Posts
                    </flux:button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($posts as $post)
                        <article class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:shadow-md transition-shadow">
                            @if($post->featured_image)
                                <img src="{{ Storage::url($post->featured_image) }}" 
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
                                        {{ Str::limit($post->excerpt, 120) }}
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
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <flux:heading size="lg" class="mb-4">No Posts Yet</flux:heading>
                <flux:text class="text-zinc-600 dark:text-zinc-400 mb-6">
                    We're working on creating amazing content for you. Check back soon!
                </flux:text>
                @auth
                    @if(auth()->user()->is_admin)
                        <flux:button href="{{ route('dashboard') }}" variant="primary" wire:navigate>
                            Go to Admin Dashboard
                        </flux:button>
                    @endif
                @endauth
            </div>
        @endif

        <!-- Call to Action Section -->
        <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-8 text-center mt-12">
            <flux:heading size="lg" class="mb-4">Stay Updated</flux:heading>
            <flux:text class="text-zinc-600 dark:text-zinc-400 mb-6">
                Don't miss out on our latest articles and insights. Join our community of readers.
            </flux:text>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <flux:button href="{{ route('posts.index') }}" variant="primary" wire:navigate>
                    Browse All Posts
                </flux:button>
                @guest
                    <flux:button href="{{ route('register') }}" variant="outline" wire:navigate>
                        Join Our Community
                    </flux:button>
                @endguest
            </div>
        </div>
    </div>
</x-layouts.app>