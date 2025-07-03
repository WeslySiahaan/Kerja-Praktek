<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = ['name', 'description', 'rating', 'category', 'poster_image', 'details', 'episodes'];

    protected $casts = [
        'category' => 'array', 
        'episodes' => 'array', 
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class, 'recommendation_id');
    }
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'recommendation_user_likes', 'recommendation_id', 'user_id');
    }

    // Relasi many-to-many dengan Users untuk save (opsional, jika diperlukan)

    public function collectedByUsers()
{
    return $this->belongsToMany(User::class, 'recommendation_user')
                ->withTimestamps();
}

}