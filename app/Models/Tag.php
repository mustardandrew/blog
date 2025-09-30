<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'usage_count' => 'integer',
        ];
    }

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'is_featured',
        'usage_count',
    ];

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Tag $tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });

        static::updating(function (Tag $tag) {
            if ($tag->isDirty('name') && empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    /**
     * Get the posts that belong to this tag.
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Scope to get only featured tags.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to get popular tags (by usage count).
     */
    public function scopePopular($query, int $limit = 10)
    {
        return $query->orderBy('usage_count', 'desc')->limit($limit);
    }

    /**
     * Scope to get tags with posts count.
     */
    public function scopeWithPostsCount($query)
    {
        return $query->withCount('posts');
    }

    /**
     * Update the usage count for this tag.
     */
    public function updateUsageCount(): void
    {
        $this->update(['usage_count' => $this->posts()->count()]);
    }

    /**
     * Find or create a tag by name.
     */
    public static function findOrCreateByName(string $name): self
    {
        $slug = Str::slug($name);

        return static::firstOrCreate(
            ['slug' => $slug],
            [
                'name' => $name,
                'slug' => $slug,
            ]
        );
    }

    /**
     * Get the most used tags.
     */
    public static function mostUsed(int $limit = 10)
    {
        return static::popular($limit)->get();
    }

    /**
     * Sync usage counts for all tags.
     */
    public static function syncAllUsageCounts(): void
    {
        static::chunk(100, function ($tags) {
            foreach ($tags as $tag) {
                $tag->updateUsageCount();
            }
        });
    }
}
