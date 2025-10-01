@props(['post'])

<article class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:shadow-md transition-shadow flex flex-col h-full">
    <img src="{{ $post->featured_image_url }}" 
         alt="{{ $post->title }}"
         class="w-full h-48 object-cover">
    
    <div class="p-6 flex flex-col flex-grow">
        <div class="flex items-center text-sm text-zinc-500 dark:text-zinc-400 mb-2">
            <span>{{ $post->user->name }}</span>
            <span class="mx-2">•</span>
            <span>{{ $post->published_at->format('M j, Y') }}</span>
        </div>
        
        <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-3 line-clamp-2">
            <a href="{{ route('posts.show', $post) }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                {{ $post->title }}
            </a>
        </h3>
        
        <div class="flex-grow">
            @if($post->excerpt)
                <p class="text-zinc-600 dark:text-zinc-400 line-clamp-3">
                    {{ $post->excerpt }}
                </p>
            @endif
        </div>
        
        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('posts.show', $post) }}" 
               class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-300 transition-colors">
                Read more →
            </a>
        </div>
    </div>
</article>