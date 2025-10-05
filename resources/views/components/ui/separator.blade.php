@props([
    'orientation' => 'horizontal', // 'horizontal' or 'vertical'
    'thickness' => null, // e.g. '2px', '0.5'
    'color' => null, // e.g. 'bg-red-500'
    'margin' => null, // e.g. 'my-4', 'mx-2'
])

@php
    $isVertical = $orientation === 'vertical';
    $baseClasses = $isVertical
        ? 'h-full w-px'
        : 'w-full h-px';

    $thicknessClass = $thickness
        ? ($isVertical ? "w-[$thickness]" : "h-[$thickness]")
        : '';

    $colorClass = $color
        ? $color
        : 'bg-black/10 dark:bg-white/10';

    $marginClass = $margin
        ? $margin
        : ($isVertical ? 'mx-4' : 'my-4');
@endphp

<div {{ $attributes->merge([
    'class' => trim("{$baseClasses} {$thicknessClass} {$colorClass} {$marginClass}")
]) }}></div>