@php
    $metaTitle = $page->meta_title ?: $page->title;
    $metaDescription = $page->meta_description ?: $page->excerpt ?: Str::limit(strip_tags($page->content), 160);
    $metaKeywords = $page->meta_keywords;
@endphp

<x-layouts.app 
    :metaTitle="$metaTitle"
    :metaDescription="$metaDescription"
    :metaKeywords="$metaKeywords">
    
    <div class="page-zone">

        @include('partials.breadcrumbs', ['breadcrumbs' => [
            Str::limit($page->title, 50) => null,
        ]])

        <!-- Admin Draft Notice -->
        @auth
            @if(auth()->user()->is_admin && !$page->is_published)
                <flux:callout variant="warning" class="mb-8">
                    <flux:callout.text>
                        This page is in draft mode and is only visible to administrators.
                    </flux:callout.text>
                </flux:callout>
            @endif
        @endauth

        <!-- Hero Section -->
        <div class="relative mb-12">
            <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-zinc-900 dark:via-zinc-800 dark:to-blue-900/20 rounded-2xl border border-blue-200/50 dark:border-blue-800/30 p-12 text-center">
                <!-- Decorative background elements -->
                <div class="absolute inset-0 bg-grid-blue-100/50 dark:bg-grid-blue-800/20 opacity-30 rounded-2xl"></div>
                <div class="absolute top-0 right-0 -translate-y-6 translate-x-6 transform">
                    <div class="w-32 h-32 bg-gradient-to-br from-blue-400/20 to-purple-400/20 rounded-full blur-2xl"></div>
                </div>
                
                <div class="relative">
                    <flux:heading size="xl" class="mb-6 text-4xl sm:text-5xl lg:text-6xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400 bg-clip-text text-transparent font-bold">
                        {{ $page->title }}
                    </flux:heading>
                    
                    @if($page->excerpt)
                        <flux:text class="text-xl leading-relaxed text-zinc-700 dark:text-zinc-300 max-w-3xl mx-auto mb-6">
                            {{ $page->excerpt }}
                        </flux:text>
                    @endif

                    <!-- Page Meta Info -->
                    <div class="flex flex-wrap justify-center items-center gap-4 text-sm text-zinc-600 dark:text-zinc-400">
                        @if($page->published_at)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Published {{ $page->published_at->format('F j, Y') }}
                            </div>
                        @else
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Draft
                            </div>
                        @endif
                        
                        @if($page->author)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                by {{ $page->author->name }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Container -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-8 shadow-sm">
                    <div class="prose prose-lg prose-gray dark:prose-invert max-w-none prose-headings:font-bold prose-headings:text-zinc-900 dark:prose-headings:text-zinc-100 prose-p:text-zinc-700 dark:prose-p:text-zinc-300 prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-strong:text-zinc-900 dark:prose-strong:text-zinc-100">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Page Info Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-zinc-800 dark:to-blue-900/20 rounded-xl border border-blue-200/50 dark:border-blue-800/30 p-6">
                    <flux:heading size="base" class="mb-4 text-blue-900 dark:text-blue-100">Page Information</flux:heading>
                    
                    <div class="space-y-3 text-sm">
                        @if($page->published_at)
                            <div class="flex items-start">
                                <span class="font-medium text-blue-800 dark:text-blue-200 mr-2">Published:</span>
                                <span class="text-blue-700 dark:text-blue-300">{{ $page->published_at->format('M j, Y') }}</span>
                            </div>
                        @endif
                        
                        @if($page->updated_at && $page->updated_at != $page->created_at)
                            <div class="flex items-start">
                                <span class="font-medium text-blue-800 dark:text-blue-200 mr-2">Updated:</span>
                                <span class="text-blue-700 dark:text-blue-300">{{ $page->updated_at->format('M j, Y') }}</span>
                            </div>
                        @endif
                        
                        @if($page->author)
                            <div class="flex items-start">
                                <span class="font-medium text-blue-800 dark:text-blue-200 mr-2">Author:</span>
                                <span class="text-blue-700 dark:text-blue-300">{{ $page->author->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Navigation -->
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
                    <flux:heading size="base" class="mb-4">Quick Navigation</flux:heading>
                    
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" 
                           wire:navigate
                           class="flex items-center text-sm text-zinc-600 dark:text-zinc-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Home
                        </a>
                        
                        <a href="{{ route('posts.index') }}" 
                           wire:navigate
                           class="flex items-center text-sm text-zinc-600 dark:text-zinc-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Blog Posts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Meta Tags -->
    @push('meta')
        <meta name="description" content="{{ $metaDescription }}">
        @if($page->meta_keywords)
            <meta name="keywords" content="{{ $page->meta_keywords }}">
        @endif
        <meta property="og:title" content="{{ $metaTitle }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:type" content="article">
        @if($page->published_at)
            <meta property="article:published_time" content="{{ $page->published_at->toISOString() }}">
        @endif
        @if($page->author)
            <meta property="article:author" content="{{ $page->author->name }}">
        @endif
    @endpush
</x-layouts.app>