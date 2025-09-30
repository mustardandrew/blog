<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'name' => ucfirst($name),
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->optional(0.6)->sentence(),
            'color' => fake()->hexColor(),
            'is_featured' => fake()->boolean(20), // 20% chance of being featured
            'usage_count' => fake()->numberBetween(0, 50),
        ];
    }

    /**
     * Indicate that the tag should be featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'usage_count' => fake()->numberBetween(20, 100),
        ]);
    }

    /**
     * Indicate that the tag should be popular (high usage count).
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'usage_count' => fake()->numberBetween(50, 200),
        ]);
    }

    /**
     * Create common programming tags.
     */
    public function programming(): static
    {
        $programmingTags = [
            'PHP', 'JavaScript', 'Laravel', 'Vue.js', 'React', 'Node.js',
            'MySQL', 'PostgreSQL', 'Docker', 'Git', 'CSS', 'HTML',
            'TypeScript', 'Python', 'API', 'REST', 'GraphQL',
        ];

        $tag = fake()->randomElement($programmingTags);

        return $this->state(fn (array $attributes) => [
            'name' => $tag,
            'slug' => \Illuminate\Support\Str::slug($tag),
        ]);
    }
}
