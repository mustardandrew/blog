<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

test('post page shows correct category links', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create(['name' => 'Technology']);
    $post = Post::factory()
        ->published()
        ->for($user)
        ->create(['title' => 'Test Post']);

    $post->categories()->attach($category);

    $response = $this->get(route('posts.show', $post));

    $response->assertSuccessful()
        ->assertSee($category->name)
        ->assertSee(route('categories.show', $category));
});

test('post page shows correct tag links', function () {
    $user = User::factory()->create();
    $tag = Tag::factory()->create(['name' => 'Laravel']);
    $post = Post::factory()
        ->published()
        ->for($user)
        ->create(['title' => 'Test Post']);

    $post->tags()->attach($tag);

    $response = $this->get(route('posts.show', $post));

    $response->assertSuccessful()
        ->assertSee($tag->name)
        ->assertSee(route('tags.show', $tag));
});

test('category and tag links navigate to correct pages', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create(['name' => 'Tech']);
    $tag = Tag::factory()->create(['name' => 'PHP']);
    $post = Post::factory()
        ->published()
        ->for($user)
        ->create();

    $post->categories()->attach($category);
    $post->tags()->attach($tag);

    // Test category link
    $this->get(route('categories.show', $category))
        ->assertSuccessful()
        ->assertSee($category->name);

    // Test tag link
    $this->get(route('tags.show', $tag))
        ->assertSuccessful()
        ->assertSee("# {$tag->name}");
});
