@php
    $metaTitle = $post->meta_title ?: $post->title;
    $metaDescription = $post->meta_description ?: $post->excerpt ?: Str::limit(strip_tags($post->content), 160);
@endphp

<x-layouts.app 
    :title="$metaTitle"
    :description="$metaDescription"
    :keywords="$post->meta_keywords ? implode(', ', $post->meta_keywords) : null">
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($post->isDraft() && auth()->check() && auth()->user()->is_admin)
            <flux:callout variant="warning" class="mb-6">
                <flux:callout.text>
                    This post is in draft mode and is only visible to administrators.
                </flux:callout.text>
            </flux:callout>
        @endif

        <article>
            <header class="mb-8">
                <img src="{{ $post->featured_image_url }}" 
                     alt="{{ $post->title }}"
                     class="w-full h-64 sm:h-80 object-cover rounded-lg mb-6">

                <flux:heading size="2xl" class="mb-4">{{ $post->title }}</flux:heading>
                
                <div class="flex items-center text-zinc-600 dark:text-zinc-400 mb-4">
                    <span>By {{ $post->user->name }}</span>
                    @if($post->published_at)
                        <span class="mx-2">•</span>
                        <time datetime="{{ $post->published_at->toISOString() }}">
                            {{ $post->published_at->format('F j, Y \a\t g:i A') }}
                        </time>
                    @endif
                </div>

                @if($post->excerpt)
                    <flux:text size="lg" class="text-zinc-700 dark:text-zinc-300 font-medium">
                        {{ $post->excerpt }}
                    </flux:text>
                @endif
            </header>

            <div class="prose prose-zinc dark:prose-invert max-w-none">
                {!! $post->content !!}
            </div>

            @if($post->meta_keywords)
                <footer class="mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:text size="sm" class="text-zinc-500 dark:text-zinc-400 mb-2">Tags:</flux:text>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->meta_keywords as $keyword)
                            <flux:badge>{{ $keyword }}</flux:badge>
                        @endforeach
                    </div>
                </footer>
            @endif
        </article>

        <div class="mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-700">
            <flux:button href="{{ route('posts.index') }}" variant="outline" wire:navigate>
                ← Back to all posts
            </flux:button>
        </div>
    </div>
</x-layouts.app>