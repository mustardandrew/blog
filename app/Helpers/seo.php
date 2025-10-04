<?php

if (! function_exists('page_seo')) {
    /**
     * Get SEO data for a page by key
     */
    function page_seo(string $key): ?\App\Models\PageSeo
    {
        return \App\Models\PageSeo::getByKey($key);
    }
}

if (! function_exists('page_title')) {
    /**
     * Get page title with fallback
     */
    function page_title(string $key, ?string $fallback = null): string
    {
        $seo = page_seo($key);

        return $seo?->title ?? $fallback ?? config('app.name');
    }
}

if (! function_exists('page_description')) {
    /**
     * Get page meta description with fallback
     */
    function page_description(string $key, ?string $fallback = null): ?string
    {
        $seo = page_seo($key);

        return $seo?->meta_description ?? $fallback;
    }
}

if (! function_exists('page_keywords')) {
    /**
     * Get page keywords as string
     */
    function page_keywords(string $key): ?string
    {
        $seo = page_seo($key);

        return $seo?->keywords;
    }
}

if (! function_exists('page_robots')) {
    /**
     * Get robots meta content
     */
    function page_robots(string $key): string
    {
        $seo = page_seo($key);

        return $seo?->robots ?? 'index, follow';
    }
}
