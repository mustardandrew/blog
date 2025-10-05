@php
    $metaTitle = __("My Bookmarks");
    $metaDescription = __("View your saved articles and quickly find interesting posts");

    $title = __('My Bookmarks');
    $description = __('View your saved articles and quickly find interesting posts');

    $breadcrumbs = [
        __('Dashboard') => route('dashboard'),
        __('Bookmarks') => null,
    ];
@endphp

<x-layouts.dashboard 
    :metaTitle="$metaTitle"
    :metaDescription="$metaDescription"
    :title="$title"
    :description="$description"
    :breadcrumbs="$breadcrumbs">

    <!-- Livewire Bookmarks Component -->
    <livewire:dashboard.bookmarks />
</x-layouts.dashboard>