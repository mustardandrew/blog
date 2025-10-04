<?php

declare(strict_types=1);

use App\Models\PageSeo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('home page displays seo meta tags when seo data exists', function () {
    PageSeo::create([
        'key' => 'home',
        'title' => 'Test Home Title',
        'meta_description' => 'Test home description',
        'keywords' => 'home, test, keywords',
        'noindex' => false,
        'nofollow' => false,
        'additional_meta' => [
            'og:type' => 'website',
            'og:image' => '/test-image.jpg',
        ],
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('<title>Test Home Title</title>', false);
    $response->assertSee('<meta name="description" content="Test home description">', false);
    $response->assertSee('<meta name="keywords" content="home, test, keywords">', false);
    $response->assertSee('<meta name="robots" content="index, follow">', false);
    $response->assertSee('<meta property="og:type" content="website">', false);
    $response->assertSee('<meta property="og:image" content="/test-image.jpg">', false);
});

test('blog page displays seo meta tags when seo data exists', function () {
    PageSeo::create([
        'key' => 'blog',
        'title' => 'Test Blog Title',
        'meta_description' => 'Test blog description',
        'keywords' => 'blog, articles, posts',
    ]);

    $response = $this->get('/posts');

    $response->assertStatus(200);
    $response->assertSee('<title>Test Blog Title</title>', false);
    $response->assertSee('<meta name="description" content="Test blog description">', false);
    $response->assertSee('<meta name="keywords" content="blog, articles, posts">', false);
});

test('contact page displays seo meta tags when seo data exists', function () {
    PageSeo::create([
        'key' => 'contact',
        'title' => 'Test Contact Title',
        'meta_description' => 'Test contact description',
    ]);

    $response = $this->get('/contact');

    $response->assertStatus(200);
    $response->assertSee('<title>Test Contact Title</title>', false);
    $response->assertSee('<meta name="description" content="Test contact description">', false);
});

test('pages display fallback titles when seo data does not exist', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    // Should display app name as fallback
    $response->assertSee('<title>'.config('app.name').'</title>', false);
});

test('robots meta displays noindex nofollow when set', function () {
    PageSeo::create([
        'key' => 'home',
        'title' => 'Test Title',
        'noindex' => true,
        'nofollow' => true,
    ]);

    $response = $this->get('/');

    $response->assertSee('<meta name="robots" content="noindex, nofollow">', false);
});

test('seo helpers work correctly', function () {
    PageSeo::create([
        'key' => 'test',
        'title' => 'Test Page Title',
        'meta_description' => 'Test description',
        'keywords' => 'test, keywords',
    ]);

    expect(page_title('test'))->toBe('Test Page Title');
    expect(page_description('test'))->toBe('Test description');
    expect(page_keywords('test'))->toBe('test, keywords');
    expect(page_robots('test'))->toBe('index, follow');

    // Test fallbacks
    expect(page_title('nonexistent', 'Fallback Title'))->toBe('Fallback Title');
    expect(page_description('nonexistent', 'Fallback Description'))->toBe('Fallback Description');
    expect(page_robots('nonexistent'))->toBe('index, follow');
});
