@isset($breadcrumbs)
    <!-- Breadcrumbs -->
    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('home') }}">{{ __('Home') }}</flux:breadcrumbs.item>
        @foreach ($breadcrumbs as $label => $link)
            @if($loop->last)
                <flux:breadcrumbs.item>{{ $label }}</flux:breadcrumbs.item>
            @else
                <flux:breadcrumbs.item href="{{ $link }}">{{ $label }}</flux:breadcrumbs.item>
            @endif
        @endforeach
    </flux:breadcrumbs>
@endisset

