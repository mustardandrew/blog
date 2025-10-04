<x-layouts.app title="Blog Posts">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-8">
            <flux:breadcrumbs.item href="{{ route('home') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Blog</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="mb-8">
            <flux:heading size="xl">Blog Posts</flux:heading>
            <flux:text class="mt-2 text-zinc-600 dark:text-zinc-400">
                Discover our latest articles and insights
            </flux:text>
        </div>

        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($posts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>

            <div class="flex justify-center mt-8">
                {{ $posts->links('partials.pagination.blog') }}
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