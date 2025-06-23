<?php
// app/Models/Popular.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Popular extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'category', 'poster', 'trailer', 'description'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'categories' => 'array', // Cast categories sebagai array untuk mendukung JSON
    ];

    /**
     * Get the URL for the poster.
     *
     * @return string|null
     */
    public function getPosterUrlAttribute()
    {
        return $this->poster ? Storage::url($this->poster) : null;
    }

    /**
     * Get the URL for the trailer.
     *
     * @return string|null
     */
    public function getTrailerUrlAttribute()
    {
        return $this->trailer ? Storage::url($this->trailer) : null;
    }
}
?>