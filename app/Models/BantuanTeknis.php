<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BantuanTeknis extends Model
{
    protected $table = 'bantuan_teknis';
    protected $fillable = ['judul', 'jawaban'];
}
