<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class RefreshTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-test-data 
                            {--fresh : Drop all tables and migrate from scratch} 
                            {--clean-images : Clean and regenerate test images} 
                            {--skip-images : Skip image generation entirely}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh all test data including images and seed data';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Refreshing test data...');

        if ($this->option('fresh')) {
            $this->info('📝 Running fresh migrations...');
            Artisan::call('migrate:fresh');
            $this->line(Artisan::output());
        }

        // Handle image generation
        if ($this->option('skip-images')) {
            $this->info('🖼️ Skipping image generation...');
        } else {
            $this->info('🖼️ Generating test images...');
            $generateImagesCommand = 'app:generate-test-images --no-interaction';
            if ($this->option('clean-images')) {
                $generateImagesCommand .= ' --clean';
            }

            try {
                Artisan::call($generateImagesCommand);
                $this->line(Artisan::output());
            } catch (\Exception $e) {
                $this->warn('Image generation skipped: '.$e->getMessage());
            }
        }

        // Ensure default image exists
        $this->info('🎨 Ensuring default image exists...');
        if (! Storage::disk('public')->exists('images/default-blog-post.svg')) {
            try {
                Artisan::call('app:create-default-image');
                $this->line(Artisan::output());
            } catch (\Exception $e) {
                $this->warn('Default image creation failed: '.$e->getMessage());
            }
        } else {
            $this->line('Default image already exists.');
        }

        $this->info('🌱 Seeding database...');
        Artisan::call('db:seed');
        $this->line(Artisan::output());

        $this->info('✅ Test data refresh completed!');

        return Command::SUCCESS;
    }
}
