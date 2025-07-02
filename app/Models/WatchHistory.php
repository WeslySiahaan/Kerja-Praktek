<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Perbaiki dari 'Eloquent\Eloquent\Model' menjadi 'Eloquent\Model'

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'category' => 'array', // <--- TAMBAHKAN BARIS PENTING INI
        'progress' => 'integer',
        'watched_seconds' => 'integer',
        // Tambahkan casting lain jika diperlukan, misal untuk watched_time jika mau diolah khusus
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