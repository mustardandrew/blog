@php
    $metaTitle = __("Two Factor Authentication");
    $metaDescription = __("Manage your two factor authentication settings");

    $title = __('Two Factor Authentication');
    $description = __('Manage your two factor authentication settings');

    $breadcrumbs = [
        __('Dashboard') => route('dashboard'),
        __('Two Factor Authentication') => null,
    ];
@endphp

<x-layouts.dashboard 
    :metaTitle="$metaTitle"
    :metaDescription="$metaDescription"
    :title="$title"
    :description="$description"
    :breadcrumbs="$breadcrumbs">

    @include('partials.heading', [
        'title' => __('Two Factor Authentication'),
        'description' => __('Manage your two factor authentication settings'),
    ])
    <x-separator />

    <!-- Livewire Two Factor Authentication Component -->
    <livewire:settings.two-factor />
</x-layouts.dashboard>