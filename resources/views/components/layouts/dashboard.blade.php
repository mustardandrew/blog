<x-layouts.app
    :metaTitle="$metaTitle ?? null"
    :metaDescription="$metaDescription ?? null"
    :metaKeywords="$metaKeywords ?? null">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Breadcrumbs -->
        @isset($breadcrumbs)
            @include('partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
        @endisset

        <!-- Heading -->
        @include('partials.heading', [
            'title' => $title ?? null,
            'description' => $description ?? null,
            'subdescription' => $subdescription ?? null,
        ])
        
        <!-- Main content -->
        <div class="flex gap-3 md:gap-6">
            <!-- Sidebar -->
            <div class="sticky top-6 self-start">
                <x-dashboard-sidebar />
            </div>

            <!-- Content Area -->
            <div class="flex-1 space-y-6 min-w-0">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-layouts.app>
