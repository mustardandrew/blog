@php
    $metaTitle = __("Update Password");
    $metaDescription = __("Manage your password information");

    $title = __('Password');
    $description = __('Manage your password information');

    $breadcrumbs = [
        __('Dashboard') => route('dashboard'),
        __('Password') => null,
    ];
@endphp

<x-layouts.dashboard 
    :metaTitle="$metaTitle"
    :metaDescription="$metaDescription"
    :title="$title"
    :description="$description"
    :breadcrumbs="$breadcrumbs">

    @include('partials.heading', [
        'title' => __('Update password'),
        'description' => __('Ensure your account is using a long, random password to stay secure'),
    ])
    <x-separator />

    <!-- Livewire Update Profile Component -->
    <livewire:settings.update-password />
</x-layouts.dashboard>