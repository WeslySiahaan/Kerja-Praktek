<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['name', 'description', 'rating', 'category', 'is_popular', 'poster_image', 'episodes'];

    protected $casts = [
        'episodes' => 'array',
        'is_popular' => 'boolean',
    ];

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_video_likes')->withTimestamps();
    }

    // Relasi untuk pengguna yang menyimpan video ke koleksi
    public function collectedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_video_collections')->withTimestamps();
    }
}