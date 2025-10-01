<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateDefaultImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-default-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create default blog post image';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating default blog post image...');

        // Create images directory if it doesn't exist
        if (! Storage::disk('public')->exists('images')) {
            Storage::disk('public')->makeDirectory('images');
        }

        // Create SVG default image
        $svg = '<?xml version="1.0" encoding="UTF-8"?>
<svg width="800" height="600" viewBox="0 0 800 600" xmlns="http://www.w3.org/2000/svg">
  <rect width="800" height="600" fill="#f3f4f6"/>
  <rect x="50" y="50" width="700" height="500" fill="#ffffff" stroke="#e5e7eb" stroke-width="2" rx="8"/>
  <circle cx="150" cy="150" r="30" fill="#d1d5db"/>
  <rect x="200" y="130" width="400" height="20" fill="#d1d5db" rx="4"/>
  <rect x="200" y="160" width="300" height="20" fill="#e5e7eb" rx="4"/>
  <rect x="80" y="220" width="640" height="10" fill="#f3f4f6" rx="2"/>
  <rect x="80" y="240" width="600" height="10" fill="#f3f4f6" rx="2"/>
  <rect x="80" y="260" width="580" height="10" fill="#f3f4f6" rx="2"/>
  <rect x="80" y="280" width="620" height="10" fill="#f3f4f6" rx="2"/>
  <rect x="80" y="300" width="590" height="10" fill="#f3f4f6" rx="2"/>
  <text x="400" y="380" font-family="Arial, sans-serif" font-size="24" fill="#6b7280" text-anchor="middle">Blog Post</text>
  <text x="400" y="410" font-family="Arial, sans-serif" font-size="16" fill="#9ca3af" text-anchor="middle">Default Image</text>
</svg>';

        try {
            Storage::disk('public')->put('images/default-blog-post.svg', $svg);
            $this->info('✓ Default SVG image created: images/default-blog-post.svg');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error creating default image: '.$e->getMessage());

            return Command::FAILURE;
        }
    }
}
