<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upcoming extends Model
{
    protected $fillable = ['title', 'description', 'release_date', 'category', 'poster', 'trailer'];

    protected $casts = [
      'release_date' => 'date',
  ];
}