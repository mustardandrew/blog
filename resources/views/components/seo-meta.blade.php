@props(['pageKey' => null, 'title' => null, 'description' => null, 'keywords' => null])

@php
    $seoTitle = $title ?? page_title($pageKey ?? 'home');
    $seoDescription = $description ?? page_description($pageKey ?? 'home');
    $seoKeywords = $keywords ?? page_keywords($pageKey ?? 'home');
    $seoRobots = page_robots($pageKey ?? 'home');
    $seo = page_seo($pageKey ?? 'home');
@endphp

{{-- Basic meta tags --}}
<title>{{ $seoTitle }}</title>
@if($seoDescription)
    <meta name="description" content="{{ $seoDescription }}">
@endif

@if($seoKeywords)
    <meta name="keywords" content="{{ $seoKeywords }}">
@endif

<meta name="robots" content="{{ $seoRobots }}">

{{-- Open Graph meta tags --}}
<meta property="og:title" content="{{ $seoTitle }}">
@if($seoDescription)
    <meta property="og:description" content="{{ $seoDescription }}">
@endif
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="{{ config('app.name') }}">

{{-- Twitter Card meta tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
@if($seoDescription)
    <meta name="twitter:description" content="{{ $seoDescription }}">
@endif

{{-- Additional meta tags from JSON --}}
@if($seo && $seo->additional_meta)
    @foreach($seo->additional_meta as $name => $content)
        @if(str_starts_with($name, 'og:') || str_starts_with($name, 'twitter:'))
            <meta property="{{ $name }}" content="{{ $content }}">
        @else
            <meta name="{{ $name }}" content="{{ $content }}">
        @endif
    @endforeach
@endif