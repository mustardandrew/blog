<?php

use App\Models\Category;

test('hierarchical categories appear in main navigation dropdown', function () {
    // Створюємо головні категорії
    $parentCategory = Category::factory()->create([
        'is_active' => true,
        'name' => 'Technology',
        'sort_order' => 1,
        'parent_id' => null
    ]);

    // Створюємо дочірні категорії
    $childCategory1 = Category::factory()->create([
        'is_active' => true,
        'name' => 'Mobile Development',
        'sort_order' => 1,
        'parent_id' => $parentCategory->id
    ]);

    $childCategory2 = Category::factory()->create([
        'is_active' => true,
        'name' => 'Web Development', 
        'sort_order' => 2,
        'parent_id' => $parentCategory->id
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful();

    // Перевіряємо, що головна та дочірні категорії присутні
    $response->assertSee('Technology')
        ->assertSee('Mobile Development')
        ->assertSee('Web Development')
        ->assertSee('Categories');
});

test('only parent categories are loaded as main categories', function () {
    // Створюємо головну категорію
    $parentCategory = Category::factory()->create([
        'is_active' => true,
        'name' => 'Parent Category',
        'sort_order' => 1,
        'parent_id' => null
    ]);

    // Створюємо дочірню категорію
    $childCategory = Category::factory()->create([
        'is_active' => true,
        'name' => 'Child Category',
        'sort_order' => 1,
        'parent_id' => $parentCategory->id
    ]);

    // Створюємо ще одну головну категорію для порівняння
    $anotherParent = Category::factory()->create([
        'is_active' => true,
        'name' => 'Another Parent',
        'sort_order' => 2,
        'parent_id' => null
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful()
        ->assertSee('Parent Category')
        ->assertSee('Child Category')
        ->assertSee('Another Parent');
});

test('inactive child categories do not appear in navigation', function () {
    // Створюємо активну головну категорію
    $parentCategory = Category::factory()->create([
        'is_active' => true,
        'name' => 'Active Parent',
        'parent_id' => null
    ]);

    // Створюємо активну дочірню категорію
    $activeChild = Category::factory()->create([
        'is_active' => true,
        'name' => 'Active Child',
        'parent_id' => $parentCategory->id
    ]);

    // Створюємо неактивну дочірню категорію
    $inactiveChild = Category::factory()->create([
        'is_active' => false,
        'name' => 'Inactive Child',
        'parent_id' => $parentCategory->id
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful()
        ->assertSee('Active Parent')
        ->assertSee('Active Child')
        ->assertDontSee('Inactive Child');
});

test('child categories are ordered by sort_order within parent', function () {
    // Створюємо головну категорію
    $parentCategory = Category::factory()->create([
        'is_active' => true,
        'name' => 'Parent Category',
        'sort_order' => 1,
        'parent_id' => null
    ]);

    // Створюємо дочірні категорії з різними sort_order
    $childA = Category::factory()->create([
        'is_active' => true,
        'name' => 'Child A',
        'sort_order' => 3,
        'parent_id' => $parentCategory->id
    ]);

    $childB = Category::factory()->create([
        'is_active' => true,
        'name' => 'Child B',
        'sort_order' => 1,
        'parent_id' => $parentCategory->id
    ]);

    $childC = Category::factory()->create([
        'is_active' => true,
        'name' => 'Child C',
        'sort_order' => 2,
        'parent_id' => $parentCategory->id
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful();

    $content = $response->getContent();

    // Знаходимо позиції дочірніх категорій
    $positionB = strpos($content, 'Child B');
    $positionC = strpos($content, 'Child C');
    $positionA = strpos($content, 'Child A');

    // Перевіряємо порядок: B (1), C (2), A (3)
    expect($positionB)->toBeLessThan($positionC);
    expect($positionC)->toBeLessThan($positionA);
});
