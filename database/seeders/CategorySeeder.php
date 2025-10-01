<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Latest technology trends and news',
                'color' => '#3b82f6',
                'sort_order' => 1,
            ],
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Web development tutorials and tips',
                'color' => '#10b981',
                'sort_order' => 2,
            ],
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
                'description' => 'Laravel framework tutorials',
                'color' => '#ef4444',
                'sort_order' => 3,
            ],
            [
                'name' => 'JavaScript',
                'slug' => 'javascript',
                'description' => 'JavaScript programming language',
                'color' => '#f59e0b',
                'sort_order' => 4,
            ],
            [
                'name' => 'Design',
                'slug' => 'design',
                'description' => 'UI/UX design and inspiration',
                'color' => '#8b5cf6',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        // Create some child categories
        $tech = \App\Models\Category::where('slug', 'technology')->first();
        $webDev = \App\Models\Category::where('slug', 'web-development')->first();

        \App\Models\Category::firstOrCreate(
            ['slug' => 'mobile-development'],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'iOS and Android development',
                'color' => '#06b6d4',
                'sort_order' => 1,
                'parent_id' => $tech->id,
            ]
        );

        \App\Models\Category::firstOrCreate(
            ['slug' => 'frontend'],
            [
                'name' => 'Frontend',
                'slug' => 'frontend',
                'description' => 'Frontend development with React, Vue, etc.',
                'color' => '#84cc16',
                'sort_order' => 1,
                'parent_id' => $webDev->id,
            ]
        );

        \App\Models\Category::firstOrCreate(
            ['slug' => 'backend'],
            [
                'name' => 'Backend',
                'slug' => 'backend',
                'description' => 'Backend development and APIs',
                'color' => '#f97316',
                'sort_order' => 2,
                'parent_id' => $webDev->id,
            ]
        );
    }
}
