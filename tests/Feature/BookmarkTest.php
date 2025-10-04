<?php

declare(strict_types=1);

use App\Models\{Bookmark, Post, User};
use Livewire\Livewire;
use Livewire\Volt\Volt;

test('user can bookmark a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->published()->create();

    $this->actingAs($user);

    expect(Bookmark::where('user_id', $user->id)->where('post_id', $post->id)->exists())->toBeFalse();

    Livewire::test('bookmark-button', ['post' => $post])
        ->call('toggle')
        ->assertDispatched('bookmark-toggled');

    expect(Bookmark::where('user_id', $user->id)->where('post_id', $post->id)->exists())->toBeTrue();
});

test('user can unbookmark a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->published()->create();

    $this->actingAs($user);

    // Create bookmark first
    Bookmark::create(['user_id' => $user->id, 'post_id' => $post->id]);

    expect(Bookmark::where('user_id', $user->id)->where('post_id', $post->id)->exists())->toBeTrue();

    Livewire::test('bookmark-button', ['post' => $post])
        ->call('toggle')
        ->assertDispatched('bookmark-toggled');

    expect(Bookmark::where('user_id', $user->id)->where('post_id', $post->id)->exists())->toBeFalse();
});

test('guest user is redirected to login when trying to bookmark', function () {
    $post = Post::factory()->published()->create();

    Livewire::test('bookmark-button', ['post' => $post])
        ->call('toggle')
        ->assertRedirect(route('login'));
});

test('bookmark button shows correct state', function () {
    $user = User::factory()->create();
    $post = Post::factory()->published()->create();

    $this->actingAs($user);

    // Initially not bookmarked
    Livewire::test('bookmark-button', ['post' => $post])
        ->assertSet('isBookmarked', false);

    // Create bookmark
    Bookmark::create(['user_id' => $user->id, 'post_id' => $post->id]);

    // Should show as bookmarked
    Livewire::test('bookmark-button', ['post' => $post])
        ->assertSet('isBookmarked', true);
});

test('user bookmark relationships work correctly', function () {
    $user = User::factory()->create();
    $posts = Post::factory()->published()->count(3)->create();

    $this->actingAs($user);

    // Bookmark first two posts
    Bookmark::create(['user_id' => $user->id, 'post_id' => $posts[0]->id]);
    Bookmark::create(['user_id' => $user->id, 'post_id' => $posts[1]->id]);

    $user->refresh();

    expect($user->bookmarkedPosts()->count())->toBe(2);
    expect($user->hasBookmarked($posts[0]))->toBeTrue();
    expect($user->hasBookmarked($posts[1]))->toBeTrue();
    expect($user->hasBookmarked($posts[2]))->toBeFalse();
});

test('post bookmark relationships work correctly', function () {
    $users = User::factory()->count(3)->create();
    $post = Post::factory()->published()->create();

    // Two users bookmark the post
    Bookmark::create(['user_id' => $users[0]->id, 'post_id' => $post->id]);
    Bookmark::create(['user_id' => $users[1]->id, 'post_id' => $post->id]);

    $post->refresh();

    expect($post->bookmarksCount())->toBe(2);
    expect($post->isBookmarkedBy($users[0]))->toBeTrue();
    expect($post->isBookmarkedBy($users[1]))->toBeTrue();
    expect($post->isBookmarkedBy($users[2]))->toBeFalse();
});

test('bookmark toggle method works correctly', function () {
    $user = User::factory()->create();
    $post = Post::factory()->published()->create();

    // First toggle - should create bookmark
    $result = Bookmark::toggle($user->id, $post->id);
    expect($result['bookmarked'])->toBeTrue();
    expect($result['message'])->toBe('Додано до закладок');

    // Second toggle - should remove bookmark
    $result = Bookmark::toggle($user->id, $post->id);
    expect($result['bookmarked'])->toBeFalse();
    expect($result['message'])->toBe('Закладку видалено');
});

test('bookmark is deleted when user is deleted', function () {
    $user = User::factory()->create();
    $post = Post::factory()->published()->create();

    Bookmark::create(['user_id' => $user->id, 'post_id' => $post->id]);

    expect(Bookmark::count())->toBe(1);

    $user->delete();

    expect(Bookmark::count())->toBe(0);
});

test('bookmark is deleted when post is deleted', function () {
    $user = User::factory()->create();
    $post = Post::factory()->published()->create();

    Bookmark::create(['user_id' => $user->id, 'post_id' => $post->id]);

    expect(Bookmark::count())->toBe(1);

    $post->delete();

    expect(Bookmark::count())->toBe(0);
});

test('dashboard bookmarks page loads correctly', function () {
    $user = User::factory()->create();
    $posts = Post::factory()->published()->count(5)->create();

    $this->actingAs($user);

    // Bookmark some posts
    Bookmark::create(['user_id' => $user->id, 'post_id' => $posts[0]->id]);
    Bookmark::create(['user_id' => $user->id, 'post_id' => $posts[1]->id]);

    Volt::test('dashboard.bookmarks')
        ->assertSee($posts[0]->title)
        ->assertSee($posts[1]->title)
        ->assertDontSee($posts[2]->title);
});

