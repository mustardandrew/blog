<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <div class="flex flex-col min-h-screen">
            <!-- Header Component -->
            @include('partials.header')

            <!-- Search Panel Component -->
            <livewire:search-panel />

            <!-- Mobile Menu -->
            @include('partials.mobile-sidebar')

            <main class="flex-1 lg:ml-0">
                <flux:main>
                    {{ $slot }}
                </flux:main>
            </main>
            
            <!-- Newsletter Subscription Section -->
            @include('partials.newsletter-subscription')
            
            <!-- Footer Section -->
            @include('partials.footer')
        </div>

        @fluxScripts
    </body>
</html>
