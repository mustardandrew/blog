@php
    $metaTitle = __("Dashboard");
    $metaDescription = __("Welcome to your dashboard");

    $title = __('Dashboard');
    $description = __('Overview of your account and activities');

    $breadcrumbs = [
        __('Dashboard') => null,
    ];
@endphp

<x-layouts.dashboard 
    :metaTitle="$metaTitle"
    :metaDescription="$metaDescription"
    :title="$title"
    :description="$description"
    :breadcrumbs="$breadcrumbs">

    <!-- Welcome Section with User Avatar -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <livewire:components.user-avatar
                    :user="auth()->user()" 
                    size="xl" 
                    :show-name="true" 
                />
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                        {{ __('Welcome back!') }}
                    </h1>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        @if(auth()->user()->isAdmin())
                            {{ __("You're logged in as an Administrator") }}
                        @else
                            {{ __("You're logged in as a User") }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-layouts.>
