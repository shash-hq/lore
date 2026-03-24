<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute; // Yeh naya import add kiya hai
use Illuminate\Support\Str;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($video) {
            if (empty($video->slug)) {
                $video->slug = Str::slug($video->title);
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
            get: function ($value) {
                if (!$value) return null;

                // Agar pehle se hi sirf 11 character ka ID hai, toh wahi return kardo
                if (strlen($value) === 11) {
                    return $value;
                }

                // Agar URL hai, toh Regex use karke usme se ID extract karlo
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $value, $match);

                return $match[1] ?? $value;
            }
        );
    }
}
