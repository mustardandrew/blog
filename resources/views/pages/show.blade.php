<x-layouts.app title="{{ $page->getMetaTitle() }}">
    
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="space-y-4">
            <flux:heading size="2xl" class="font-bold">
                {{ $page->title }}dcsdcvsd
            </flux:heading>
            
            @if($page->excerpt)
                <flux:text size="lg" variant="subtle">
                    {{ $page->excerpt }}ewevwevwevewvev
                </flux:text>
            @endif
            
            <flux:text size="sm" variant="muted">
                @if($page->published_at)
                    Published {{ $page->published_at->format('F j, Y') }}
                    @if($page->author)
                        by {{ $page->author->name }}
                    @endif
                @else
                    Draft
                    @if($page->author)
                        by {{ $page->author->name }}
                    @endif
                @endif
            </flux:text>
        </div>

        <!-- Admin Tools (visible only to admins when page is draft) -->
        @auth
            @if(auth()->user()->is_admin && !$page->is_published)
                <flux:callout variant="warning" class="border-orange-200 bg-orange-50 dark:border-orange-800 dark:bg-orange-950">
                    <flux:text>
                        <strong>Admin Preview:</strong> This page is in draft mode and is only visible to administrators.
                    </flux:text>
                </flux:callout>
            @endif
        @endauth

        <!-- Page Content -->
        <div class="prose prose-gray dark:prose-invert max-w-none">
            {!! $page->content !!}
        </div>

        <!-- SEO Meta Tags (hidden but important) -->
        @push('meta')
            <meta name="description" content="{{ $page->getMetaDescription() }}">
            @if($page->meta_keywords)
                <meta name="keywords" content="{{ $page->meta_keywords }}">
            @endif
            <meta property="og:title" content="{{ $page->getMetaTitle() }}">
            <meta property="og:description" content="{{ $page->getMetaDescription() }}">
            <meta property="og:type" content="article">
            @if($page->published_at)
                <meta property="article:published_time" content="{{ $page->published_at->toISOString() }}">
            @endif
            @if($page->author)
                <meta property="article:author" content="{{ $page->author->name }}">
            @endif
        @endpush
    </div>

</x-layouts.app>