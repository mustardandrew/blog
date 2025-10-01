<?php

use App\Models\Post;
use App\Models\User;

test('post card displays read more link for posts with excerpt', function () {
    $user = User::factory()->create();
    $post = Post::factory()
        ->published()
        ->for($user)
        ->create([
            'title' => 'Test Post with Excerpt',
            'excerpt' => 'This is a test excerpt for the post.',
        ]);

    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertSee('Test Post with Excerpt')
        ->assertSee('This is a test excerpt')
        ->assertSee('Read more →');
});

test('post card displays read more link for posts without excerpt', function () {
    $user = User::factory()->create();
    $post = Post::factory()
        ->published()
        ->for($user)
        ->create([
            'title' => 'Test Post without Excerpt',
            'excerpt' => null,
        ]);

    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertSee('Test Post without Excerpt')
        ->assertSee('Read more →');
});

test('post card layout is consistent across different pages', function () {
    $user = User::factory()->create();
    $category = \App\Models\Category::factory()->create(['name' => 'Test Category']);
    $tag = \App\Models\Tag::factory()->create(['name' => 'Test Tag']);

    $post = Post::factory()
        ->published()
        ->for($user)
        ->create(['title' => 'Consistent Layout Test']);

    $post->categories()->attach($category);
    $post->tags()->attach($tag);

    // Test home page
    $this->get('/')
        ->assertSuccessful()
        ->assertSee('Consistent Layout Test')
        ->assertSee('Read more →');

    // Test blog index page
    $this->get('/posts')
        ->assertSuccessful()
        ->assertSee('Consistent Layout Test')
        ->assertSee('Read more →');

    // Test category page
    $this->get('/categories/'.$category->slug)
        ->assertSuccessful()
        ->assertSee('Consistent Layout Test')
        ->assertSee('Read more →');

    // Test tag page
    $this->get('/tags/'.$tag->slug)
        ->assertSuccessful()
        ->assertSee('Consistent Layout Test')
        ->assertSee('Read more →');
});
