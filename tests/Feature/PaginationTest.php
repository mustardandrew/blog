<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('pagination displays custom blog template', function () {
    $user = User::factory()->create();
    
    // Create enough posts to trigger pagination (more than 12)
    Post::factory(15)->published()->create(['user_id' => $user->id]);
    
    $response = $this->get(route('posts.index'));
    
    $response->assertOk();
    
    // Check that our custom pagination template is used
    $response->assertSee('Showing');
    $response->assertSee('posts'); // Instead of 'results'
    $response->assertSee('Page'); // For mobile view
    
    // Check for navigation arrows
    $response->assertSee('svg'); // Navigation arrows should be present
});

test('pagination shows correct post counts', function () {
    $user = User::factory()->create();
    
    // Create exactly 25 published posts
    Post::factory(25)->published()->create(['user_id' => $user->id]);
    
    // First page
    $response = $this->get(route('posts.index'));
    $response->assertSee('Showing');
    $response->assertSee('posts');
    
    // Second page  
    $response = $this->get(route('posts.index', ['page' => 2]));
    $response->assertSee('Showing');
    $response->assertSee('posts');
});

test('pagination navigation works correctly', function () {
    $user = User::factory()->create();
    
    // Create enough posts for multiple pages
    Post::factory(30)->published()->create(['user_id' => $user->id]);
    
    // Test first page
    $response = $this->get(route('posts.index'));
    $response->assertOk();
    
    // Test middle page
    $response = $this->get(route('posts.index', ['page' => 2]));
    $response->assertOk();
    
    // Check navigation exists
    $this->assertStringContainsString('navigation', $response->getContent());
});

test('mobile pagination shows simplified view', function () {
    $user = User::factory()->create();
    
    // Create enough posts to trigger pagination
    Post::factory(15)->published()->create(['user_id' => $user->id]);
    
    $response = $this->get(route('posts.index'));
    
    // Mobile pagination should show page count
    $response->assertSee('Page 1 of 2');
    $response->assertSee('Previous');
    $response->assertSee('Next');
});