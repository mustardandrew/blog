<?php

declare(strict_types=1);

use Database\Seeders\Helpers\TestImageGenerator;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    // Clean test images before each test
    TestImageGenerator::cleanTestImages();
});

afterEach(function () {
    // Clean test images after each test
    TestImageGenerator::cleanTestImages();
});

test('can check if test images exist', function () {
    expect(TestImageGenerator::hasTestImages())->toBeFalse();
    expect(TestImageGenerator::getTestImageCount())->toBe(0);
    
    // Generate some images
    TestImageGenerator::generateTestImages(3);
    
    expect(TestImageGenerator::hasTestImages())->toBeTrue();
    expect(TestImageGenerator::getTestImageCount())->toBe(3);
});

test('can clean test images', function () {
    // Generate some images first
    TestImageGenerator::generateTestImages(3);
    expect(TestImageGenerator::hasTestImages())->toBeTrue();
    
    // Clean them
    $result = TestImageGenerator::cleanTestImages();
    expect($result)->toBeTrue();
    expect(TestImageGenerator::hasTestImages())->toBeFalse();
    expect(TestImageGenerator::getTestImageCount())->toBe(0);
});

test('generates specified number of images', function () {
    $images = TestImageGenerator::generateTestImages(5);
    
    expect($images)->toHaveCount(5);
    expect(TestImageGenerator::getTestImageCount())->toBe(5);
    
    // Check that files actually exist
    foreach ($images as $imagePath) {
        expect(Storage::disk('public')->exists($imagePath))->toBeTrue();
    }
});

test('skips generation when images exist and clean is false', function () {
    // Generate initial images
    TestImageGenerator::generateTestImages(3);
    expect(TestImageGenerator::getTestImageCount())->toBe(3);
    
    // Try to generate more without cleaning
    $images = TestImageGenerator::generateTestImages(5, false);
    
    // Should return existing images, not generate new ones
    expect(TestImageGenerator::getTestImageCount())->toBe(3);
});

test('cleans and generates new images when clean is true', function () {
    // Generate initial images
    TestImageGenerator::generateTestImages(3);
    $initialImages = Storage::disk('public')->files('test-images');
    expect(count($initialImages))->toBe(3);
    
    // Generate new images with clean
    $newImages = TestImageGenerator::generateTestImages(2, true);
    
    // Should have only the new images
    expect(TestImageGenerator::getTestImageCount())->toBe(2);
    expect($newImages)->toHaveCount(2);
});

test('can get random test image', function () {
    // No images initially
    expect(TestImageGenerator::getRandomTestImage())->toBeNull();
    
    // Generate some images
    TestImageGenerator::generateTestImages(3);
    
    // Should return an image path
    $randomImage = TestImageGenerator::getRandomTestImage();
    expect($randomImage)->not->toBeNull();
    expect(str_contains($randomImage, 'test-images/'))->toBeTrue();
    expect(Storage::disk('public')->exists($randomImage))->toBeTrue();
});