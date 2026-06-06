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

    // Convert any YouTube URL format to an embeddable /embed/ URL
    public static function normalizeVideoUrl(?string $url): string
    {
        if (!$url) return '';

        // Already an embed URL
        if (str_contains($url, 'youtube.com/embed/')) return $url;

        // youtu.be/VIDEO_ID
        if (preg_match('#youtu\.be/([A-Za-z0-9_-]+)#', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        // youtube.com/watch?v=VIDEO_ID
        if (preg_match('#[?&]v=([A-Za-z0-9_-]+)#', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        return $url;
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
            'img' => $this->image_url,
            'vid' => static::normalizeVideoUrl($this->video_url),
        ];
    }
}
