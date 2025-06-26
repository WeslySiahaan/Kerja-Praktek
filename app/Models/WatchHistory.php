<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_id',
        'title',
        'category',
        'description',
        'image',
        'progress',
         'watched_seconds',
        'watched_time',
    ];

    /**
     * Dapatkan user yang memiliki riwayat tontonan ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Dapatkan video yang terkait dengan riwayat tontonan ini.
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}