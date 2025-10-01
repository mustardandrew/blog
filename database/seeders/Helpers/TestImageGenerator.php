<?php

namespace Database\Seeders\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TestImageGenerator
{
    private static array $imageTopics = [
        'technology',
        'programming',
        'web-development',
        'artificial-intelligence',
        'startup',
        'business',
        'design',
        'mobile-apps',
        'data-science',
        'cybersecurity',
        'cloud-computing',
        'software-engineering',
    ];

    private static array $imageColors = [
        '4F46E5', // Indigo
        '059669', // Emerald
        'DC2626', // Red
        'CA8A04', // Yellow
        '7C3AED', // Violet
        'DB2777', // Pink
        '0891B2', // Sky
        'EA580C', // Orange
        '16A34A', // Green
        '9333EA', // Purple
    ];

    /**
     * Check if test images already exist
     */
    public static function hasTestImages(): bool
    {
        $testImages = Storage::disk('public')->files('test-images');

        return ! empty($testImages);
    }

    /**
     * Get count of existing test images
     */
    public static function getTestImageCount(): int
    {
        $testImages = Storage::disk('public')->files('test-images');

        return count($testImages);
    }

    /**
     * Clean all existing test images
     */
    public static function cleanTestImages(): bool
    {
        try {
            $testImages = Storage::disk('public')->files('test-images');

            foreach ($testImages as $image) {
                Storage::disk('public')->delete($image);
            }

            // Remove the directory if it's empty
            if (Storage::disk('public')->exists('test-images')) {
                $remainingFiles = Storage::disk('public')->files('test-images');
                if (empty($remainingFiles)) {
                    Storage::disk('public')->deleteDirectory('test-images');
                }
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function generateTestImages(int $count = 20, bool $cleanFirst = false): array
    {
        $images = [];

        // Clean existing images if requested
        if ($cleanFirst) {
            echo "Cleaning existing test images...\n";
            self::cleanTestImages();
        }

        // Check if images already exist and we're not cleaning first
        if (! $cleanFirst && self::hasTestImages()) {
            echo 'Test images already exist ('.self::getTestImageCount()." images found).\n";
            echo "Use --clean flag to regenerate them.\n";

            return Storage::disk('public')->files('test-images');
        }

        echo "Generating {$count} test images...\n";

        // Generate the specified number of test images
        for ($i = 1; $i <= $count; $i++) {
            $topic = self::$imageTopics[array_rand(self::$imageTopics)];
            $color = self::$imageColors[array_rand(self::$imageColors)];
            $width = 800;
            $height = 600;

            // Create filename
            $filename = "test-blog-{$i}-{$topic}.jpg";
            $path = "test-images/{$filename}";

            // Generate image using placeholder service
            $imageUrl = "https://picsum.photos/seed/{$topic}-{$i}/{$width}/{$height}";

            try {
                $response = Http::timeout(10)->get($imageUrl);

                if ($response->successful()) {
                    Storage::disk('public')->put($path, $response->body());
                    $images[] = $path;
                    echo "Generated: {$filename}\n";
                } else {
                    // Fallback to a simpler placeholder
                    $fallbackUrl = "https://via.placeholder.com/{$width}x{$height}/{$color}/FFFFFF?text=".urlencode(ucfirst($topic));
                    $fallbackResponse = Http::timeout(10)->get($fallbackUrl);

                    if ($fallbackResponse->successful()) {
                        Storage::disk('public')->put($path, $fallbackResponse->body());
                        $images[] = $path;
                        echo "Generated (fallback): {$filename}\n";
                    }
                }
            } catch (\Exception $e) {
                echo "Failed to generate: {$filename} - {$e->getMessage()}\n";
            }
        }

        return $images;
    }

    public static function getRandomTestImage(): ?string
    {
        $testImages = Storage::disk('public')->files('test-images');

        if (empty($testImages)) {
            return null;
        }

        return $testImages[array_rand($testImages)];
    }
}
