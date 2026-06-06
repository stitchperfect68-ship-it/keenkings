<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'body',
        'featured_image_url', 'featured_image_path',
        'author', 'category',
        'is_published', 'published_at', 'sort_order',
    ];

    protected $casts = [
        'is_published'  => 'boolean',
        'published_at'  => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->orderBy('published_at', 'desc');
    }

    public static function generateSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $n = 2;
        while (
            static::where('slug', $slug)
                  ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                  ->exists()
        ) {
            $slug = $original . '-' . $n++;
        }
        return $slug;
    }

    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->body));
        return (int) max(1, round($words / 200));
    }
}
