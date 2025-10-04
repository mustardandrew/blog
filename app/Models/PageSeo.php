<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSeo extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'title',
        'meta_description',
        'keywords',
        'noindex',
        'nofollow',
        'additional_meta',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'noindex' => 'boolean',
            'nofollow' => 'boolean',
            'additional_meta' => 'array',
        ];
    }

    /**
     * Отримати SEO дані для конкретного ключа сторінки
     */
    public static function getByKey(string $key): ?self
    {
        return static::where('key', $key)->first();
    }

    /**
     * Отримати robots META контент
     */
    public function getRobotsAttribute(): string
    {
        $robots = [];

        if ($this->noindex) {
            $robots[] = 'noindex';
        } else {
            $robots[] = 'index';
        }

        if ($this->nofollow) {
            $robots[] = 'nofollow';
        } else {
            $robots[] = 'follow';
        }

        return implode(', ', $robots);
    }

    /**
     * Перетворити ключові слова в масив
     */
    public function getKeywordsArrayAttribute(): array
    {
        if (empty($this->keywords)) {
            return [];
        }

        return array_map('trim', explode(',', $this->keywords));
    }
}
