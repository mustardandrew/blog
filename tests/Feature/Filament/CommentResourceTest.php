<?php

declare(strict_types=1);

use App\Filament\Resources\Comments\Pages\ListComments;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

uses()->group('filament');

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user, 'web');
});

test('can list comments', function () {
    $post = Post::factory()->create();
    $comments = Comment::factory()
        ->count(3)
        ->for($post)
        ->for($this->user)
        ->approved()
        ->create();

    Livewire::test(ListComments::class)
        ->assertCanSeeTableRecords($comments);
});

test('can filter comments by approval status', function () {
    $post = Post::factory()->create();

    $approvedComments = Comment::factory()
        ->count(2)
        ->for($post)
        ->for($this->user)
        ->approved()
        ->create();

    $pendingComments = Comment::factory()
        ->count(2)
        ->for($post)
        ->for($this->user)
        ->pending()
        ->create();

    Livewire::test(ListComments::class)
        ->filterTable('is_approved', true)
        ->assertCanSeeTableRecords($approvedComments)
        ->assertCanNotSeeTableRecords($pendingComments);
});

test('can filter comments by post', function () {
    $post1 = Post::factory()->create();
    $post2 = Post::factory()->create();

    $post1Comments = Comment::factory()
        ->count(2)
        ->for($post1)
        ->for($this->user)
        ->create();

    $post2Comments = Comment::factory()
        ->count(2)
        ->for($post2)
        ->for($this->user)
        ->create();

    Livewire::test(ListComments::class)
        ->filterTable('post_id', $post1->id)
        ->assertCanSeeTableRecords($post1Comments)
        ->assertCanNotSeeTableRecords($post2Comments);
});

test('can filter comments by author type', function () {
    $post = Post::factory()->create();

    $registeredComments = Comment::factory()
        ->count(2)
        ->for($post)
        ->for($this->user)
        ->create();

    $guestComments = Comment::factory()
        ->count(2)
        ->for($post)
        ->guest()
        ->create();

    Livewire::test(ListComments::class)
        ->filterTable('has_user', true)
        ->assertCanSeeTableRecords($registeredComments)
        ->assertCanNotSeeTableRecords($guestComments);
});

test('can edit comment', function () {
    $post = Post::factory()->create();
    $comment = Comment::factory()
        ->for($post)
        ->for($this->user)
        ->create([
            'content' => 'Original comment content',
            'is_approved' => false,
        ]);

    Livewire::test(\App\Filament\Resources\Comments\Pages\EditComment::class, [
        'record' => $comment->getRouteKey(),
    ])
        ->fillForm([
            'content' => 'Updated comment content',
            'is_approved' => true,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($comment->fresh())
        ->content->toBe('Updated comment content')
        ->is_approved->toBeTrue();
});
