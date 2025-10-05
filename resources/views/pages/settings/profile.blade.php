@php
    $metaTitle = __("Update Profile");
    $metaDescription = __("Manage your profile information");

    $title = __('Profile');
    $description = __('Manage your profile information');

    $breadcrumbs = [
        __('Dashboard') => route('dashboard'),
        __('Profile') => null,
    ];
@endphp

<x-layouts.dashboard 
    :metaTitle="$metaTitle"
    :metaDescription="$metaDescription"
    :title="$title"
    :description="$description"
    :breadcrumbs="$breadcrumbs">

    @include('partials.heading', [
        'title' => __('Update profile'),
        'description' => __('Update your profile information'),
    ])
    <x-separator />

    <!-- Livewire Update Profile Component -->
    <livewire:settings.update-profile />
    <!-- Livewire Delete User Component -->
    <livewire:settings.delete-user />
</x-layouts.dashboard>