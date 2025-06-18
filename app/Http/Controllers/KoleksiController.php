<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
// Kita tidak perlu lagi use Auth di sini

class KoleksiController extends Controller
{
    /**
     * Menampilkan halaman koleksi.
     */
    public function index(): View
    {
        // Karena halaman ini sekarang publik, kita selalu tampilkan view koleksi.
        // Logika untuk menampilkan/menyembunyikan tombol EDIT, dll. 
        // sudah ada di dalam file koleksi.blade.php menggunakan @auth.
        return view('dramabox.koleksi');
    }
}