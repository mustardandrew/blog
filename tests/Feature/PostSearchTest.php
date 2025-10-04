<?php

declare(strict_types=1);

use App\Models\{User, Post, Category};

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('posts index displays search results when search parameter is provided', function () {
    $matchingPost = Post::factory()->published()->create([
        'title' => 'Laravel Framework Guide',
        'user_id' => $this->user->id,
    ]);
    
    $nonMatchingPost = Post::factory()->published()->create([
        'title' => 'Vue.js Tutorial',
        'user_id' => $this->user->id,
    ]);

    $response = $this->get(route('posts.index', ['search' => 'Laravel']));

    $response->assertStatus(200)
        ->assertSee($matchingPost->title)
        ->assertDontSee($nonMatchingPost->title);
});

test('posts index searches in title, excerpt and content', function () {
    // Create posts with search terms in different fields
    $titleMatch = Post::factory()->published()->create([
        'title' => 'PHP Development Guide',
        'excerpt' => 'This is about something else',
        'content' => 'This talks about other technologies',
        'user_id' => $this->user->id,
    ]);
    
    $excerptMatch = Post::factory()->published()->create([
        'title' => 'Framework Comparison',
        'excerpt' => 'Laravel framework basics explained',
        'content' => 'Different programming concepts',
        'user_id' => $this->user->id,
    ]);
    
    $contentMatch = Post::factory()->published()->create([
        'title' => 'Frontend Technologies',
        'excerpt' => 'About frontend development',
        'content' => 'This content discusses Vue.js development in detail',
        'user_id' => $this->user->id,
    ]);

    // Search for PHP (in title)
    $response = $this->get(route('posts.index', ['search' => 'PHP']));
    $response->assertSee($titleMatch->title)
        ->assertDontSee($excerptMatch->title)
        ->assertDontSee($contentMatch->title);

    // Search for Laravel (in excerpt)
    $response = $this->get(route('posts.index', ['search' => 'Laravel']));
    $response->assertSee($excerptMatch->title)
        ->assertDontSee($titleMatch->title)
        ->assertDontSee($contentMatch->title);

    // Search for Vue.js (in content)
    $response = $this->get(route('posts.index', ['search' => 'Vue.js']));
    $response->assertSee($contentMatch->title)
        ->assertDontSee($titleMatch->title)
        ->assertDontSee($excerptMatch->title);
});

test('posts index shows all posts when no search parameter provided', function () {
    $post1 = Post::factory()->published()->create([
        'title' => 'First Post',
        'user_id' => $this->user->id,
    ]);
    
    $post2 = Post::factory()->published()->create([
        'title' => 'Second Post',
        'user_id' => $this->user->id,
    ]);

    $response = $this->get(route('posts.index'));

    $response->assertStatus(200)
        ->assertSee($post1->title)
        ->assertSee($post2->title);
});

test('search only returns published posts', function () {
    $publishedPost = Post::factory()->published()->create([
        'title' => 'Published Laravel Post',
        'user_id' => $this->user->id,
    ]);
    
    $draftPost = Post::factory()->draft()->create([
        'title' => 'Draft Laravel Post',
        'user_id' => $this->user->id,
    ]);

    $response = $this->get(route('posts.index', ['search' => 'Laravel']));

    $response->assertStatus(200)
        ->assertSee($publishedPost->title)
        ->assertDontSee($draftPost->title);
});

test('empty search returns all published posts', function () {
    $post = Post::factory()->published()->create([
        'title' => 'Test Post',
        'user_id' => $this->user->id,
    ]);

    $response = $this->get(route('posts.index', ['search' => '']));

    $response->assertStatus(200)
        ->assertSee($post->title);
});
