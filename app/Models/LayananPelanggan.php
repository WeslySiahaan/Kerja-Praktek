<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananPelanggan extends Model
{
    protected $table = 'layanan_pelanggan'; // pastikan sesuai nama tabel di database

    protected $fillable = [
        'kontak',
        'pertanyaan',
        'bantuan',
    ];

    public $timestamps = true; // atau false jika tidak ada kolom created_at dan updated_at
}
