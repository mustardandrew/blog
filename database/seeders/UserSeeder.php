<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Створюємо адміністратора тільки якщо він не існує
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::factory()->admin()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
            ]);
        }

        // Створюємо звичайного користувача для тестування тільки якщо він не існує
        if (!User::where('email', 'user@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'user@example.com',
            ]);
        }

        // Створюємо ще користувачів тільки якщо їх мало
        if (User::count() < 10) {
            User::factory(10 - User::count())->create();
        }
    }
}
