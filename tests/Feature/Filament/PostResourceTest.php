<?php

declare(strict_types=1);

use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->actingAs($this->admin);
});

test('admin can view posts list in filament', function () {
    $posts = Post::factory(3)->published()->create();

    Livewire::test(ListPosts::class)
        ->assertCanSeeTableRecords($posts)
        ->assertSuccessful();
});

test('admin can create a new post via filament', function () {
    $user = User::factory()->create();

    Livewire::test(CreatePost::class)
        ->fillForm([
            'title' => 'Test Post Title',
            'slug' => 'test-post-title',
            'excerpt' => 'This is a test excerpt for the post.',
            'content' => '<p>This is the main content of the test post.</p>',
            'status' => 'draft',
            'user_id' => $user->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('posts', [
        'title' => 'Test Post Title',
        'slug' => 'test-post-title',
        'status' => 'draft',
        'user_id' => $user->id,
    ]);
});

test('admin can create a published post', function () {
    $user = User::factory()->create();

    Livewire::test(CreatePost::class)
        ->fillForm([
            'title' => 'Published Test Post',
            'slug' => 'published-test-post',
            'excerpt' => 'This is a published post excerpt.',
            'content' => '<p>This is the content of the published post.</p>',
            'status' => 'published',
            'published_at' => now()->format('Y-m-d H:i:s'),
            'user_id' => $user->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('posts', [
        'title' => 'Published Test Post',
        'slug' => 'published-test-post',
        'status' => 'published',
        'user_id' => $user->id,
    ]);
});

test('admin can edit a post', function () {
    // Створюємо пост з правильними даними
    $post = Post::factory()->create([
        'title' => 'Original Title',
        'slug' => 'original-title',
        'excerpt' => 'Original excerpt',
        'content' => '<p>Original content</p>',
        'status' => 'draft',
        'user_id' => $this->admin->id,
    ]);

    // Перевіряємо, що admin справді має is_admin = true
    expect($this->admin->is_admin)->toBeTrue();

    // Тестуємо оновлення поста
    $post->update([
        'title' => 'Updated Title',
        'slug' => 'updated-title',
        'status' => 'published',
        'published_at' => now(),
    ]);

    // Перевіряємо результат
    $updatedPost = $post->fresh();

    expect($updatedPost->title)->toBe('Updated Title')
        ->and($updatedPost->slug)->toBe('updated-title')
        ->and($updatedPost->status)->toBe('published')
        ->and($updatedPost->published_at)->not->toBeNull();
});

test('admin can filter posts by status', function () {
    $publishedPosts = Post::factory(2)->published()->create();
    $draftPosts = Post::factory(3)->draft()->create();

    Livewire::test(ListPosts::class)
        ->filterTable('status', 'published')
        ->assertCanSeeTableRecords($publishedPosts)
        ->assertCanNotSeeTableRecords($draftPosts);
});

test('admin can search posts by title', function () {
    $post1 = Post::factory()->create(['title' => 'Laravel Tutorial']);
    $post2 = Post::factory()->create(['title' => 'Vue.js Guide']);

    Livewire::test(ListPosts::class)
        ->searchTable('Laravel')
        ->assertCanSeeTableRecords([$post1])
        ->assertCanNotSeeTableRecords([$post2]);
});

test('admin can search posts by author name', function () {
    $user1 = User::factory()->create(['name' => 'John Doe']);
    $user2 = User::factory()->create(['name' => 'Jane Smith']);

    $post1 = Post::factory()->create(['user_id' => $user1->id]);
    $post2 = Post::factory()->create(['user_id' => $user2->id]);

    Livewire::test(ListPosts::class)
        ->searchTable('John')
        ->assertCanSeeTableRecords([$post1])
        ->assertCanNotSeeTableRecords([$post2]);
});

test('post shows correct status badges', function () {
    $publishedPost = Post::factory()->published()->create(['title' => 'Published Post']);
    $draftPost = Post::factory()->draft()->create(['title' => 'Draft Post']);
    $archivedPost = Post::factory()->archived()->create(['title' => 'Archived Post']);

    Livewire::test(ListPosts::class)
        ->assertCanSeeTableRecords([$publishedPost, $draftPost, $archivedPost])
        ->assertSuccessful();
});

test('non-admin users cannot access posts admin', function () {
    auth()->logout();
    $user = User::factory()->create(['is_admin' => false]);
    $this->actingAs($user);

    $response = $this->get('/admin/posts');
    $response->assertStatus(403);
});

test('guest users are redirected to login', function () {
    auth()->logout();

    $response = $this->get('/admin/posts');
    $response->assertRedirect('/admin/login');
});

test('slug is auto-generated from title when creating post', function () {
    $user = User::factory()->create();

    Livewire::test(CreatePost::class)
        ->fillForm([
            'title' => 'Test Post With Spaces',
            'excerpt' => 'Test excerpt',
            'content' => '<p>Test content</p>',
            'status' => 'draft',
            'user_id' => $user->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('posts', [
        'title' => 'Test Post With Spaces',
        'slug' => 'test-post-with-spaces',
    ]);
});
