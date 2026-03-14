<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'video_url',
        'video_path',
        'duration_minutes',
        'order',
        'is_free',
    ];

    protected $casts = [
        'is_free' => 'boolean',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(LessonMaterial::class)->orderBy('order');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    /**
     * Get the embed URL for video (converts YouTube watch URLs to embed format).
     */
    public function getEmbedUrlAttribute(): ?string
    {
        if (! $this->video_url) {
            return null;
        }

        // YouTube watch: https://www.youtube.com/watch?v=VIDEO_ID
        if (preg_match('/youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]+)/', $this->video_url, $m)) {
            return 'https://www.youtube.com/embed/'.$m[1];
        }

        // YouTube short: https://youtu.be/VIDEO_ID
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $this->video_url, $m)) {
            return 'https://www.youtube.com/embed/'.$m[1];
        }

        // Already embed URL
        if (str_contains($this->video_url, 'youtube.com/embed/') || str_contains($this->video_url, 'vimeo.com/')) {
            return $this->video_url;
        }

        return $this->video_url;
    }
}
