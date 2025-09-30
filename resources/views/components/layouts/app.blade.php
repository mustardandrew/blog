<x-layouts.app.header 
    :title="$title ?? null"
    :description="$description ?? null"
    :keywords="$keywords ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.header>
