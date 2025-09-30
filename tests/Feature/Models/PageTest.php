<?php

declare(strict_types=1);

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('page belongs to an author', function () {
    $author = User::factory()->create();
    $page = Page::factory()->create(['author_id' => $author->id]);

    expect($page->author)->toBeInstanceOf(User::class)
        ->and($page->author->id)->toBe($author->id);
});

test('page slug is auto-generated from title', function () {
    $page = Page::factory()->make(['title' => 'Test Page Title', 'slug' => '']);
    $page->save();

    expect($page->slug)->toBe('test-page-title');
});

test('page can be published', function () {
    $page = Page::factory()->published()->create();

    expect($page->isPublished())->toBeTrue();
});

test('page can be draft', function () {
    $page = Page::factory()->draft()->create();

    expect($page->isPublished())->toBeFalse();
});

test('published scope returns only published pages', function () {
    Page::factory()->published()->count(3)->create();
    Page::factory()->draft()->count(2)->create();

    $publishedPages = Page::published()->get();

    expect($publishedPages)->toHaveCount(3);
});

test('draft scope returns only draft pages', function () {
    Page::factory()->published()->count(3)->create();
    Page::factory()->draft()->count(2)->create();

    $draftPages = Page::draft()->get();

    expect($draftPages)->toHaveCount(2);
});

test('page returns correct meta title', function () {
    $page = Page::factory()->create([
        'title' => 'Page Title',
        'meta_title' => 'Custom Meta Title',
    ]);

    expect($page->getMetaTitle())->toBe('Custom Meta Title');

    $pageWithoutMeta = Page::factory()->create([
        'title' => 'Page Title',
        'meta_title' => null,
    ]);

    expect($pageWithoutMeta->getMetaTitle())->toBe('Page Title');
});

test('page returns correct meta description', function () {
    $page = Page::factory()->create([
        'excerpt' => 'Page excerpt',
        'meta_description' => 'Custom meta description',
        'content' => 'Page content',
    ]);

    expect($page->getMetaDescription())->toBe('Custom meta description');

    $pageWithoutMeta = Page::factory()->create([
        'excerpt' => 'Page excerpt',
        'meta_description' => null,
        'content' => 'Page content',
    ]);

    expect($pageWithoutMeta->getMetaDescription())->toBe('Page excerpt');
});

test('page generates correct URL', function () {
    $page = Page::factory()->create(['slug' => 'test-page']);

    expect($page->getUrl())->toBe(route('pages.show', 'test-page'));
});

test('scheduled page is not published yet', function () {
    $page = Page::factory()->scheduled()->create();

    expect($page->isPublished())->toBeFalse();
});
