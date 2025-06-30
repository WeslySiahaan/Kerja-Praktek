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
}