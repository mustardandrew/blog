<?php

declare(strict_types=1);

use App\Filament\Resources\Pages\Pages\CreatePage;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Filament\Resources\Pages\Pages\ListPages;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->actingAs($this->admin);
});

test('admin can view pages list', function () {
    $pages = Page::factory(3)->create();

    Livewire::test(ListPages::class)
        ->assertCanSeeTableRecords($pages)
        ->assertSuccessful();
});

test('admin can create a new page', function () {
    Livewire::test(CreatePage::class)
        ->fillForm([
            'title' => 'Test Page',
            'slug' => 'test-page',
            'content' => 'This is test content',
            'author_id' => $this->admin->id,
            'is_published' => true,
            'published_at' => now(),
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('pages', [
        'title' => 'Test Page',
        'slug' => 'test-page',
        'content' => 'This is test content',
        'is_published' => true,
    ]);
});

test('admin can create a draft page', function () {
    Livewire::test(CreatePage::class)
        ->fillForm([
            'title' => 'Draft Page',
            'slug' => 'draft-page',
            'content' => 'This is draft content',
            'author_id' => $this->admin->id,
            'is_published' => false,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('pages', [
        'title' => 'Draft Page',
        'slug' => 'draft-page',
        'is_published' => false,
    ]);
});

test('admin can edit a page', function () {
    $page = Page::factory()->create([
        'title' => 'Original Title',
        'content' => 'Original content',
    ]);

    Livewire::test(EditPage::class, ['record' => $page->id])
        ->fillForm([
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'is_published' => true,
            'published_at' => now(),
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $page->refresh();

    expect($page->title)->toBe('Updated Title')
        ->and($page->content)->toBe('Updated content')
        ->and($page->is_published)->toBeTrue();
});

test('admin can filter pages by author', function () {
    $author1 = User::factory()->create();
    $author2 = User::factory()->create();

    $pages1 = Page::factory(2)->create(['author_id' => $author1->id]);
    $pages2 = Page::factory(3)->create(['author_id' => $author2->id]);

    Livewire::test(ListPages::class)
        ->filterTable('author', $author1->id)
        ->assertCanSeeTableRecords($pages1)
        ->assertCanNotSeeTableRecords($pages2);
});

test('admin can filter published pages', function () {
    $publishedPages = Page::factory(2)->published()->create();
    $draftPages = Page::factory(3)->draft()->create();

    Livewire::test(ListPages::class)
        ->filterTable('published')
        ->assertCanSeeTableRecords($publishedPages)
        ->assertCanNotSeeTableRecords($draftPages);
});

test('admin can filter draft pages', function () {
    $publishedPages = Page::factory(2)->published()->create();
    $draftPages = Page::factory(3)->draft()->create();

    Livewire::test(ListPages::class)
        ->filterTable('drafts')
        ->assertCanSeeTableRecords($draftPages)
        ->assertCanNotSeeTableRecords($publishedPages);
});

test('admin can search pages by title', function () {
    $page1 = Page::factory()->create(['title' => 'Laravel Tutorial']);
    $page2 = Page::factory()->create(['title' => 'Vue.js Guide']);

    Livewire::test(ListPages::class)
        ->searchTable('Laravel')
        ->assertCanSeeTableRecords([$page1])
        ->assertCanNotSeeTableRecords([$page2]);
});

test('admin can search pages by slug', function () {
    $page1 = Page::factory()->create(['slug' => 'laravel-tutorial']);
    $page2 = Page::factory()->create(['slug' => 'vuejs-guide']);

    Livewire::test(ListPages::class)
        ->searchTable('laravel-tutorial')
        ->assertCanSeeTableRecords([$page1])
        ->assertCanNotSeeTableRecords([$page2]);
});

test('slug is auto-generated when title changes', function () {
    Livewire::test(CreatePage::class)
        ->fillForm([
            'title' => 'Auto Generated Slug',
            'content' => 'Test content',
            'author_id' => $this->admin->id,
        ])
        ->assertFormSet([
            'slug' => 'auto-generated-slug',
        ]);
});
