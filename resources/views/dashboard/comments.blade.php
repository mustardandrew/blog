@php
    $metaTitle = __("My Comments");
    $metaDescription = __("View and manage your comments");

    $title = __('My Comments');
    $description = __('View and manage your comments');

    $breadcrumbs = [
        __('Dashboard') => route('dashboard'),
        __('MyComments') => null,
    ];
@endphp

<x-layouts.dashboard 
    :metaTitle="$metaTitle"
    :metaDescription="$metaDescription"
    :title="$title"
    :description="$description"
    :breadcrumbs="$breadcrumbs">

    <!-- Livewire Comments Management Component -->
    <livewire:dashboard.comments-management />
</x-layouts.dashboard>