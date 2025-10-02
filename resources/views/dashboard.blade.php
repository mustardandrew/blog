<x-layouts.app :title="__('Dashboard')">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-8">
            <flux:breadcrumbs.item href="{{ route('home') }}" wire:navigate>Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Dashboard</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Welcome Section with User Avatar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <livewire:components.user-avatar 
                        :user="auth()->user()" 
                        size="xl" 
                        :show-name="true" 
                    />
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            Welcome back!
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400">
                            @if(auth()->user()->isAdmin())
                                You're logged in as an Administrator
                            @else
                                You're logged in as a User
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
        </div>
    </div>
</x-layouts.app>
