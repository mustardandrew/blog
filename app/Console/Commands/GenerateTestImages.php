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
    protected $signature = 'app:generate-test-images {--count=20 : Number of images to generate} {--clean : Clean existing images before generating new ones} {--force : Force regeneration of existing images}';

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
        $count = (int) $this->option('count', 20);
        $clean = $this->option('clean');
        $force = $this->option('force');

        $this->info('Starting test image generation...');

        // Check if images already exist
        if (! $clean && ! $force && TestImageGenerator::hasTestImages()) {
            $existingCount = TestImageGenerator::getTestImageCount();
            $this->info("Found {$existingCount} existing test images.");

            // In non-interactive mode, skip generation by default
            if ($this->option('no-interaction')) {
                $this->info('Running in non-interactive mode. Skipping image generation.');

                return Command::SUCCESS;
            }

            if (! $this->confirm('Test images already exist. Do you want to skip generation?', true)) {
                $clean = $this->confirm('Do you want to clean existing images and generate new ones?');
            } else {
                $this->info('Skipping image generation.');

                return Command::SUCCESS;
            }
        }

        if ($clean) {
            $this->info('Cleaning existing images...');
        } elseif ($force) {
            $this->info('Force mode: will overwrite existing images');
        }

        $images = TestImageGenerator::generateTestImages($count, $clean || $force);

        if (empty($images)) {
            $this->warn('No images were generated.');

            return Command::SUCCESS;
        }

        $this->info('Generated '.count($images).' test images successfully!');

        // Show first few generated images
        $displayImages = array_slice($images, 0, 5);
        foreach ($displayImages as $image) {
            $this->line("✓ {$image}");
        }

        if (count($images) > 5) {
            $this->line('... and '.(count($images) - 5).' more images');
        }

        return Command::SUCCESS;
    }
}
