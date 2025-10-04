<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Check if a user has bookmarked a specific post
     */
    public static function isBookmarked(int $userId, int $postId): bool
    {
        return static::where('user_id', $userId)
            ->where('post_id', $postId)
            ->exists();
    }

    /**
     * Toggle bookmark for a user and post
     */
    public static function toggle(int $userId, int $postId): array
    {
        $bookmark = self::where('user_id', $userId)
            ->where('post_id', $postId)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return [
                'bookmarked' => false,
                'message' => 'Закладку видалено'
            ];
        }

        self::create([
            'user_id' => $userId,
            'post_id' => $postId,
        ]);

        return [
            'bookmarked' => true,
            'message' => 'Додано до закладок'
        ];
    }
}
