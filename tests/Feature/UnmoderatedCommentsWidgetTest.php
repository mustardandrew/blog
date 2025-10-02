<?php

declare(strict_types=1);

use App\Filament\Widgets\UnmoderatedCommentsWidget;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

test('widget is visible when there are unapproved comments', function () {
    Comment::factory()->create(['is_approved' => false]);

    expect(UnmoderatedCommentsWidget::canView())->toBeTrue();
});

test('widget is hidden when no unapproved comments', function () {
    Comment::factory()->create(['is_approved' => true]);

    expect(UnmoderatedCommentsWidget::canView())->toBeFalse();
});

test('widget shows correct unapproved count', function () {
    $this->actingAs(User::factory()->admin()->create());

    Comment::factory()->count(3)->create(['is_approved' => false]);
    Comment::factory()->count(2)->create(['is_approved' => true]);

    Livewire::test(UnmoderatedCommentsWidget::class)
        ->assertSee('3') // Should see unapproved count
        ->assertSee('comments awaiting moderation');
});

test('widget shows basic functionality', function () {
    $this->actingAs(User::factory()->admin()->create());

    $post = Post::factory()->create(['title' => 'Test Post Title']);
    $comment = Comment::factory()->create([
        'is_approved' => false,
        'author_name' => 'John Doe',
        'content' => 'This is a test comment content for the widget',
        'post_id' => $post->id,
    ]);

    Livewire::test(UnmoderatedCommentsWidget::class)
        ->assertSee('Pending Comments')
        ->assertSee('Moderate');
});

test('widget polls for updates', function () {
    $this->actingAs(User::factory()->admin()->create());

    Comment::factory()->create(['is_approved' => false]);

    $widget = Livewire::test(UnmoderatedCommentsWidget::class);

    expect($widget->instance()->getPollingInterval())->toBe('30s');
});

test('widget shows today comments when available', function () {
    $this->actingAs(User::factory()->admin()->create());

    // Create an unapproved comment for today
    Comment::factory()->create([
        'is_approved' => false,
        'created_at' => now(),
    ]);

    // Create an old unapproved comment
    Comment::factory()->create([
        'is_approved' => false,
        'created_at' => now()->subDays(5),
    ]);

    Livewire::test(UnmoderatedCommentsWidget::class)
        ->assertSee('Today')
        ->assertSee('1'); // Should show 1 for today's count
});

test('widget shows total comments count', function () {
    $this->actingAs(User::factory()->admin()->create());

    Comment::factory()->count(2)->create(['is_approved' => false]);
    Comment::factory()->count(3)->create(['is_approved' => true]);

    Livewire::test(UnmoderatedCommentsWidget::class)
        ->assertSee('5') // Total count
        ->assertSee('Total');
});

test('widget displays author name correctly for registered users', function () {
    $this->actingAs(User::factory()->admin()->create());

    $user = User::factory()->create(['name' => 'Registered User']);
    $post = Post::factory()->create();

    Comment::factory()->create([
        'is_approved' => false,
        'user_id' => $user->id,
        'author_name' => null, // Should use user name instead
        'content' => 'Comment by registered user',
        'post_id' => $post->id,
    ]);

    Livewire::test(UnmoderatedCommentsWidget::class)
        ->assertSee('Registered User')
        ->assertSee('Comment by registered user');
});
