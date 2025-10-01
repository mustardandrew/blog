<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-test-data {--fresh : Drop all tables and migrate from scratch}';

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
        
        $this->info('🖼️ Generating test images...');
        Artisan::call('app:generate-test-images');
        $this->line(Artisan::output());
        
        $this->info('🌱 Seeding database...');
        Artisan::call('db:seed');
        $this->line(Artisan::output());
        
        $this->info('✅ Test data refresh completed!');
        
        return Command::SUCCESS;
    }
}