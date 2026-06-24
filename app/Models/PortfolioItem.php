<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    protected $fillable = [
        'parent_category','sub_category','title','size',
        'image_url','image_path','video_url','description',
        'is_active','sort_order',
    ];
    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }

    // Extract the raw YouTube video ID from any URL format
    public static function extractYoutubeId(?string $url): ?string
    {
        if (!$url) return null;

        // Add protocol if missing so regex patterns work
        if (!preg_match('#^https?://#i', $url)) {
            $url = 'https://' . ltrim($url, '/');
        }

        $patterns = [
            // Short link: youtu.be/ID or youtu.be/ID?t=30
            '#youtu\.be/([A-Za-z0-9_-]{11})#i',
            // Standard watch: youtube.com/watch?v=ID
            '#[?&]v=([A-Za-z0-9_-]{11})#i',
            // Embed: youtube.com/embed/ID
            '#youtube(?:-nocookie)?\.com/embed/([A-Za-z0-9_-]{11})#i',
            // Shorts: youtube.com/shorts/ID
            '#youtube\.com/shorts/([A-Za-z0-9_-]{11})#i',
            // Live: youtube.com/live/ID
            '#youtube\.com/live/([A-Za-z0-9_-]{11})#i',
            // Old /v/ format: youtube.com/v/ID
            '#youtube\.com/v/([A-Za-z0-9_-]{11})#i',
            // Mobile: m.youtube.com/watch?v=ID (covered by [?&]v= above)
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $m)) {
                return $m[1];
            }
        }

        return null;
    }

    // Convert any YouTube URL format to a clean embeddable URL
    public static function normalizeVideoUrl(?string $url): string
    {
        if (!$url) return '';

        $id = static::extractYoutubeId($url);
        if ($id) {
            return 'https://www.youtube.com/embed/' . $id;
        }

        return $url;
    }

    // Returns image_url if set, otherwise falls back to YouTube thumbnail
    public function imageUrl(): string
    {
        if ($this->image_url) return $this->image_url;

        $id = static::extractYoutubeId($this->video_url);
        if ($id) {
            return 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
        }

        return '';
    }

    // Map to the shape expected by the frontend JS
    public function toFrontend(): array
    {
        return [
            'id'  => $this->id,
            'p'   => $this->parent_category,
            's'   => $this->sub_category,
            't'   => $this->title,
            'sz'  => $this->size,
            'img' => $this->imageUrl(),
            'vid' => static::normalizeVideoUrl($this->video_url),
        ];
    }
}
