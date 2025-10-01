<?php

declare(strict_types=1);

use App\Models\{Comment, Post, User};
use Livewire\Volt\Volt;

it('displays comments on post page', function () {
    $post = Post::factory()->published()->create();
    $comment = Comment::factory()->create([
        'post_id' => $post->id,
        'is_approved' => true,
    ]);

    $response = $this->get(route('posts.show', $post));

    $response->assertSeeLivewire('comments')
        ->assertSee($comment->content);
});

it('can add comment as guest', function () {
    $post = Post::factory()->published()->create();

    Livewire::test('comments', ['post' => $post])
        ->set('author_name', 'John Doe')
        ->set('author_email', 'john@example.com')
        ->set('content', 'This is a test comment')
        ->call('addComment')
        ->assertHasNoErrors();

    expect(Comment::where('post_id', $post->id)
        ->where('content', 'This is a test comment')
        ->exists())->toBeTrue();
});

it('can add comment as authenticated user', function () {
    $user = User::factory()->create();
    $post = Post::factory()->published()->create();

    $this->actingAs($user);

    Livewire::test('comments', ['post' => $post])
        ->set('content', 'Authenticated user comment')
        ->call('addComment')
        ->assertHasNoErrors();

    expect(Comment::where('post_id', $post->id)
        ->where('user_id', $user->id)
        ->where('content', 'Authenticated user comment')
        ->exists())->toBeTrue();
});

it('can reply to comments', function () {
    $post = Post::factory()->published()->create();
    $parentComment = Comment::factory()->create([
        'post_id' => $post->id,
        'is_approved' => true,
    ]);

    Livewire::test('comments', ['post' => $post])
        ->call('replyTo', $parentComment->id)
        ->set('author_name', 'Jane Doe')
        ->set('author_email', 'jane@example.com')
        ->set('content', 'This is a reply')
        ->call('addComment')
        ->assertHasNoErrors();

    expect(Comment::where('parent_id', $parentComment->id)
        ->where('content', 'This is a reply')
        ->exists())->toBeTrue();
});
