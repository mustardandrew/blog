<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(rand(1, 3), true);

        return [
            'name' => ucfirst($name),
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->optional(0.7)->paragraph(),
            'color' => fake()->hexColor(),
            'is_active' => fake()->boolean(90), // 90% chance of being active
            'sort_order' => fake()->numberBetween(0, 100),
            'parent_id' => null, // Will be set in states if needed
        ];
    }

    /**
     * Indicate that the category should be inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the category should be a child of another category.
     */
    public function child($parentId = null): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => $parentId ?? \App\Models\Category::factory(),
        ]);
    }
}
