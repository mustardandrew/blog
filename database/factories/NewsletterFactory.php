<?php

namespace Database\Factories;

use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Newsletter>
 */
class NewsletterFactory extends Factory
{
    protected $model = Newsletter::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'name' => fake()->name(),
            'user_id' => null,
            'email_verified_at' => fake()->boolean(80) ? now() : null,
            'verification_token' => fake()->boolean(20) ? Str::random(60) : null,
            'is_active' => fake()->boolean(90),
            'subscribed_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
            'verification_token' => Str::random(60),
        ]);
    }

    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
            'unsubscribed_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }
}
