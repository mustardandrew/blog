<div class="mb-8">
    @isset($title)
        <flux:heading size="xl">{{ $title }}</flux:heading>
    @endisset
    @if($description)
        <flux:text class="mt-2 text-zinc-600 dark:text-zinc-400">
            {{ $description }}
        </flux:text>
    @endif
    @isset($subDescription)
        <flux:text class="mt-2 text-sm text-zinc-500 dark:text-zinc-500">
        {{ $subDescription }}
    </flux:text>
    @endisset
</div>