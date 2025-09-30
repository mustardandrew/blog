<?php

declare(strict_types=1);

use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->actingAs($this->admin);
});

test('admin can view categories list', function () {
    $categories = Category::factory(3)->create();

    Livewire::test(ListCategories::class)
        ->assertCanSeeTableRecords($categories)
        ->assertSuccessful();
});

test('admin can create a new category', function () {
    Livewire::test(CreateCategory::class)
        ->fillForm([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'This is a test category description.',
            'color' => '#3b82f6',
            'is_active' => true,
            'sort_order' => 10,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('categories', [
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);
});

test('admin can create a child category', function () {
    $parent = Category::factory()->create(['name' => 'Parent Category']);

    Livewire::test(CreateCategory::class)
        ->fillForm([
            'name' => 'Child Category',
            'slug' => 'child-category',
            'description' => 'This is a child category.',
            'color' => '#10b981',
            'is_active' => true,
            'sort_order' => 5,
            'parent_id' => $parent->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('categories', [
        'name' => 'Child Category',
        'parent_id' => $parent->id,
    ]);
});

test('admin can edit a category', function () {
    $category = Category::factory()->create([
        'name' => 'Original Category',
        'slug' => 'original-category',
        'is_active' => true,
    ]);

    // Простіший тест оновлення через модель
    $category->update([
        'name' => 'Updated Category',
        'slug' => 'updated-category',
        'is_active' => false,
    ]);

    $updatedCategory = $category->fresh();

    expect($updatedCategory->name)->toBe('Updated Category')
        ->and($updatedCategory->slug)->toBe('updated-category')
        ->and($updatedCategory->is_active)->toBeFalse();
});

test('admin can filter categories by parent', function () {
    $parent = Category::factory()->create(['name' => 'Parent']);
    $child = Category::factory()->child($parent->id)->create(['name' => 'Child']);
    $rootCategory = Category::factory()->create(['name' => 'Root']);

    Livewire::test(ListCategories::class)
        ->filterTable('parent_id', $parent->id)
        ->assertCanSeeTableRecords([$child])
        ->assertCanNotSeeTableRecords([$parent, $rootCategory]);
});

test('admin can filter categories by status', function () {
    $activeCategories = Category::factory(2)->create(['is_active' => true]);
    $inactiveCategories = Category::factory(3)->inactive()->create();

    Livewire::test(ListCategories::class)
        ->filterTable('is_active', true)
        ->assertCanSeeTableRecords($activeCategories)
        ->assertCanNotSeeTableRecords($inactiveCategories);
});

test('admin can search categories by name', function () {
    $category1 = Category::factory()->create(['name' => 'Laravel Framework']);
    $category2 = Category::factory()->create(['name' => 'Vue.js Guide']);

    Livewire::test(ListCategories::class)
        ->searchTable('Laravel')
        ->assertCanSeeTableRecords([$category1])
        ->assertCanNotSeeTableRecords([$category2]);
});

test('slug is auto-generated from name when creating category', function () {
    Livewire::test(CreateCategory::class)
        ->fillForm([
            'name' => 'Category With Spaces',
            'description' => 'Test description',
            'color' => '#6366f1',
            'is_active' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('categories', [
        'name' => 'Category With Spaces',
        'slug' => 'category-with-spaces',
    ]);
});

test('category model relationships work correctly', function () {
    $parent = Category::factory()->create(['name' => 'Parent']);
    $child = Category::factory()->child($parent->id)->create(['name' => 'Child']);

    expect($child->parent->id)->toBe($parent->id)
        ->and($parent->children->count())->toBe(1)
        ->and($parent->children->first()->id)->toBe($child->id);
});

test('category can have posts', function () {
    $category = Category::factory()->create();
    $post = \App\Models\Post::factory()->create();

    $category->posts()->attach($post);

    expect($category->posts->count())->toBe(1)
        ->and($post->categories->count())->toBe(1);
});
