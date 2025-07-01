<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaranMasukan extends Model
{
    protected $table = 'saran_masukan';
    protected $fillable = ['nama', 'email', 'pesan'];
}
