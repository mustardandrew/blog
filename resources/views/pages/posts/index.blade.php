<x-layouts.app 
    metaTitle="{{ page_title('blog', __('All posts')) }}"
    metaDescription="{{ page_description('blog', __('Browse all posts')) }}"
    metaKeywords="{{ page_keywords('blog') ?? __('blog, posts') }}">

    @push('meta')
        <x-seo-meta page-key="blog" />
    @endpush

    <div class="page-zone">

        @include('partials.breadcrumbs', ['breadcrumbs' => [
            __('Blog') => null,
        ]])

        @include('partials.heading', [
            'title' => __('Blog Posts'),
            'description' => __('Discover our latest articles and insights'),
        ])

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
                    {{ __('No posts published yet.') }}
                </flux:text>
            </div>
        @endif
    </div>
</x-layouts.app>