<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isRegistered = fake()->boolean(70); // 70% chance of being a registered user

        return [
            'post_id' => Post::factory(),
            'user_id' => $isRegistered ? User::factory() : null,
            'parent_id' => null,
            'content' => fake()->paragraphs(fake()->numberBetween(1, 3), true),
            'author_name' => $isRegistered ? null : fake()->name(),
            'author_email' => $isRegistered ? null : fake()->safeEmail(),
            'is_approved' => fake()->boolean(80), // 80% chance of being approved
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => true,
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => false,
        ]);
    }

    public function reply(): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => Comment::factory(),
        ]);
    }

    public function guest(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => null,
            'author_name' => fake()->name(),
            'author_email' => fake()->safeEmail(),
        ]);
    }

    public function registered(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => User::factory(),
            'author_name' => null,
            'author_email' => null,
        ]);
    }
}