test('dashboard bookmarks search works', function () {
    $user = User::factory()->create();
    $post1 = Post::factory()->published()->create(['title' => 'Laravel Development']);
    $post2 = Post::factory()->published()->create(['title' => 'Vue.js Framework']);

    $this->actingAs($user);

    // Bookmark both posts
    Bookmark::create(['user_id' => $user->id, 'post_id' => $post1->id]);
    Bookmark::create(['user_id' => $user->id, 'post_id' => $post2->id]);

    Volt::test('dashboard.bookmarks')
        ->set('search', 'Laravel')
        ->assertSee('Laravel Development')
        ->assertDontSee('Vue.js Framework');
});

test('dashboard bookmarks sorting works', function () {
    $user = User::factory()->create();
    $post1 = Post::factory()->published()->create(['title' => 'A First Post']);
    $post2 = Post::factory()->published()->create(['title' => 'Z Last Post']);

    $this->actingAs($user);

    // Bookmark posts (with delay to ensure different created_at times)
    Bookmark::create(['user_id' => $user->id, 'post_id' => $post1->id]);
    sleep(1);
    Bookmark::create(['user_id' => $user->id, 'post_id' => $post2->id]);

    // Test title sorting
    $component = Volt::test('dashboard.bookmarks')
        ->call('sortBy', 'title')
        ->assertSet('sortBy', 'title')
        ->assertSet('sortDirection', 'asc');

    // Test direction toggle
    $component->call('sortBy', 'title')
        ->assertSet('sortDirection', 'desc');
});

test('removing bookmark from dashboard works', function () {
    $user = User::factory()->create();
    $post = Post::factory()->published()->create();

    $this->actingAs($user);

    Bookmark::create(['user_id' => $user->id, 'post_id' => $post->id]);

    expect(Bookmark::count())->toBe(1);

    Volt::test('dashboard.bookmarks')
        ->call('removeBookmark', $post->id);

    expect(Bookmark::count())->toBe(0);
});

test('bookmark component appears on post detail page for authenticated users', function () {
    $user = User::factory()->create();
    $post = Post::factory()->published()->create();

    $response = $this->actingAs($user)->get(route('posts.show', $post));

    $response->assertStatus(200)
        ->assertSeeLivewire('bookmark-button');
});

test('bookmark component does not appear on post detail page for guests', function () {
    $post = Post::factory()->published()->create();

    $response = $this->get(route('posts.show', $post));

    $response->assertStatus(200)
        ->assertDontSeeLivewire('bookmark-button');
});

test('bookmark component appears on post cards for authenticated users', function () {
    $user = User::factory()->create();
    Post::factory()->published()->count(3)->create();

    $response = $this->actingAs($user)->get(route('posts.index'));

    $response->assertStatus(200)
        ->assertSeeLivewire('bookmark-button');
});

test('dashboard bookmarks link appears in sidebar for authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertStatus(200)
        ->assertSee(route('dashboard.bookmarks'));
});

test('dashboard bookmarks page requires authentication', function () {
    $response = $this->get(route('dashboard.bookmarks'));

    $response->assertRedirect(route('login'));
});

test('unique constraint prevents duplicate bookmarks', function () {
    $user = User::factory()->create();
    $post = Post::factory()->published()->create();

    // Create first bookmark
    Bookmark::create(['user_id' => $user->id, 'post_id' => $post->id]);

    // Try to create duplicate bookmark
    expect(function () use ($user, $post) {
        Bookmark::create(['user_id' => $user->id, 'post_id' => $post->id]);
    })->toThrow(\Illuminate\Database\QueryException::class);
});

test('bookmark button size variants work correctly', function () {
    $user = User::factory()->create();
    $post = Post::factory()->published()->create();

    $this->actingAs($user);

    // Test small size (no text)
    Livewire::test('bookmark-button', ['post' => $post, 'size' => 'sm'])
        ->assertSet('size', 'sm')
        ->assertSee('w-4 h-4');

    // Test extra small size (no text)
    Livewire::test('bookmark-button', ['post' => $post, 'size' => 'xs'])
        ->assertSet('size', 'xs')
        ->assertSee('w-3 h-3');
});

test('dashboard bookmarks displays stats correctly', function () {
    $user = User::factory()->create();
    $posts = Post::factory()->published()->count(3)->create();

    $this->actingAs($user);

    // Create bookmarks
    foreach ($posts as $post) {
        Bookmark::create(['user_id' => $user->id, 'post_id' => $post->id]);
    }

    $component = Livewire::test(\App\Livewire\Dashboard\Bookmarks::class);
    
    // Just test that stats are returned and are numeric
    $stats = $component->get('stats');
    
    expect($stats)->toBeArray()
        ->and($stats)->toHaveKeys(['total', 'recent', 'categories'])
        ->and($stats['total'])->toBeInt()
        ->and($stats['recent'])->toBeInt()
        ->and($stats['categories'])->toBeInt()
        ->and($stats['total'])->toBeGreaterThanOrEqual(3);
});
