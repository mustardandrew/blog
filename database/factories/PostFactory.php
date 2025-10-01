<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Get a random test image path or fallback to placeholder.
     */
    private function getRandomFeaturedImage(): ?string
    {
        if (! fake()->boolean(80)) {
            return null;
        }

        $testImages = Storage::disk('public')->files('test-images');

        if (! empty($testImages)) {
            return fake()->randomElement($testImages);
        }

        // Fallback: use placeholder URL if no test images exist
        return fake()->imageUrl(800, 600, 'blog');
    }

    /**
     * Generate rich content with paragraphs, lists, and quotes.
     */
    private function generateRichContent(): string
    {
        $contentParts = [];
        $sectionsCount = rand(8, 15); // Більше секцій контенту

        for ($i = 0; $i < $sectionsCount; $i++) {
            $sectionType = fake()->randomElement([
                'paragraph',
                'paragraph', 
                'paragraph', 
                'paragraph', // Більша ймовірність для абзаців
                'list', 
                'quote',
                'heading'
            ]);

            switch ($sectionType) {
                case 'paragraph':
                    $contentParts[] = '<p>' . fake()->paragraph(rand(4, 12)) . '</p>';
                    break;

                case 'list':
                    $listType = fake()->randomElement(['ul', 'ol']);
                    $listItems = collect(range(1, rand(3, 7)))
                        ->map(fn() => '<li>' . fake()->sentence(rand(3, 10)) . '</li>')
                        ->implode("\n");
                    $contentParts[] = "<{$listType}>\n{$listItems}\n</{$listType}>";
                    break;

                case 'quote':
                    $quote = fake()->paragraph(rand(2, 4));
                    $author = fake()->optional(0.7)->name();
                    $attribution = $author ? "\n<cite>— {$author}</cite>" : '';
                    $contentParts[] = "<blockquote>\n<p>{$quote}</p>{$attribution}\n</blockquote>";
                    break;

                case 'heading':
                    if ($i > 2) { // Тільки після кількох абзаців
                        $contentParts[] = '<h3>' . fake()->sentence(rand(2, 6), false) . '</h3>';
                    } else {
                        $contentParts[] = '<p>' . fake()->paragraph(rand(4, 12)) . '</p>';
                    }
                    break;
            }
        }

        return implode("\n\n", $contentParts);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(rand(3, 8));
        $content = $this->generateRichContent();

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'excerpt' => fake()->paragraph(2),
            'content' => $content,
            'featured_image' => $this->getRandomFeaturedImage(),
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
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'archived',
            'published_at' => fake()->dateTimeBetween('-2 years', '-1 month'),
        ]);
    }
}
