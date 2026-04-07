<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'youtube_id',
        'thumbnail_url',
        'views',
        'is_featured',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Video $video) {
            if (blank($video->slug)) {
                $video->slug = static::generateUniqueSlug($video->title);
            }
        });

        static::updating(function (Video $video) {
            if (blank($video->slug)) {
                $video->slug = static::generateUniqueSlug($video->title, $video->id);
            }
        });

        static::saving(function (Video $video) {
            $video->youtube_id = static::normalizeYoutubeId($video->youtube_id) ?? $video->youtube_id;

            if (filled($video->youtube_id)) {
                $video->thumbnail_url = static::thumbnailUrlFor($video->youtube_id);
            }
        });

        static::saved(function (Video $video) {
            if ($video->is_featured) {
                static::query()
                    ->whereKeyNot($video->id)
                    ->where('is_featured', true)
                    ->update(['is_featured' => false]);
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Automatically extract the YouTube ID whether the database contains
     * a full URL, a short URL, or just the ID itself.
     */
    protected function youtubeId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => static::normalizeYoutubeId($value) ?? $value,
            set: fn ($value) => static::normalizeYoutubeId($value) ?? $value,
        );
    }

    public static function normalizeYoutubeId(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $value = trim($value);

        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $value) === 1) {
            return $value;
        }

        preg_match(
            '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=|shorts/)|youtu\.be/)([^"&?/\s]{11})%i',
            $value,
            $match
        );

        return $match[1] ?? null;
    }

    public static function thumbnailUrlFor(string $youtubeId): string
    {
        return "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg";
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'video';
        $slug = $baseSlug;
        $suffix = 2;

        while (static::slugExists($slug, $ignoreId)) {
            $slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    protected static function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        return static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists();
    }
}
