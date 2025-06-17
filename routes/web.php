<?php

use App\Http\Controllers\UpcomingController;
use App\Http\Controllers\PopularController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;


// Route untuk halaman utama
Route::get('/', [HomeController::class, 'index4'])->name('dramabox.beranda');
Route::get('/beranda', [HomeController::class, 'index4']);
Route::get('/video/detail/{id}', [VideoController::class, 'detail'])->name('dramabox.detail');


// Route untuk dashboard pengguna
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Routes untuk profil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/pertanyaanUmum', [ProfileController::class, 'pertanyaanUmum'])->name('profile.pertanyaanUmum');
    Route::get('/profile/layananPelanggan', [ProfileController::class, 'layananPelanggan'])->name('profile.layananPelanggan');
    Route::get('/profile/hubungi', [ProfileController::class, 'hubungi'])->name('profile.hubungi');


    // Route untuk logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Routes untuk video
    Route::get('/videos/new', [VideoController::class, 'index'])->name('videos.index');
    Route::get('/videos/create', [VideoController::class, 'create'])->name('videos.create');
    Route::post('/videos/create', [VideoController::class, 'store'])->name('videos.store');
    Route::get('/videos/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
    Route::put('/videos/{video}', [VideoController::class, 'update'])->name('videos.update');
    Route::delete('/videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');


    // Routes untuk akan tayang
    Route::get('/upcomings', [UpcomingController::class, 'index'])->name('upcomings.index');
    Route::get('/upcomings/create', [UpcomingController::class, 'create'])->name('upcomings.create');
    Route::post('/upcomings', [UpcomingController::class, 'store'])->name('upcomings.store');
    Route::get('/upcomings/{upcoming}/edit', [UpcomingController::class, 'edit'])->name('upcomings.edit');
    Route::put('/upcomings/{upcoming}', [UpcomingController::class, 'update'])->name('upcomings.update');
    Route::delete('/upcomings/{upcoming}', [UpcomingController::class, 'destroy'])->name('upcomings.destroy');

    Route::get('/populars', [PopularController::class, 'index'])->name('populars.index');
    Route::get('/populars/create', [PopularController::class, 'create'])->name('populars.create');
    Route::post('/populars', [PopularController::class, 'store'])->name('populars.store');
    Route::get('/populars/{popular}/edit', [PopularController::class, 'edit'])->name('populars.edit');
    Route::put('/populars/{popular}', [PopularController::class, 'update'])->name('populars.update');
    Route::delete('/populars/{popular}', [PopularController::class, 'destroy'])->name('populars.destroy');
});

Route::get('/search', [VideoController::class, 'search'])->name('dramabox.search');

// Route untuk admin dashboard
Route::get('/admin/dashboard', [HomeController::class, 'index'])->middleware('auth')->name('admin.dashboard');

// Route untuk dashboard pengguna
Route::get('/users/dashboard', [HomeController::class, 'index'])->middleware('auth')->name('users.dashboard');




Route::get('/browse', function () {
    return view('dramabox.browse');
})->name('dramabox.browse');
Route::get('/rekomendasi', function () {
    return view('dramabox.rekomendasi');
})->name('dramabox.rekomendasi');
Route::get('/app', function () {
    return view('dramabox.koleksi');
})->name('dramabox.koleksi');


// Impor route autentikasi default Laravel
require __DIR__ . '/auth.php';

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
Route::get('/storage/profiles/{filename}', [ImageController::class, 'showProfileImage'])->name('profile.image');