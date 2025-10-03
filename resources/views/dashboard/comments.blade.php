<x-layouts.app title="{{ __('My Comments') }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-8">
            <flux:breadcrumbs.item href="{{ route('home') }}" wire:navigate>{{ __('Home') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('My Comments') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        
        <!-- Page Title -->
        <div class="mb-8">
            <flux:heading size="xl">{{ __('My Comments') }}</flux:heading>
        </div>
        
        <!-- Main content -->
        <div class="flex gap-6">
            <!-- Sidebar -->
            <div class="sticky top-6 self-start">
                <x-dashboard-sidebar />
            </div>

            <!-- Content Area -->
            <div class="flex-1 space-y-6">
                <livewire:dashboard.comments-list />
            </div>
        </div>
    </div>
</x-layouts.app>