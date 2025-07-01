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
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\WatchHistoryController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\RecommendationLandingController;
use App\Http\Controllers\PersetujuanPenggunaController;
use App\Http\Controllers\LayananPelangganController;


// Route untuk halaman utama
Route::get('/', [HomeController::class, 'index4'])->name('dramabox.beranda');
Route::get('/beranda', [HomeController::class, 'index4']);
Route::get('/video/detail/{id}', [VideoController::class, 'detail1'])->name('dramabox.detail');
Route::get('/browse', [HomeController::class, 'index5'])->name('dramabox.browse');
// Route untuk dashboard pengguna
Route::get('/dashboard', [HomeController::class, 'index1'])->middleware(['auth', 'verified'])->name('dashboard');

// Grup route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
  // Routes untuk profil
  Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');
  Route::get('/profile/pertanyaanUmum', [ProfileController::class, 'pertanyaanUmum'])->name('profile.pertanyaanUmum');
  Route::get('/profile/layananPelanggan', [LayananPelangganController::class, 'index'])->name('profile.layananPelanggan');
  Route::get('/profile/pengaturan', [ProfileController::class, 'pengaturan'])->name('profile.pengaturan');
  Route::get('/profile/persetujuan', [ProfileController::class, 'persetujuan'])->name('profile.persetujuan');
  Route::get('/profile/kebijakan', [ProfileController::class, 'kebijakan'])->name('profile.kebijakan');

  Route::get('/privacy-policies', [PrivacyPolicyController::class, 'index'])->name('privacy_policies.index');
  Route::post('/privacy-policies', [PrivacyPolicyController::class, 'store'])->name('privacy_policies.store');
  Route::get('/privacy-policies/{id}/edit', [PrivacyPolicyController::class, 'edit'])->name('privacy_policies.edit');
  Route::put('/privacy-policies/{id}', [PrivacyPolicyController::class, 'update'])->name('privacy_policies.update');
  Route::delete('/privacy-policies/{id}', [PrivacyPolicyController::class, 'destroy'])->name('privacy_policies.destroy');

  Route::get('/admin/layanan-pelanggan', [LayananPelangganController::class, 'edit'])->name('layanan_pelanggan.edit');
  Route::put('/admin/layanan-pelanggan/{id}', [LayananPelangganController::class, 'update'])->name('layanan_pelanggan.update');

  Route::get('profile/nonaktifAkun', [ProfileController::class, 'nonaktifAkun'])->name('profile.nonaktifAkun');
  Route::get('/profile/riwayat-tontonan', [ProfileController::class, 'riwayatTontonan'])->name('profile.riwayatTontonan');
  Route::get('/profile/riwayat-tontonan', [WatchHistoryController::class, 'index'])->name('profile.riwayatTontonan');
  Route::delete('/profile/riwayat-tontonan/{watchHistory}', [WatchHistoryController::class, 'destroy'])->name('profile.riwayatTontonan.destroy');
  Route::post('/profile/riwayat-tontonan/clear-all', [WatchHistoryController::class, 'clearAll'])->name('profile.riwayatTontonan.clearAll');

  // Tidak pakai middleware admin jika tidak perlu
  Route::get('/admin/pertanyaan-umum/edit', [FaqController::class, 'editAll'])->name('faq.editAll');
  Route::put('/admin/pertanyaan-umum/update', [FaqController::class, 'updateAll'])->name('faq.updateAll');
  Route::get('/admin/pertanyaan-umum/edit', [FaqController::class, 'editAll'])->name('faq.editAll');
  Route::get('/admin/pertanyaan-umum/create', [FaqController::class, 'create'])->name('faq.create');
  Route::post('/admin/pertanyaan-umum/store', [FaqController::class, 'store'])->name('faq.store');
  Route::get('/profil/faq', [FaqController::class, 'showToUser'])->name('user.faq');


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
  Route::get('/users/recommendations', [RecommendationController::class, 'index'])->name('users.rekomendasi')->middleware('auth');
  Route::get('/users/search', [HomeController::class, 'search'])->middleware('auth')->name('users.search');
  Route::get('/users/video/detail/{id}', [HomeController::class, 'detail1'])->name('video.detail');

  Route::post('/videos/{video}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
  Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
  Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update')->middleware('auth');
  Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');



  // Routes untuk akan tayang
  Route::get('/upcomings', [UpcomingController::class, 'index'])->name('upcomings.index');
  Route::get('/upcomings/create', [UpcomingController::class, 'create'])->name('upcomings.create');
  Route::post('/upcomings', [UpcomingController::class, 'store'])->name('upcomings.store');
  Route::get('/upcomings/{upcoming}/edit', [UpcomingController::class, 'edit'])->name('upcomings.edit');
  Route::put('/upcomings/{upcoming}', [UpcomingController::class, 'update'])->name('upcomings.update');
  Route::delete('/upcomings/{upcoming}', [UpcomingController::class, 'destroy'])->name('upcomings.destroy');

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
  Route::get('/users/recommendations', [RecommendationController::class, 'index'])->name('users.rekomendasi')->middleware('auth');
  Route::get('/users/search', [HomeController::class, 'search'])->middleware('auth')->name('users.search');
  Route::get('/users/video/detail/{id}', [HomeController::class, 'detail1'])->name('video.detail');

  Route::post('/videos/{video}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
  Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
  Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update')->middleware('auth');
  Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


  Route::get('recommendations', [RecommendationLandingController::class, 'index'])->name('recommendations.index');
  Route::get('recommendations/create', [RecommendationLandingController::class, 'create'])->name('recommendations.create');
  Route::post('recommendations', [RecommendationLandingController::class, 'store'])->name('recommendations.store');
  Route::get('recommendations/{recommendation}/edit', [RecommendationLandingController::class, 'edit'])->name('recommendations.edit');
  Route::put('recommendations/{recommendation}', [RecommendationLandingController::class, 'update'])->name('recommendations.update');
  Route::delete('recommendations/{recommendation}', [RecommendationLandingController::class, 'destroy'])->name('recommendations.destroy');
  Route::get('recommendations/search', [RecommendationLandingController::class, 'search'])->name('recommendations.search');

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
  Route::get('/populars', [PopularController::class, 'index'])->name('populars.index');
  Route::get('/populars/create', [PopularController::class, 'create'])->name('populars.create');
  Route::post('/populars', [PopularController::class, 'store'])->name('populars.store');
  Route::get('/populars/{popular}/edit', [PopularController::class, 'edit'])->name('populars.edit');
  Route::put('/populars/{popular}', [PopularController::class, 'update'])->name('populars.update');
  Route::delete('/populars/{popular}', [PopularController::class, 'destroy'])->name('populars.destroy');
});

Route::get('/search', [VideoController::class, 'search'])->name('dramabox.search');
Route::get('/category', [PopularController::class, 'search'])->name('dramabox.search1');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth');


Route::get('/rekomendasi', [HomeController::class, 'rekomendasi1'])->name('dramabox.rekomendasi');



//Route::get('/app', function () {
//  return view('dramabox.koleksi');
//})->name('dramabox.koleksi');


// Impor route autentikasi default Laravel
require __DIR__ . '/auth.php';

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
Route::get('/storage/profiles/{filename}', [ImageController::class, 'showProfileImage'])->name('profile.image');
Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');


// Persetujuan Pengguna//
Route::get('/user-agreements', [PersetujuanPenggunaController::class, 'index'])->name('user_agreements.index');
Route::post('/user-agreements', [PersetujuanPenggunaController::class, 'store'])->name('user_agreements.store');
Route::get('/user-agreements/{id}/edit', [PersetujuanPenggunaController::class, 'edit'])->name('user_agreements.edit');
Route::put('/user-agreements/{id}', [PersetujuanPenggunaController::class, 'update'])->name('user_agreements.update');
Route::delete('/user-agreements/{id}', [PersetujuanPenggunaController::class, 'destroy'])->name('user_agreements.destroy');
