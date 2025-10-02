<?php

declare(strict_types=1);

use App\Models\{Category, Post, User};

test('category page displays posts for specific category', function () {
    $category = Category::factory()->create(['name' => 'Technology']);
    $user = User::factory()->create();
    
    $postsInCategory = Post::factory(3)->published()->create([
        'user_id' => $user->id,
    ]);
    
    $postsNotInCategory = Post::factory(2)->published()->create([
        'user_id' => $user->id,
    ]);
    
    // Attach posts to category
    $postsInCategory->each(fn($post) => $post->categories()->attach($category));
    
    $response = $this->get(route('categories.show', $category));
    
    $response->assertSuccessful()
        ->assertSee($category->name)
        ->assertSee('Breadcrumbs')
        ->assertViewHas('posts');
    
    // Check that posts in category are shown
    $postsInCategory->each(function ($post) use ($response) {
        $response->assertSee($post->title);
    });
    
    // Check that posts not in category are not shown
    $postsNotInCategory->each(function ($post) use ($response) {
        $response->assertDontSee($post->title);
    });
});

test('tag page displays posts for specific tag', function () {
    $tag = \App\Models\Tag::factory()->create(['name' => 'Laravel']);
    $user = User::factory()->create();
    
    $postsWithTag = Post::factory(3)->published()->create([
        'user_id' => $user->id,
    ]);
    
    $postsWithoutTag = Post::factory(2)->published()->create([
        'user_id' => $user->id,
    ]);
    
    // Attach posts to tag
    $postsWithTag->each(fn($post) => $post->tags()->attach($tag));
    
    $response = $this->get(route('tags.show', $tag));
    
    $response->assertSuccessful()
        ->assertSee($tag->name)
        ->assertSee('Breadcrumbs')
        ->assertViewHas('posts');
    
    // Check that posts with tag are shown
    $postsWithTag->each(function ($post) use ($response) {
        $response->assertSee($post->title);
    });
    
    // Check that posts without tag are not shown
    $postsWithoutTag->each(function ($post) use ($response) {
        $response->assertDontSee($post->title);
    });
});

test('category page shows breadcrumbs correctly', function () {
    $category = Category::factory()->create(['name' => 'Technology']);
    
    $response = $this->get(route('categories.show', $category));
    
    $response->assertSuccessful()
        ->assertSee('Home')
        ->assertSee('Blog')
        ->assertSee($category->name);
});

test('tag page shows breadcrumbs correctly', function () {
    $tag = \App\Models\Tag::factory()->create(['name' => 'Laravel']);
    
    $response = $this->get(route('tags.show', $tag));
    
    $response->assertSuccessful()
        ->assertSee('Home')
        ->assertSee('Blog')
        ->assertSee($tag->name);
});
