<?php

use App\Models\Post;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can view posts list in filament', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $posts = Post::factory(3)->published()->create();

    $response = $this->actingAs($admin)->get('/admin/posts');

    $response->assertStatus(200);
    foreach ($posts as $post) {
        $response->assertSee($post->title);
    }
});

test('admin can create a new post via filament', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $response = $this->actingAs($admin)->get('/admin/posts/create');

    $response->assertStatus(200)
        ->assertSee('Title')
        ->assertSee('Slug')
        ->assertSee('Content')
        ->assertSee('Status');
});

test('post shows correct status badges', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $publishedPost = Post::factory()->published()->create(['title' => 'Published Post']);
    $draftPost = Post::factory()->draft()->create(['title' => 'Draft Post']);
    $archivedPost = Post::factory()->archived()->create(['title' => 'Archived Post']);

    $response = $this->actingAs($admin)->get('/admin/posts');

    $response->assertStatus(200)
        ->assertSee('Published Post')
        ->assertSee('Draft Post')
        ->assertSee('Archived Post');
});

test('non-admin users cannot access posts admin', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $response = $this->actingAs($user)->get('/admin/posts');

    $response->assertStatus(403);
});

test('guest users are redirected to login', function () {
    $response = $this->get('/admin/posts');

    $response->assertRedirect('/admin/login');
});
