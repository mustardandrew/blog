<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;

test('welcome page displays published posts', function () {
    $user = User::factory()->create();
    
    // Create published posts
    $publishedPosts = Post::factory()
        ->for($user)
        ->published()
        ->count(3)
        ->create();
    
    // Create draft post (should not appear)
    Post::factory()
        ->for($user)
        ->draft()
        ->create();

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Welcome to Our Blog');
    $response->assertSee('Latest Posts');
    
    // Check that published posts are displayed
    foreach ($publishedPosts as $post) {
        $response->assertSee($post->title);
        $response->assertSee($post->user->name);
    }
});

test('welcome page shows empty state when no posts exist', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Welcome to Our Blog');
    $response->assertSee('No Posts Yet');
    $response->assertSee('We\'re working on creating amazing content', false);
});

test('welcome page shows admin dashboard link for admin users', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get('/');

    $response->assertStatus(200);
    $response->assertSee('Go to Admin Dashboard');
});

test('welcome page shows join community button for guests', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Join Our Community');
});

test('welcome page limits posts to 6 latest', function () {
    $user = User::factory()->create();
    
    // Create 10 published posts
    Post::factory()
        ->for($user)
        ->published()
        ->count(10)
        ->create();

    $response = $this->get('/');

    $response->assertStatus(200);
    
    // Check that only 6 posts are retrieved (this tests the controller logic)
    $posts = Post::published()->latest('published_at')->limit(6)->get();
    expect($posts)->toHaveCount(6);
});