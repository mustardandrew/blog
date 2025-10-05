<x-layouts.app 
    metaTitle="{{ page_title('home') }}"
    metaDescription="{{ page_description('home') }}"
    metaKeywords="{{ page_keywords('home') }}">
    
    @push('meta')
        <x-seo-meta page-key="home" />
    @endpush
    <div container class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 dark:from-zinc-900 dark:via-zinc-800 dark:to-amber-900/20 border border-amber-200/50 dark:border-amber-800/30 mb-12">
            <!-- Decorative background elements -->
            <div class="absolute inset-0 bg-grid-amber-100/50 dark:bg-grid-amber-800/20 opacity-30"></div>
            <div class="absolute top-0 right-0 -translate-y-12 translate-x-12 transform">
                <div class="w-96 h-96 bg-gradient-to-br from-amber-400/20 to-orange-400/20 rounded-full blur-3xl"></div>
            </div>
            <div class="absolute bottom-0 left-0 translate-y-12 -translate-x-12 transform">
                <div class="w-80 h-80 bg-gradient-to-br from-yellow-400/20 to-amber-400/20 rounded-full blur-3xl"></div>
            </div>
            
            <!-- Content -->
            <div class="relative px-8 py-16 sm:px-12 sm:py-20 text-center">
                <div class="mx-auto max-w-4xl">
                    <flux:heading size="xl" class="mb-6 text-4xl sm:text-5xl lg:text-6xl bg-gradient-to-r from-amber-600 via-orange-600 to-yellow-600 dark:from-amber-400 dark:via-orange-400 dark:to-yellow-400 bg-clip-text text-transparent font-bold">
                        Welcome to LitBlog
                    </flux:heading>
                    <flux:text class="text-xl leading-relaxed text-zinc-700 dark:text-zinc-300 max-w-3xl mx-auto mb-8">
                        Discover the captivating world of literature through my personal impressions of books I've read. Share thoughts about your favorite works and find new literary treasures.
                    </flux:text>
                    
                    <!-- Call to action buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="{{ route('posts.index') }}" 
                           wire:navigate
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-lg shadow-lg shadow-amber-500/25 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Read Reviews
                        </a>
                        <a href="#latest-posts"
                           class="inline-flex items-center px-6 py-3 border-2 border-amber-300 dark:border-amber-600 text-amber-700 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 font-semibold rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                            Latest Reviews
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Posts Section -->
        @if($posts->count() > 0)
            <div id="latest-posts" class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <flux:heading size="xl">Latest Reviews</flux:heading>
                    <flux:button href="{{ route('posts.index') }}" variant="outline" wire:navigate>
                        All Reviews
                    </flux:button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($posts as $post)
                        <x-post-card :post="$post" />
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

    </div>
</x-layouts.app>