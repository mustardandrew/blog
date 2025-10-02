<x-layouts.app title="Dashboard">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-8">
            <flux:breadcrumbs.item href="{{ route('home') }}" wire:navigate>Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Dashboard</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        
        <!-- Page Title -->
        <div class="mb-8">
            <flux:heading size="xl">Dashboard</flux:heading>
        </div>
        
        <!-- Main content -->
        <div class="flex gap-6">
            <!-- Sidebar -->
            <x-dashboard-sidebar />

            <!-- Content Area -->
            <div class="flex-1 space-y-6">

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
                                    Welcome back!
                                </h1>
                                <p class="text-zinc-600 dark:text-zinc-400">
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

            
            </div>
        </div>
        
    </div>
</x-layouts.app>
