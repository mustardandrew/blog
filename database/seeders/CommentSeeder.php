<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        // Create top-level comments
        $topLevelComments = [];

        foreach ($posts as $post) {
            // 3-8 comments per post
            $commentCount = fake()->numberBetween(3, 8);

            for ($i = 0; $i < $commentCount; $i++) {
                $comment = Comment::factory()
                    ->for($post)
                    ->when(
                        fake()->boolean(60), // 60% chance of being from registered user
                        fn ($factory) => $factory->for($users->random()),
                        fn ($factory) => $factory->guest()
                    )
                    ->approved()
                    ->create();

                $topLevelComments[] = $comment;
            }
        }

        // Create some replies to existing comments (30% of top-level comments get replies)
        $commentsToReply = collect($topLevelComments)->random(intval(count($topLevelComments) * 0.3));

        foreach ($commentsToReply as $parentComment) {
            $replyCount = fake()->numberBetween(1, 3);

            for ($i = 0; $i < $replyCount; $i++) {
                Comment::factory()
                    ->for($parentComment->post)
                    ->for($parentComment, 'parent')
                    ->when(
                        fake()->boolean(70), // Higher chance of registered users replying
                        fn ($factory) => $factory->for($users->random()),
                        fn ($factory) => $factory->guest()
                    )
                    ->approved()
                    ->create();
            }
        }

        // Create some pending (unapproved) comments
        $pendingCount = fake()->numberBetween(5, 12);

        for ($i = 0; $i < $pendingCount; $i++) {
            Comment::factory()
                ->for($posts->random())
                ->when(
                    fake()->boolean(40), // Lower chance of registered users in pending
                    fn ($factory) => $factory->for($users->random()),
                    fn ($factory) => $factory->guest()
                )
                ->pending()
                ->create();
        }
    }
}
