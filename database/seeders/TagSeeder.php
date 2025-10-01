<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Popular programming and technology tags
        $featuredTags = [
            ['name' => 'PHP', 'color' => '#777bb4', 'is_featured' => true, 'usage_count' => 45],
            ['name' => 'Laravel', 'color' => '#ff2d20', 'is_featured' => true, 'usage_count' => 38],
            ['name' => 'JavaScript', 'color' => '#f7df1e', 'is_featured' => true, 'usage_count' => 42],
            ['name' => 'Vue.js', 'color' => '#4fc08d', 'is_featured' => true, 'usage_count' => 28],
            ['name' => 'API', 'color' => '#6366f1', 'is_featured' => true, 'usage_count' => 31],
        ];

        $regularTags = [
            ['name' => 'React', 'color' => '#61dafb', 'usage_count' => 22],
            ['name' => 'Node.js', 'color' => '#339933', 'usage_count' => 18],
            ['name' => 'MySQL', 'color' => '#4479a1', 'usage_count' => 25],
            ['name' => 'CSS', 'color' => '#1572b6', 'usage_count' => 30],
            ['name' => 'HTML', 'color' => '#e34f26', 'usage_count' => 28],
            ['name' => 'TypeScript', 'color' => '#3178c6', 'usage_count' => 16],
            ['name' => 'Python', 'color' => '#3776ab', 'usage_count' => 14],
            ['name' => 'Docker', 'color' => '#2496ed', 'usage_count' => 12],
            ['name' => 'Git', 'color' => '#f05032', 'usage_count' => 20],
            ['name' => 'Tailwind CSS', 'color' => '#06b6d4', 'usage_count' => 19],
            ['name' => 'Livewire', 'color' => '#fb70a9', 'usage_count' => 15],
            ['name' => 'Filament', 'color' => '#fdba74', 'usage_count' => 13],
            ['name' => 'REST', 'color' => '#8b5cf6', 'usage_count' => 17],
            ['name' => 'GraphQL', 'color' => '#e10098', 'usage_count' => 8],
            ['name' => 'Pest', 'color' => '#10b981', 'usage_count' => 11],
            ['name' => 'Tutorial', 'color' => '#f59e0b', 'usage_count' => 24],
            ['name' => 'Tips & Tricks', 'color' => '#8b5cf6', 'usage_count' => 19],
            ['name' => 'Best Practices', 'color' => '#059669', 'usage_count' => 16],
            ['name' => 'Performance', 'color' => '#dc2626', 'usage_count' => 14],
            ['name' => 'Security', 'color' => '#7c2d12', 'usage_count' => 13],
        ];

        // Create featured tags
        foreach ($featuredTags as $tagData) {
            Tag::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($tagData['name'])],
                [
                    'name' => $tagData['name'],
                    'slug' => \Illuminate\Support\Str::slug($tagData['name']),
                    'description' => "Posts related to {$tagData['name']}",
                    'color' => $tagData['color'],
                    'is_featured' => $tagData['is_featured'],
                    'usage_count' => $tagData['usage_count'],
                ]
            );
        }

        // Create regular tags
        foreach ($regularTags as $tagData) {
            Tag::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($tagData['name'])],
                [
                    'name' => $tagData['name'],
                    'slug' => \Illuminate\Support\Str::slug($tagData['name']),
                    'description' => "Posts related to {$tagData['name']}",
                    'color' => $tagData['color'],
                    'is_featured' => false,
                    'usage_count' => $tagData['usage_count'],
                ]
            );
        }
    }
}
