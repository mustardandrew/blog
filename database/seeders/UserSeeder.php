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
        // Створюємо адміністратора
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Створюємо звичайного користувача для тестування
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
        ]);

        // Створюємо ще 10 випадкових користувачів
        User::factory(10)->create();

        // Створюємо ще 2 адміністраторів
        User::factory(2)->admin()->create();
    }
}
