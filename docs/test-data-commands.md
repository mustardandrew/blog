# Test Data Management Commands

This document describes the available commands for managing test data in the Laravel blog application.

## Commands Overview

### 1. `app:refresh-test-data`
Refreshes all test data including database seeding and optionally test images. Automatically ensures default image exists.

**Usage:**
```bash
# Basic refresh (skips image generation if images exist)
sail artisan app:refresh-test-data

# Refresh with fresh migrations
sail artisan app:refresh-test-data --fresh

# Refresh and clean/regenerate images
sail artisan app:refresh-test-data --clean-images

# Refresh without touching images at all
sail artisan app:refresh-test-data --skip-images

# Full refresh: fresh DB + new images
sail artisan app:refresh-test-data --fresh --clean-images
```

**Options:**
- `--fresh`: Drop all tables and migrate from scratch
- `--clean-images`: Clean and regenerate test images  
- `--skip-images`: Skip image generation entirely

### 2. `app:generate-test-images`
Generates test images for blog posts.

**Usage:**
```bash
# Interactive mode - asks before overwriting
sail artisan app:generate-test-images

# Generate specific number of images
sail artisan app:generate-test-images --count=30

# Clean existing and generate new images
sail artisan app:generate-test-images --clean

# Force regeneration (alias for --clean)
sail artisan app:generate-test-images --force

# Non-interactive mode
sail artisan app:generate-test-images --no-interaction
```

**Options:**
- `--count=N`: Number of images to generate (default: 20)
- `--clean`: Clean existing images before generating new ones
- `--force`: Force regeneration of existing images (same as --clean)

### 3. `app:create-default-image`
Creates the default SVG image used for posts without featured images.

**Usage:**
```bash
# Create default image
sail artisan app:create-default-image
```

This command creates `storage/app/public/images/default-blog-post.svg` - a clean SVG placeholder that represents a generic blog post layout.

## Smart Behavior

### Default Images
- **All posts always have an image**: Posts without a featured image automatically show a default SVG placeholder
- **Automatic fallback**: The `Post::featured_image_url` accessor returns the default image path when no featured image is set
- **Consistent UI**: Templates always display an image, ensuring consistent visual layout
- **80/20 distribution**: PostFactory generates ~80% of posts with custom images, 20% rely on the default

### Image Management
- Commands automatically detect existing images
- In interactive mode, prompts user for actions
- In non-interactive mode (when called from other commands), skips generation if images exist
- Use `--clean` to force regeneration
- Default image is automatically created/verified during `app:refresh-test-data`

### Database Seeding
- All seeders use `firstOrCreate()` to avoid duplicate entries
- Safe to run multiple times without `--fresh`
- Automatically skips operations if data already exists

## Common Workflows

### Initial Setup
```bash
sail artisan app:refresh-test-data --fresh --clean-images
```

### Regular Data Refresh (preserve images)
```bash
sail artisan app:refresh-test-data --skip-images
```

### Update Images Only
```bash
sail artisan app:generate-test-images --clean --count=25
```

### Complete Reset
```bash
sail artisan app:refresh-test-data --fresh --clean-images
```

## Troubleshooting

### Command Hangs
- Ensure you're not running in interactive mode when calling from scripts
- Use `--no-interaction` flag when needed
- Use `--skip-images` if you don't need image generation

### Duplicate Entry Errors
- Use `--fresh` flag to start with clean database
- All seeders are designed to handle existing data gracefully

### Image Generation Issues
- Check storage permissions in `storage/app/public/`
- Ensure internet connection for placeholder image downloads
- Use `--clean` to remove corrupted images