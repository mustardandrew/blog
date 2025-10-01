<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have users first, but avoid duplicates
        if (User::count() === 0) {
            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'is_admin' => true,
            ]);

            User::factory(3)->create();
        }

        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        // Only create posts if we don't have many already
        if (Post::count() < 10) {
            // Create published posts with better variety
            $publishedPosts = Post::factory(20)
                ->published()
                ->create()
                ->each(function ($post) use ($users, $categories, $tags) {
                    // Assign random user
                    $post->user_id = $users->random()->id;
                    
                    // Assign 1-2 categories (if available)
                    if ($categories->isNotEmpty()) {
                        $post->categories()->attach(
                            $categories->random(rand(1, min(2, $categories->count())))->pluck('id')
                        );
                    }
                    
                    // Assign 2-5 tags (if available)
                    if ($tags->isNotEmpty()) {
                        $post->tags()->attach(
                            $tags->random(rand(2, min(5, $tags->count())))->pluck('id')
                        );
                    }
                    
                    $post->save();
                });

            // Create some draft posts
            $draftPosts = Post::factory(8)
                ->draft()
                ->create()
                ->each(function ($post) use ($users, $categories, $tags) {
                    $post->user_id = $users->random()->id;
                    
                    if ($categories->isNotEmpty()) {
                        $post->categories()->attach(
                            $categories->random(rand(1, min(2, $categories->count())))->pluck('id')
                        );
                    }
                    
                    if ($tags->isNotEmpty()) {
                        $post->tags()->attach(
                            $tags->random(rand(1, min(3, $tags->count())))->pluck('id')
                        );
                    }
                    
                    $post->save();
                });

            // Create some archived posts
            $archivedPosts = Post::factory(5)
                ->archived()
                ->create()
                ->each(function ($post) use ($users, $categories, $tags) {
                    $post->user_id = $users->random()->id;
                    
                    if ($categories->isNotEmpty()) {
                        $post->categories()->attach(
                            $categories->random(rand(1, min(2, $categories->count())))->pluck('id')
                        );
                    }
                    
                    if ($tags->isNotEmpty()) {
                        $post->tags()->attach(
                            $tags->random(rand(1, min(3, $tags->count())))->pluck('id')
                        );
                    }
                    
                    $post->save();
                });

            $this->command->info('Created ' . ($publishedPosts->count() + $draftPosts->count() + $archivedPosts->count()) . ' posts total:');
            $this->command->info("- {$publishedPosts->count()} published posts");
            $this->command->info("- {$draftPosts->count()} draft posts");
            $this->command->info("- {$archivedPosts->count()} archived posts");
        } else {
            $this->command->info('Posts already exist, skipping...');
        }
    }
}
