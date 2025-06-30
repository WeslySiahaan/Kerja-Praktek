<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAgreement extends Model
{
    protected $fillable = [
        'ketentuan_umum','hak_kekayaan_intelektual', 'akun_pengguna','pembatasan_tanggung_jawab','penghentian_layanan', 'kontak',
    ];
}