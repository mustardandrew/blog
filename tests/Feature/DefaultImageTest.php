<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

test('post always returns featured image url', function () {
    $user = User::factory()->create();
    
    // Test post with featured image
    $postWithImage = Post::factory()->create([
        'user_id' => $user->id,
        'featured_image' => 'test-images/sample.jpg',
    ]);
    
    expect($postWithImage->featured_image_url)
        ->toContain('/storage/test-images/sample.jpg');
    
    // Test post without featured image
    $postWithoutImage = Post::factory()->create([
        'user_id' => $user->id,
        'featured_image' => null,
    ]);
    
    expect($postWithoutImage->featured_image_url)
        ->toContain('/storage/images/default-blog-post.svg');
});

test('default image is created by command', function () {
    // Clean up first
    Storage::disk('public')->delete('images/default-blog-post.svg');
    
    expect(Storage::disk('public')->exists('images/default-blog-post.svg'))->toBeFalse();
    
    // Run command
    $this->artisan('app:create-default-image')
        ->expectsOutput('Creating default blog post image...')
        ->expectsOutput('✓ Default SVG image created: images/default-blog-post.svg')
        ->assertExitCode(0);
    
    expect(Storage::disk('public')->exists('images/default-blog-post.svg'))->toBeTrue();
    
    // Check that it's a valid SVG
    $content = Storage::disk('public')->get('images/default-blog-post.svg');
    expect($content)
        ->toContain('<?xml version="1.0"')
        ->toContain('<svg')
        ->toContain('Blog Post');
});

test('refresh test data ensures default image exists', function () {
    // Delete default image
    Storage::disk('public')->delete('images/default-blog-post.svg');
    
    expect(Storage::disk('public')->exists('images/default-blog-post.svg'))->toBeFalse();
    
    // Run refresh command
    $this->artisan('app:refresh-test-data --skip-images')
        ->expectsOutput('🎨 Ensuring default image exists...')
        ->assertExitCode(0);
    
    expect(Storage::disk('public')->exists('images/default-blog-post.svg'))->toBeTrue();
});