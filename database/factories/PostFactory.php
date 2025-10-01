<?php

namespace Database\Factories;

use Database\Seeders\Helpers\TestImageGenerator;
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

        // Get a random test image (80% chance of having an image)
        $featuredImage = fake()->optional(0.8)->randomElement([
            'test-images/test-blog-1-programming.jpg',
            'test-images/test-blog-2-cloud-computing.jpg',
            'test-images/test-blog-3-business.jpg',
            'test-images/test-blog-4-programming.jpg',
            'test-images/test-blog-5-artificial-intelligence.jpg',
            'test-images/test-blog-6-data-science.jpg',
            'test-images/test-blog-7-web-development.jpg',
            'test-images/test-blog-8-startup.jpg',
            'test-images/test-blog-9-mobile-apps.jpg',
            'test-images/test-blog-10-programming.jpg',
            'test-images/test-blog-11-programming.jpg',
            'test-images/test-blog-12-design.jpg',
            'test-images/test-blog-13-artificial-intelligence.jpg',
            'test-images/test-blog-14-technology.jpg',
            'test-images/test-blog-15-data-science.jpg',
            'test-images/test-blog-16-data-science.jpg',
            'test-images/test-blog-17-business.jpg',
            'test-images/test-blog-18-programming.jpg',
            'test-images/test-blog-19-cloud-computing.jpg',
            'test-images/test-blog-20-mobile-apps.jpg',
        ]);

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'excerpt' => fake()->paragraph(2),
            'content' => $content,
            'featured_image' => $featuredImage,
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
