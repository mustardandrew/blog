@php
    $metaTitle = __("My Avatar");
    $metaDescription = __("Manage your profile picture");

    $title = __('My Avatar');
    $description = __('Manage your profile picture');

    $breadcrumbs = [
        __('Dashboard') => route('dashboard'),
        __('Avatar') => null,
    ];
@endphp

<x-layouts.dashboard 
    :metaTitle="$metaTitle"
    :metaDescription="$metaDescription"
    :title="$title"
    :description="$description"
    :breadcrumbs="$breadcrumbs">

    <!-- Livewire Avatar Upload Component -->
    <livewire:dashboard.avatar-upload />
</x-layouts.dashboard>