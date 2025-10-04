<?php

declare(strict_types=1);

use App\Models\{User, Post, Category};
use Livewire\Livewire;
use App\Livewire\SearchPanel;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->category = Category::factory()->create();
});

test('search panel component renders successfully', function () {
    Livewire::test(SearchPanel::class)
        ->assertStatus(200)
        ->assertSet('isOpen', false)
        ->assertSet('query', '');
});

test('search panel opens when open-search event is dispatched', function () {
    Livewire::test(SearchPanel::class)
        ->dispatch('open-search')
        ->assertSet('isOpen', true);
});

test('search panel closes when close-search event is dispatched', function () {
    Livewire::test(SearchPanel::class)
        ->set('isOpen', true)
        ->dispatch('close-search')
        ->assertSet('isOpen', false)
        ->assertSet('query', '');
});

test('search returns published posts matching query', function () {
    // Create test posts
    $publishedPost = Post::factory()->published()->create([
        'title' => 'Laravel Testing Guide',
        'user_id' => $this->user->id,
    ]);
    
    $draftPost = Post::factory()->draft()->create([
        'title' => 'Laravel Draft Post',
        'user_id' => $this->user->id,
    ]);

    Livewire::test(SearchPanel::class)
        ->set('query', 'Laravel')
        ->assertCount('results', 1)
        ->assertSee($publishedPost->title)
        ->assertDontSee($draftPost->title);
});

test('search requires minimum 2 characters', function () {
    Post::factory()->published()->create([
        'title' => 'Test Post',
        'user_id' => $this->user->id,
    ]);

    Livewire::test(SearchPanel::class)
        ->set('query', 'T')
        ->assertCount('results', 0);
});

test('search looks in title, excerpt and content', function () {
    Post::factory()->published()->create([
        'title' => 'PHP Framework',
        'excerpt' => 'Laravel is a web application framework',
        'content' => 'Content about development',
        'user_id' => $this->user->id,
    ]);

    // Search in title
    Livewire::test(SearchPanel::class)
        ->set('query', 'PHP')
        ->assertCount('results', 1);

    // Search in excerpt  
    Livewire::test(SearchPanel::class)
        ->set('query', 'Laravel')
        ->assertCount('results', 1);

    // Search in content
    Livewire::test(SearchPanel::class)
        ->set('query', 'development')
        ->assertCount('results', 1);
});

test('search limits results to 8 posts', function () {
    // Create 10 posts with matching titles
    for ($i = 1; $i <= 10; $i++) {
        Post::factory()->published()->create([
            'title' => "Test Post {$i}",
            'user_id' => $this->user->id,
        ]);
    }

    Livewire::test(SearchPanel::class)
        ->set('query', 'Test')
        ->assertCount('results', 8);
});

test('search shows empty state when no results found', function () {
    Post::factory()->published()->create([
        'title' => 'Different Title',
        'user_id' => $this->user->id,
    ]);

    Livewire::test(SearchPanel::class)
        ->set('query', 'NonExistent')
        ->assertCount('results', 0)
        ->assertSee('Нічого не знайдено');
});

test('search panel displays post information correctly', function () {
    $post = Post::factory()->published()->create([
        'title' => 'Search Test Post',
        'excerpt' => 'This is a test excerpt',
        'user_id' => $this->user->id,
    ]);

    Livewire::test(SearchPanel::class)
        ->set('query', 'Search')
        ->assertSee($post->title)
        ->assertSee($post->excerpt)
        ->assertSee($this->user->name);
});
