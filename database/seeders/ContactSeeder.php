<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some read contacts
        Contact::factory()
            ->read()
            ->count(3)
            ->create();

        // Create some unread contacts
        Contact::factory()
            ->unread()
            ->count(5)
            ->create();

        // Create a specific contact for testing
        Contact::factory()->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'subject' => 'Question about your latest book review',
            'message' => 'Hi! I really enjoyed your review of "The Great Gatsby". Could you recommend some similar books? I\'m particularly interested in classic American literature with complex character development.',
            'is_read' => false,
        ]);
    }
}
