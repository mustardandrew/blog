<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(rand(3, 8));
        $content = collect(range(1, rand(3, 6)))
            ->map(fn() => '<p>' . fake()->paragraph(rand(3, 8)) . '</p>')
            ->implode("\n\n");

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'excerpt' => fake()->paragraph(2),
            'content' => $content,
            'featured_image' => fake()->optional()->imageUrl(800, 600, 'blog'),
            'meta_title' => fake()->optional()->sentence(4),
            'meta_description' => fake()->optional()->paragraph(1),
            'meta_keywords' => fake()->optional()->words(rand(3, 8)),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'published_at' => fake()->optional(0.7)->dateTimeBetween('-1 year', '+1 week'),
            'user_id' => \App\Models\User::factory(),
        ];
    }

    public function published(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'archived',
            'published_at' => fake()->dateTimeBetween('-2 years', '-1 month'),
        ]);
    }
}
