<?php

declare(strict_types=1);

use App\Models\PageSeo;
use Database\Seeders\PageSeoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('page seo seeder creates all expected records', function () {
    // Запускаємо сідер
    $this->seed(PageSeoSeeder::class);

    // Перевіряємо, що всі основні записи створені
    $expectedKeys = ['home', 'blog', 'contact', 'about', 'terms', 'privacy'];

    foreach ($expectedKeys as $key) {
        expect(PageSeo::where('key', $key)->exists())->toBeTrue("Record with key '{$key}' should exist");
    }

    expect(PageSeo::count())->toBe(6);
});

test('home page seo has correct data', function () {
    $this->seed(PageSeoSeeder::class);

    $homeSeo = PageSeo::getByKey('home');

    expect($homeSeo)->not->toBeNull();
    expect($homeSeo->key)->toBe('home');
    expect($homeSeo->title)->toContain('LitBlog');
    expect($homeSeo->meta_description)->toContain('захоплюючі рецензії');
    expect($homeSeo->keywords)->toContain('література');
    expect($homeSeo->noindex)->toBeFalse();
    expect($homeSeo->nofollow)->toBeFalse();
    expect($homeSeo->additional_meta)->toHaveKey('og:type');
    expect($homeSeo->additional_meta['og:type'])->toBe('website');
});

test('blog page seo has correct data', function () {
    $this->seed(PageSeoSeeder::class);

    $blogSeo = PageSeo::getByKey('blog');

    expect($blogSeo)->not->toBeNull();
    expect($blogSeo->title)->toContain('Блог');
    expect($blogSeo->meta_description)->toContain('рецензії');
    expect($blogSeo->keywords)->toContain('рецензії книг');
    expect($blogSeo->noindex)->toBeFalse();
});

test('contact page seo has correct data', function () {
    $this->seed(PageSeoSeeder::class);

    $contactSeo = PageSeo::getByKey('contact');

    expect($contactSeo)->not->toBeNull();
    expect($contactSeo->title)->toContain('Контакти');
    expect($contactSeo->meta_description)->toContain('Зв\'яжіться з командою');
    expect($contactSeo->noindex)->toBeFalse();
});

test('terms and privacy pages are marked as noindex', function () {
    $this->seed(PageSeoSeeder::class);

    $termsSeo = PageSeo::getByKey('terms');
    $privacySeo = PageSeo::getByKey('privacy');

    expect($termsSeo->noindex)->toBeTrue();
    expect($termsSeo->nofollow)->toBeTrue();
    expect($privacySeo->noindex)->toBeTrue();
    expect($privacySeo->nofollow)->toBeTrue();
});

test('seeder can be run multiple times without duplicates', function () {
    // Запускаємо сідер двічі
    $this->seed(PageSeoSeeder::class);
    $this->seed(PageSeoSeeder::class);

    // Повинно залишитися тільки 6 записів (без дублікатів)
    expect(PageSeo::count())->toBe(6);

    // Перевіряємо, що дані оновилися
    $homeSeo = PageSeo::getByKey('home');
    expect($homeSeo->title)->toContain('LitBlog');
});

test('meta descriptions are within seo limits', function () {
    $this->seed(PageSeoSeeder::class);

    $seoRecords = PageSeo::all();

    foreach ($seoRecords as $seo) {
        if ($seo->meta_description) {
            expect(mb_strlen($seo->meta_description))
                ->toBeLessThanOrEqual(160, "Meta description for '{$seo->key}' should be 160 chars or less");
        }
    }
});

test('all indexed pages have meta descriptions', function () {
    $this->seed(PageSeoSeeder::class);

    $indexedPages = PageSeo::where('noindex', false)->get();

    foreach ($indexedPages as $seo) {
        expect($seo->meta_description)
            ->not->toBeNull("Indexed page '{$seo->key}' should have meta description")
            ->not->toBeEmpty("Meta description for '{$seo->key}' should not be empty");
    }
});
