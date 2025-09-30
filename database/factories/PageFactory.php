<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3, false);
        $isPublished = fake()->boolean(70); // 70% chance of being published

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->optional(0.8)->paragraph(),
            'content' => fake()->paragraphs(rand(5, 15), true),
            'meta_title' => fake()->optional(0.3)->sentence(4, false),
            'meta_description' => fake()->optional(0.5)->text(160),
            'is_published' => $isPublished,
            'published_at' => $isPublished
                ? fake()->dateTimeBetween('-1 year', 'now')
                : null,
            'author_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the page should be published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    /**
     * Indicate that the page should be a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the page should be scheduled for future publication.
     */
    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('now', '+1 month'),
        ]);
    }
}
