<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WatchHistory;

class Video extends Model
{
    protected $fillable = ['name', 'description', 'rating', 'category', 'is_popular', 'poster_image', 'episodes'];

    protected $casts = [
        'episodes' => 'array',
        'is_popular' => 'boolean',
    ];

    /**
     * Get the users who liked this video.
     */
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_video_likes')->withTimestamps();
    }

    /**
     * Get the users who collected this video.
     */
    public function collectedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_video_collections')->withTimestamps();
    }

    /**
     * Get the number of likes for the video.
     */
    public function getLikeCountAttribute()
    {
        return $this->likedByUsers()->count();
    }

    /**
     * Get the number of collections (saves) for the video.
     */
    public function getCollectionCountAttribute()
    {
        return $this->collectedByUsers()->count();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function watchHistories()
    {
        return $this->hasMany(WatchHistory::class);
    }
}