<x-layouts.app title="Мої закладки" description="Переглядайте збережені статті та швидко знаходьте цікаві публікації">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-8">
            <flux:breadcrumbs.item href="{{ route('home') }}" wire:navigate>Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Закладки</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        
        <!-- Page Title -->
        <div class="mb-8">
            <flux:heading size="xl">Мої закладки</flux:heading>
        </div>
        
        <!-- Main content -->
        <div class="flex gap-3 md:gap-6">
            <!-- Sidebar -->
            <div class="sticky top-6 self-start">
                <x-dashboard-sidebar />
            </div>

            <!-- Content Area -->
            <div class="flex-1 space-y-6 min-w-0">
                <!-- Livewire Bookmarks Component -->
                <livewire:dashboard.bookmarks />
            </div>
        </div>
    </div>
</x-layouts.app>