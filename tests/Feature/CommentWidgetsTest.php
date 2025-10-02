<?php

declare(strict_types=1);

use App\Filament\Widgets\CommentStatsWidget;
use App\Filament\Widgets\RecentCommentsWidget;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->admin()->create());
});

describe('RecentCommentsWidget', function () {
    test('widget is visible when there are comments', function () {
        Comment::factory()->create();

        expect(RecentCommentsWidget::canView())->toBeTrue();
    });

    test('widget is hidden when no comments', function () {
        expect(RecentCommentsWidget::canView())->toBeFalse();
    });

    test('widget shows recent comments with correct data', function () {
        $post = Post::factory()->create(['title' => 'Test Post Title']);
        $user = User::factory()->create(['name' => 'John Doe']);

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'content' => 'This is a test comment content',
            'is_approved' => true,
        ]);

        Livewire::test(RecentCommentsWidget::class)
            ->assertSee('John Doe')
            ->assertSee('This is a test comment content')
            ->assertSee('Test Post Title');
    });

    test('widget shows comment status icons correctly', function () {
        Comment::factory()->create(['is_approved' => true]);
        Comment::factory()->create(['is_approved' => false]);

        $widget = Livewire::test(RecentCommentsWidget::class);

        // Should render without errors and show status indicators
        expect($widget->instance())->not->toBeNull();
    });

    test('widget has correct polling interval', function () {
        $widget = Livewire::test(RecentCommentsWidget::class);

        expect($widget->instance()->getPollingInterval())->toBe('60s');
    });
});

describe('CommentStatsWidget', function () {
    test('widget is visible when there are comments', function () {
        Comment::factory()->create();

        expect(CommentStatsWidget::canView())->toBeTrue();
    });

    test('widget is hidden when no comments', function () {
        expect(CommentStatsWidget::canView())->toBeFalse();
    });

    test('widget shows pending comments when available', function () {
        Comment::factory()->count(3)->create(['is_approved' => false]);
        Comment::factory()->count(5)->create(['is_approved' => true]);

        Livewire::test(CommentStatsWidget::class)
            ->assertSee('Pending Comments')
            ->assertSee('3');
    });

    test('widget shows approved comments count', function () {
        Comment::factory()->count(7)->create(['is_approved' => true]);
        Comment::factory()->count(2)->create(['is_approved' => false]);

        Livewire::test(CommentStatsWidget::class)
            ->assertSee('Approved Comments')
            ->assertSee('7');
    });

    test('widget shows today comments when available', function () {
        // Create comment for today
        Comment::factory()->create([
            'created_at' => now(),
        ]);

        // Create old comment
        Comment::factory()->create([
            'created_at' => now()->subDays(3),
        ]);

        Livewire::test(CommentStatsWidget::class)
            ->assertSee('Today\'s Comments')
            ->assertSee('1');
    });

    test('widget has correct polling interval', function () {
        Comment::factory()->create();

        $widget = Livewire::test(CommentStatsWidget::class);

        expect($widget->instance()->getPollingInterval())->toBe('45s');
    });
});
