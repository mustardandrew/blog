<?php

declare(strict_types=1);

use App\Models\PageSeo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create page seo', function () {
    $seo = PageSeo::create([
        'key' => 'home',
        'title' => 'Home Page',
        'meta_description' => 'Welcome to our home page',
        'keywords' => 'home, website, welcome',
        'noindex' => false,
        'nofollow' => false,
    ]);

    expect($seo->key)->toBe('home');
    expect($seo->title)->toBe('Home Page');
    expect($seo->meta_description)->toBe('Welcome to our home page');
});

test('can find page seo by key', function () {
    PageSeo::create([
        'key' => 'blog',
        'title' => 'Blog Page',
        'meta_description' => 'Our blog',
    ]);

    $seo = PageSeo::getByKey('blog');

    expect($seo)->not->toBeNull();
    expect($seo->key)->toBe('blog');
    expect($seo->title)->toBe('Blog Page');
});

test('returns null for non-existent key', function () {
    $seo = PageSeo::getByKey('non-existent');

    expect($seo)->toBeNull();
});

test('generates correct robots meta', function () {
    $indexSeo = PageSeo::create([
        'key' => 'indexed',
        'noindex' => false,
        'nofollow' => false,
    ]);

    $noIndexSeo = PageSeo::create([
        'key' => 'noindex',
        'noindex' => true,
        'nofollow' => false,
    ]);

    $noFollowSeo = PageSeo::create([
        'key' => 'nofollow',
        'noindex' => false,
        'nofollow' => true,
    ]);

    $noBothSeo = PageSeo::create([
        'key' => 'noboth',
        'noindex' => true,
        'nofollow' => true,
    ]);

    expect($indexSeo->robots)->toBe('index, follow');
    expect($noIndexSeo->robots)->toBe('noindex, follow');
    expect($noFollowSeo->robots)->toBe('index, nofollow');
    expect($noBothSeo->robots)->toBe('noindex, nofollow');
});

test('converts keywords string to array', function () {
    $seo = PageSeo::create([
        'key' => 'keywords-test',
        'keywords' => 'word1, word2, word3',
    ]);

    expect($seo->keywords_array)->toBe(['word1', 'word2', 'word3']);
});

test('handles empty keywords', function () {
    $seo = PageSeo::create([
        'key' => 'no-keywords',
        'keywords' => null,
    ]);

    expect($seo->keywords_array)->toBe([]);
});

test('key must be unique', function () {
    PageSeo::create([
        'key' => 'unique-key',
        'title' => 'First',
    ]);

    $this->expectException(\Illuminate\Database\QueryException::class);

    PageSeo::create([
        'key' => 'unique-key',
        'title' => 'Second',
    ]);
});

test('handles additional meta as json', function () {
    $meta = [
        'og:type' => 'website',
        'og:image' => '/image.jpg',
    ];

    $seo = PageSeo::create([
        'key' => 'meta-test',
        'additional_meta' => $meta,
    ]);

    expect($seo->additional_meta)->toBe($meta);
});
