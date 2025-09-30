<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have users first
        if (\App\Models\User::count() === 0) {
            \App\Models\User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'is_admin' => true,
            ]);

            \App\Models\User::factory(3)->create();
        }

        $users = \App\Models\User::all();

        // Create some published posts
        \App\Models\Post::factory(15)
            ->published()
            ->create([
                'user_id' => $users->random()->id,
            ]);

        // Create some draft posts
        \App\Models\Post::factory(5)
            ->draft()
            ->create([
                'user_id' => $users->random()->id,
            ]);

        // Create some archived posts
        \App\Models\Post::factory(3)
            ->archived()
            ->create([
                'user_id' => $users->random()->id,
            ]);
    }
}
