@php
    $metaTitle = "Tag: {$tag->name}";
    $metaDescription = $tag->description ?? "Browse all posts tagged with {$tag->name}";
@endphp

<x-layouts.app 
    :metaTitle="$metaTitle"
    :metaDescription="$metaDescription">

    <div class="page-zone">

        @include('partials.breadcrumbs', ['breadcrumbs' => [
            __('Blog') => route('posts.index'),
            $tag->name => null,
        ]])

        @include('partials.heading', [
            'title' => "# {$tag->name}",
            'description' => $tag->description,
            'subDescription' => "{$posts->total()} " . Str::plural('post', $posts->total()) . " tagged with this"
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
                    {{ __('No posts found with this tag.') }}
                </flux:text>
            </div>
        @endif
    </div>
</x-layouts.app>