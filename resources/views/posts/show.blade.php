@php
    $metaTitle = $post->meta_title ?: $post->title;
    $metaDescription = $post->meta_description ?: $post->excerpt ?: Str::limit(strip_tags($post->content), 160);
@endphp

<x-layouts.app 
    :title="$metaTitle"
    :description="$metaDescription"
    :keywords="$post->meta_keywords ? implode(', ', $post->meta_keywords) : null">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-8">
            <flux:breadcrumbs.item href="{{ route('home') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('posts.index') }}">Blog</flux:breadcrumbs.item>
            @if($post->categories->isNotEmpty())
                <flux:breadcrumbs.item href="{{ route('posts.index', ['category' => $post->categories->first()->slug]) }}">
                    {{ $post->categories->first()->name }}
                </flux:breadcrumbs.item>
            @endif
            <flux:breadcrumbs.item>{{ Str::limit($post->title, 50) }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        @if($post->isDraft() && auth()->check() && auth()->user()->is_admin)
            <flux:callout variant="warning" class="mb-8">
                <flux:callout.text>
                    This post is in draft mode and is only visible to administrators.
                </flux:callout.text>
            </flux:callout>
        @endif

        <!-- Hero Section -->
        <div class="relative mb-12">
            <div class="relative h-96 sm:h-[28rem] rounded-2xl overflow-hidden shadow-2xl">
                <img src="{{ $post->featured_image_url }}" 
                     alt="{{ $post->title }}"
                     class="w-full h-full object-cover">
                
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                
                <!-- Hero Content -->
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <div class="w-full">
                        <flux:heading size="xl" class="mb-4 text-white font-bold leading-none text-4xl sm:text-5xl lg:text-6xl drop-shadow-lg">
                            {{ $post->title }}
                        </flux:heading>
                        
                        @if($post->excerpt)
                            <p class="text-xl text-white/90 font-medium mb-4 leading-relaxed drop-shadow-md">
                                {{ $post->excerpt }}
                            </p>
                        @endif
                        
                        <div class="flex items-center text-white/80">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                    <span class="text-sm font-semibold">{{ $post->user->initials() }}</span>
                                </div>
                                <div>
                                    <div class="font-medium drop-shadow-md">{{ $post->user->name }}</div>
                                    @if($post->published_at)
                                        <div class="text-sm text-white/70 drop-shadow-md">
                                            {{ $post->published_at->format('F j, Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <article class="bg-white dark:bg-zinc-900 rounded-2xl shadow-lg p-8 mb-8">
                    <div class="post-content">
                        {!! $post->content !!}
                    </div>
                </article>

                <!-- Comments Section -->
                @livewire('comments', ['post' => $post])
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Sticky Container for Author and Post Details -->
                <div class="sticky top-6 space-y-6">
                    <!-- Author Card -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-lg p-6">
                        <flux:heading size="lg" class="mb-4">About the Author</flux:heading>
                        <div class="flex items-start space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-lg">{{ $post->user->initials() }}</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-lg text-zinc-900 dark:text-zinc-100 mb-2">
                                    {{ $post->user->name }}
                                </h4>
                                <p class="text-zinc-600 dark:text-zinc-400 text-sm leading-relaxed">
                                    {{ $post->user->bio ?? 'Content creator and developer passionate about sharing knowledge and building amazing web experiences.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Post Meta -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-lg p-6">
                        <flux:heading size="lg" class="mb-4">Post Details</flux:heading>
                        <div class="space-y-3">
                            @if($post->published_at)
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">Published</div>
                                        <div class="font-medium">{{ $post->published_at->format('M j, Y') }}</div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Reading time</div>
                                    <div class="font-medium">{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</div>
                                </div>
                            </div>

                            @if($post->categories->count() > 0)
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mt-0.5">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">Categories</div>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($post->categories as $category)
                                                <a href="{{ route('posts.index', ['category' => $category->slug]) }}" class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-md hover:bg-green-100 dark:hover:bg-green-800/30 transition-colors">
                                                    @if($category->color)
                                                        <span class="w-1.5 h-1.5 rounded-full mr-1" style="background-color: {{ $category->color }}"></span>
                                                    @endif
                                                    {{ $category->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($post->tags->count() > 0)
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mt-0.5">
                                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">Tags</div>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($post->tags as $tag)
                                                <a href="{{ route('posts.index', ['tag' => $tag->slug]) }}" class="inline-flex items-center px-2 py-1 text-xs font-medium bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 rounded-md hover:bg-purple-100 dark:hover:bg-purple-800/30 transition-colors">
                                                    @if($tag->color)
                                                        <span class="w-1.5 h-1.5 rounded-full mr-1" style="background-color: {{ $tag->color }}"></span>
                                                    @endif
                                                    {{ $tag->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="mt-12 pt-8 border-t border-zinc-200 dark:border-zinc-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <flux:button href="{{ route('posts.index') }}" variant="outline" wire:navigate class="sm:w-auto">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to all posts
                </flux:button>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Share this post:</span>
                    <div class="flex space-x-2">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                           target="_blank" 
                           class="w-8 h-8 bg-zinc-100 hover:bg-blue-100 dark:bg-zinc-800 dark:hover:bg-blue-900/30 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-zinc-600 dark:text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           class="w-8 h-8 bg-zinc-100 hover:bg-blue-100 dark:bg-zinc-800 dark:hover:bg-blue-900/30 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-zinc-600 dark:text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M20 10C20 4.477 15.523 0 10 0S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($post->title) }}" 
                           target="_blank" 
                           class="w-8 h-8 bg-zinc-100 hover:bg-blue-100 dark:bg-zinc-800 dark:hover:bg-blue-900/30 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-zinc-600 dark:text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.338 16.338H13.67V12.16c0-.995-.017-2.277-1.387-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248H8.014v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092v4.711zM5.005 6.575a1.548 1.548 0 11-.003-3.096 1.548 1.548 0 01.003 3.096zm-1.337 9.763H6.34v-8.59H3.667v8.59zM17.668 1H2.328C1.595 1 1 1.581 1 2.298v15.403C1 18.418 1.595 19 2.328 19h15.34c.734 0 1.332-.582 1.332-1.299V2.298C19 1.581 18.402 1 17.668 1z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>