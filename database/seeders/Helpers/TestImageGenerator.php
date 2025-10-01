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
        'software-engineering'
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

    public static function generateTestImages(): array
    {
        $images = [];
        
        // Generate 20 different test images
        for ($i = 1; $i <= 20; $i++) {
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
                    $fallbackUrl = "https://via.placeholder.com/{$width}x{$height}/{$color}/FFFFFF?text=" . urlencode(ucfirst($topic));
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