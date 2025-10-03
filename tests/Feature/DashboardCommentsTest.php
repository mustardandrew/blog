<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

test('authenticated user can access dashboard comments page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard.comments'))
        ->assertSuccessful()
        ->assertSee('My Comments');
});

test('unauthenticated user is redirected to login', function () {
    $this->get(route('dashboard.comments'))
        ->assertRedirect(route('login'));
});

test('user can see their own comments', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $userComment = Comment::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'content' => 'This is my comment',
    ]);

    $otherComment = Comment::factory()->create([
        'post_id' => $post->id,
        'content' => 'This is someone elses comment',
    ]);

    $this->actingAs($user)
        ->get(route('dashboard.comments'))
        ->assertSee('This is my comment')
        ->assertDontSee('This is someone elses comment');
});

test('user can search their comments', function () {
    $user = User::factory()->create();
    $post1 = Post::factory()->create(['title' => 'Laravel Tutorial']);
    $post2 = Post::factory()->create(['title' => 'PHP Basics']);

    Comment::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post1->id,
        'content' => 'Great Laravel tutorial!',
    ]);

    Comment::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post2->id,
        'content' => 'Nice PHP explanation',
    ]);

    // Test using Livewire component test
    \Livewire\Livewire::actingAs($user)
        ->test(\App\Livewire\Dashboard\CommentsManagement::class)
        ->set('search', 'Laravel')
        ->assertSee('Great Laravel tutorial!')
        ->assertDontSee('Nice PHP explanation');
});

test('comments are paginated', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    // Create 15 comments (more than the pagination limit of 10)
    Comment::factory()->count(15)->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    $response = $this->actingAs($user)
        ->get(route('dashboard.comments'));

    // Should see pagination links
    $response->assertSee('Next');
});

test('user sees empty state when no comments exist', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard.comments'))
        ->assertSee('You have no comments yet');
});

test('user can navigate to post from comment', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['title' => 'Test Post']);

    Comment::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    $this->actingAs($user)
        ->get(route('dashboard.comments'))
        ->assertSee($post->title)
        ->assertSee(route('posts.show', $post->slug));
});

test('comment approval status is displayed correctly', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $approvedComment = Comment::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'is_approved' => true,
    ]);

    $pendingComment = Comment::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'is_approved' => false,
    ]);

    $this->actingAs($user)
        ->get(route('dashboard.comments'))
        ->assertSee('Approved')
        ->assertSee('Pending Review');
});

test('user can delete their own comment', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();
    $comment = Comment::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    $this->actingAs($user);

    Livewire::test(\App\Livewire\Dashboard\CommentsManagement::class)
        ->call('deleteComment', $comment->id)
        ->assertHasNoErrors();

    expect(Comment::find($comment->id))->toBeNull();
});

test('user cannot delete other users comments', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create();
    $comment = Comment::factory()->create([
        'user_id' => $otherUser->id,
        'post_id' => $post->id,
    ]);

    $this->actingAs($user);

    Livewire::test(\App\Livewire\Dashboard\CommentsManagement::class)
        ->call('deleteComment', $comment->id)
        ->assertHasErrors('general');

    expect(Comment::find($comment->id))->not()->toBeNull();
});
