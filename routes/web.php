<?php

use App\Http\Controllers\UpcomingController;
use App\Http\Controllers\PopularController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\KoleksiController;


// Route untuk halaman utama
Route::get('/', [HomeController::class, 'index4'])->name('dramabox.beranda');
Route::get('/beranda', [HomeController::class, 'index4']);
Route::get('/video/detail/{id}', [VideoController::class, 'detail'])->name('dramabox.detail');
Route::get('/browse', [HomeController::class, 'index5'])->name('dramabox.browse');



// Route untuk dashboard pengguna
Route::get('/dashboard',[HomeController::class, 'index1'])->middleware(['auth', 'verified'])->name('dashboard');

// Grup route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Routes untuk profil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/pertanyaanUmum', [ProfileController::class, 'pertanyaanUmum'])->name('profile.pertanyaanUmum');
    Route::get('/profile/layananPelanggan', [ProfileController::class, 'layananPelanggan'])->name('profile.layananPelanggan');
    Route::get('/profile/hubungi', [ProfileController::class, 'hubungi'])->name('profile.hubungi');
    Route::get('/profile/pengaturan', [ProfileController::class, 'pengaturan'])->name('profile.pengaturan');
    Route::get('profile/persetujuan', [ProfileController::class, 'persetujuan'])->name('profile.persetujuan');
    Route::get('profile/kebijakan', [ProfileController::class, 'kebijakan'])->name('profile.kebijakan');
    Route::get('profile/nonaktifAkun', [ProfileController::class, 'nonaktifAkun'])->name('profile.nonaktifAkun');
    Route::get('/profile/riwayat-tontonan', [ProfileController::class, 'riwayatTontonan'])->name('profile.riwayatTontonan');


    // Route untuk logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Routes untuk video
    Route::get('/videos/new', [VideoController::class, 'index'])->name('videos.index');
    Route::get('/videos/create', [VideoController::class, 'create'])->name('videos.create');
    Route::post('/videos/create', [VideoController::class, 'store'])->name('videos.store');
    Route::get('/videos/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
    Route::put('/videos/{video}', [VideoController::class, 'update'])->name('videos.update');
    Route::delete('/videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');

    Route::post('/videos/{video}/like', [VideoController::class, 'like'])->name('videos.like')->middleware('auth');
    Route::post('/videos/{video}/save', [VideoController::class, 'save'])->name('videos.save')->middleware('auth');

    Route::get('/users/dashboard', [HomeController::class, 'dashboard'])->middleware('auth')->name('users.dashboard');
    Route::get('/users/browse', [HomeController::class, 'browse'])->middleware('auth')->name('users.browse');
    Route::get('/users/koleksi', [KoleksiController::class, 'index'])->middleware('auth')->name('users.koleksi');
    Route::delete('/collections/destroy-multiple', [KoleksiController::class, 'destroyMultiple'])->name('collections.destroy_multiple');
    Route::get('/users/rekomendasi', [HomeController::class, 'rekomendasi'])->middleware('auth')->name('users.rekomendasi');
    Route::get('/users/search', [HomeController::class, 'search'])->middleware('auth')->name('users.search');
    Route::get('/users/video/detail/{id}', [HomeController::class, 'detail1'])->name('video.detail');


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
Route::get('/category', [PopularController::class, 'search'])->name('dramabox.search1');

// Route untuk admin dashboard
Route::get('/admin/dashboard', [VideoController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth');






Route::get('/rekomendasi', function () {
    return view('dramabox.rekomendasi');
})->name('dramabox.rekomendasi');

//Route::get('/app', function () {
  //  return view('dramabox.koleksi');
//})->name('dramabox.koleksi');


// Impor route autentikasi default Laravel
require __DIR__ . '/auth.php';

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
Route::get('/storage/profiles/{filename}', [ImageController::class, 'showProfileImage'])->name('profile.image');
Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
