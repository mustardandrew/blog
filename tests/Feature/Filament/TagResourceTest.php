<?php

declare(strict_types=1);

use App\Filament\Resources\Tags\Pages\CreateTag;
use App\Filament\Resources\Tags\Pages\EditTag;
use App\Filament\Resources\Tags\Pages\ListTags;
use App\Models\Tag;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $this->actingAs(User::factory()->admin()->create());
    Filament::setCurrentPanel('app');
});

test('can list tags', function () {
    $tags = Tag::factory()->count(5)->create();

    Livewire::test(ListTags::class)
        ->assertCanSeeTableRecords($tags);
});

test('can create tag', function () {
    Livewire::test(CreateTag::class)
        ->fillForm([
            'name' => 'Laravel',
            'slug' => 'laravel',
            'color' => '#ff0000',
            'is_featured' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Tag::class, [
        'name' => 'Laravel',
        'slug' => 'laravel',
        'color' => '#ff0000',
        'is_featured' => true,
    ]);
});

test('can validate tag creation', function () {
    Livewire::test(CreateTag::class)
        ->fillForm([
            'name' => '',
            'slug' => '',
        ])
        ->call('create')
        ->assertHasFormErrors(['name' => 'required', 'slug' => 'required']);
});

test('slug must be unique on creation', function () {
    Tag::factory()->create(['slug' => 'existing-tag']);

    Livewire::test(CreateTag::class)
        ->fillForm([
            'name' => 'New Tag',
            'slug' => 'existing-tag',
            'color' => '#ff0000',
        ])
        ->call('create')
        ->assertHasFormErrors(['slug' => 'unique']);
});

test('can edit tag', function () {
    $tag = Tag::factory()->create([
        'name' => 'Original Name',
        'is_featured' => false,
    ]);

    Livewire::test(EditTag::class, [
        'record' => $tag->getRouteKey(),
    ])
        ->fillForm([
            'name' => 'Updated Name',
            'is_featured' => true,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($tag->refresh())
        ->name->toBe('Updated Name')
        ->is_featured->toBeTrue();
});

test('can search tags by name', function () {
    $laravel = Tag::factory()->create(['name' => 'Laravel Framework']);
    $vue = Tag::factory()->create(['name' => 'Vue.js']);
    Tag::factory()->create(['name' => 'React']);

    Livewire::test(ListTags::class)
        ->searchTable('Laravel')
        ->assertCanSeeTableRecords([$laravel])
        ->assertCanNotSeeTableRecords([$vue]);
});

test('can search tags by slug', function () {
    $laravel = Tag::factory()->create(['slug' => 'laravel-framework']);
    $vue = Tag::factory()->create(['slug' => 'vue-js']);
    Tag::factory()->create(['slug' => 'react']);

    Livewire::test(ListTags::class)
        ->searchTable('laravel')
        ->assertCanSeeTableRecords([$laravel])
        ->assertCanNotSeeTableRecords([$vue]);
});

test('can filter featured tags', function () {
    $featured = Tag::factory()->featured()->create();
    $regular = Tag::factory()->create(['is_featured' => false]);

    Livewire::test(ListTags::class)
        ->filterTable('is_featured', true)
        ->assertCanSeeTableRecords([$featured])
        ->assertCanNotSeeTableRecords([$regular]);
});

test('can sort tags by usage count', function () {
    $highUsage = Tag::factory()->create(['usage_count' => 100]);
    $lowUsage = Tag::factory()->create(['usage_count' => 5]);

    Livewire::test(ListTags::class)
        ->sortTable('usage_count', 'desc')
        ->assertCanSeeTableRecords([$highUsage, $lowUsage], inOrder: true);
});

test('automatically generates slug from name when creating', function () {
    Livewire::test(CreateTag::class)
        ->fillForm([
            'name' => 'Vue.js Framework',
            'color' => '#4fc08d',
        ])
        ->call('create');

    assertDatabaseHas(Tag::class, [
        'name' => 'Vue.js Framework',
        'slug' => 'vuejs-framework', // Laravel's Str::slug() removes dots
    ]);
});

test('can delete tag', function () {
    $tag = Tag::factory()->create();

    Livewire::test(EditTag::class, [
        'record' => $tag->getRouteKey(),
    ])
        ->callAction('delete');

    assertDatabaseMissing(Tag::class, [
        'id' => $tag->id,
    ]);
});
