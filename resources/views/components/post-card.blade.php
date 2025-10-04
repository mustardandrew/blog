@props(['post'])

<article class="group relative bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200/60 dark:border-zinc-700/60 overflow-hidden hover:shadow-xl hover:shadow-zinc-900/10 dark:hover:shadow-zinc-950/20 transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">
    <!-- Image with overlay gradient -->
    <div class="relative overflow-hidden">
        <img src="{{ $post->featured_image_url }}" 
             alt="{{ $post->title }}"
             class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-700">
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        
        <!-- Category badge -->
        @if($post->category)
            <div class="absolute top-4 left-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/90 dark:bg-zinc-800/90 text-zinc-800 dark:text-zinc-200 backdrop-blur-sm border border-white/20">
                    {{ $post->category->name }}
                </span>
            </div>
        @endif
    </div>
    
    <div class="p-6 flex flex-col flex-grow">
        <!-- Author and date -->
        <div class="flex items-center text-sm text-zinc-500 dark:text-zinc-400 mb-3">
            <div class="flex items-center">
                <div class="w-6 h-6 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-white text-xs font-semibold mr-2">
                    {{ substr($post->user->name, 0, 1) }}
                </div>
                <span class="font-medium">{{ $post->user->name }}</span>
            </div>
            <span class="mx-2">•</span>
            <time datetime="{{ $post->published_at->toISOString() }}" class="font-medium">
                {{ $post->published_at->format('M j, Y') }}
            </time>
        </div>
        
        <!-- Title -->
        <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-3 line-clamp-2 leading-tight">
            <a href="{{ route('posts.show', $post) }}" class="hover:bg-gradient-to-r hover:from-amber-600 hover:to-orange-600 hover:bg-clip-text hover:text-transparent transition-all duration-300">
                {{ $post->title }}
            </a>
        </h3>
        
        <!-- Excerpt -->
        <div class="flex-grow">
            @if($post->excerpt)
                <p class="text-zinc-600 dark:text-zinc-400 line-clamp-3 leading-relaxed">
                    {{ $post->excerpt }}
                </p>
            @endif
        </div>
        
        <!-- Tags -->
        @if($post->tags->count() > 0)
            <div class="flex flex-wrap gap-2 mt-4 mb-4">
                @foreach($post->tags->take(3) as $tag)
                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-amber-100 dark:hover:bg-amber-900/20 hover:text-amber-700 dark:hover:text-amber-400 transition-colors">
                        #{{ $tag->name }}
                    </span>
                @endforeach
                @if($post->tags->count() > 3)
                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium text-zinc-400 dark:text-zinc-500">
                        +{{ $post->tags->count() - 3 }} more
                    </span>
                @endif
            </div>
        @endif
        
        <!-- Footer with read more -->
        <div class="flex items-center justify-between mt-auto pt-4 border-t border-zinc-100 dark:border-zinc-800">
            <!-- Reading time estimation -->
            <div class="flex items-center text-xs text-zinc-400 dark:text-zinc-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ max(1, ceil(str_word_count(strip_tags($post->content)) / 200)) }} min read
            </div>
            
            <div class="flex items-center gap-3">
                <!-- Bookmark button -->
                @auth
                    @livewire('bookmark-button', ['post' => $post, 'size' => 'sm'])
                @endauth
                
                <!-- Read more button -->
                <a href="{{ route('posts.show', $post) }}" 
                   class="inline-flex items-center text-sm font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 group-hover:translate-x-1 transition-all duration-300">
                    Read more →
                </a>
            </div>
        </div>
    </div>
</article>