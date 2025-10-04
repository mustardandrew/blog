<x-layouts.app 
    title="Мої закладки" 
    description="Переглядайте збережені статті та швидко знаходьте цікаві публікації">
    
    <div class="page-zone">
        @include('partials.breadcrumbs', ['breadcrumbs' => [
            __('Home') => route('home'),
            __('Dashboard') => route('dashboard'),
            __('Avatar') => null,
        ]])

        @include('partials.heading', [
            'title' => __('Avatar'),
            'description' => __('Manage your profile picture'),
        ])
        
        <!-- Main content -->
        <div class="flex gap-3 md:gap-6">
            <!-- Sidebar -->
            <div class="sticky top-6 self-start">
                <x-dashboard-sidebar />
            </div>

            <!-- Content Area -->
            <div class="flex-1 space-y-6 min-w-0">
                <!-- Livewire Avatar Upload Component -->
                <livewire:dashboard.avatar-upload />
            </div>
        </div>
    </div>
</x-layouts.app>