<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = User::all();

        if ($authors->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');

            return;
        }

        // Створюємо популярні сторінки
        $staticPages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'excerpt' => 'Learn more about our company and mission.',
                'content' => '<h2>About Our Company</h2><p>We are a passionate team dedicated to creating exceptional digital experiences. Our mission is to help businesses grow through innovative technology solutions.</p><p>Founded in 2020, we have been serving clients worldwide with cutting-edge web development, design, and digital marketing services.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'excerpt' => 'Our commitment to protecting your privacy.',
                'content' => '<h2>Privacy Policy</h2><p>This Privacy Policy describes how we collect, use, and protect your personal information when you visit our website.</p><h3>Information We Collect</h3><p>We may collect information you provide directly to us, such as when you contact us or sign up for our newsletter.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(60),
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'excerpt' => 'Terms and conditions for using our services.',
                'content' => '<h2>Terms of Service</h2><p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement.</p><h3>Use License</h3><p>Permission is granted to temporarily download one copy of the materials on our website for personal, non-commercial transitory viewing only.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(60),
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'excerpt' => 'Get in touch with our team.',
                'content' => '<h2>Contact Information</h2><p>We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.</p><p><strong>Email:</strong> hello@example.com</p><p><strong>Phone:</strong> +1 (555) 123-4567</p>',
                'is_published' => true,
                'published_at' => now()->subDays(45),
            ],
        ];

        foreach ($staticPages as $pageData) {
            // Перевіряємо чи сторінка вже існує
            if (!Page::where('slug', $pageData['slug'])->exists()) {
                Page::create(array_merge($pageData, [
                    'author_id' => $authors->random()->id,
                ]));
            }
        }

        // Створюємо випадкові сторінки тільки якщо їх мало
        if (Page::count() < 10) {
            Page::factory(15)->published()->create([
                'author_id' => fn () => $authors->random()->id,
            ]);
        }

        // Створюємо кілька чернеток
        Page::factory(5)->draft()->create([
            'author_id' => fn () => $authors->random()->id,
        ]);

        // Створюємо кілька запланованих сторінок
        Page::factory(3)->scheduled()->create([
            'author_id' => fn () => $authors->random()->id,
        ]);
    }
}
