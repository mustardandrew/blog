<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

test('it displays category page with posts', function () {
    $category = Category::factory()->create(['name' => 'Technology']);
    $user = User::factory()->create(['name' => 'John Doe']);
    $posts = Post::factory()
        ->published()
        ->for($user)
        ->count(3)
        ->create();

    $category->posts()->attach($posts);

    $response = $this->get(route('categories.show', $category));

    $response->assertSuccessful()
        ->assertSee('Technology')
        ->assertSee('3 posts in this category')
        ->assertSee($posts->first()->title);
});

test('it displays tag page with posts', function () {
    $tag = Tag::factory()->create(['name' => 'PHP']);
    $user = User::factory()->create(['name' => 'Jane Smith']);
    $posts = Post::factory()
        ->published()
        ->for($user)
        ->count(2)
        ->create();

    $tag->posts()->attach($posts);

    $response = $this->get(route('tags.show', $tag));

    $response->assertSuccessful()
        ->assertSee('# PHP')
        ->assertSee('2 posts tagged with this')
        ->assertSee($posts->first()->title);
});

test('it shows breadcrumbs on category and tag pages', function () {
    $category = Category::factory()->create(['name' => 'Tech']);
    $tag = Tag::factory()->create(['name' => 'Laravel']);

    $this->get(route('categories.show', $category))
        ->assertSuccessful()
        ->assertSee('Home')
        ->assertSee('Blog')
        ->assertSee('Tech');

    $this->get(route('tags.show', $tag))
        ->assertSuccessful()
        ->assertSee('Home')
        ->assertSee('Blog')
        ->assertSee('Laravel');
});

test('it handles empty categories and tags', function () {
    $category = Category::factory()->create(['name' => 'Empty Category']);
    $tag = Tag::factory()->create(['name' => 'Empty Tag']);

    $this->get(route('categories.show', $category))
        ->assertSuccessful()
        ->assertSee('Empty Category')
        ->assertSee('No posts found in this category.');

    $this->get(route('tags.show', $tag))
        ->assertSuccessful()
        ->assertSee('# Empty Tag')
        ->assertSee('No posts found with this tag.');
});
