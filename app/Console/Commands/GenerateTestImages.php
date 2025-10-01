<?php

namespace App\Console\Commands;

use Database\Seeders\Helpers\TestImageGenerator;
use Illuminate\Console\Command;

class GenerateTestImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-test-images {--force : Force regeneration of existing images}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate test images for blog posts';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting test image generation...');
        
        if ($this->option('force')) {
            $this->info('Force mode: will overwrite existing images');
        }
        
        $images = TestImageGenerator::generateTestImages();
        
        $this->info("Generated " . count($images) . " test images successfully!");
        
        foreach ($images as $image) {
            $this->line("✓ {$image}");
        }
        
        return Command::SUCCESS;
    }
}
