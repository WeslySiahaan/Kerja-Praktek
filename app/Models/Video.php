<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['name', 'description', 'rating', 'category', 'is_popular', 'video_file', 'episodes'];
    protected $casts = [
        'episodes' => 'array',
        'is_popular' => 'boolean',
    ];
}