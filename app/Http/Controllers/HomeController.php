<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Video;
use App\Models\Upcoming;
use App\Models\Popular;
use App\Models\Recommendation;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    private function getPaginatedVideos($perPage = 12)
    {
      $videos = Video::latest()->paginate($perPage);
      return $videos;
    }
    
    private function getPaginatedRecommendations($perPage = 12)
    {
      $recommendations = Recommendation::latest()->paginate($perPage);
      return $recommendations;
    }


    public function dashboard()
    {
      $upcomings = Upcoming::all();
      $populars = Popular::all();
      $videos = $this->getPaginatedVideos(12);
      $recommendations = $this->getPaginatedRecommendations(12);
    
      return view('users.dashboard', compact('upcomings', 'populars', 'videos', 'recommendations'));
    }
    


    public function index1()
    {
      $upcomings = Upcoming::all();
      $populars = Popular::all();
      $videos = $this->getPaginatedVideos(12);
      $recommendations = $this->getPaginatedRecommendations(12);
    
      return view('users.dashboard', compact('upcomings', 'populars', 'videos', 'recommendations'));
    }
    


    public function koleksi(){
        return view('users.Koleksi');
    }

    public function rekomendasi(){
        return view('users.rekomendasi');
    }

    public function rekomendasi1()
{
    // Ambil semua rekomendasi dari model Recommendation
    $recommendedVideos = Recommendation::all();

    // Kirim ke view dengan nama variabel sesuai blade
    return view('dramabox.rekomendasi', compact('recommendedVideos'));
}


    public function browse(){
        $upcomings = Upcoming::all(); // Fetch all upcoming releases for "Up Coming"
        $videos = Video::latest()->paginate(12);  // Fetch latest 6 videos for "Video Terbaru"
        $populars = Popular::all();
        return view('users.browse', compact('upcomings', 'videos', 'populars'));
    }


    public function index4()
    {
        $perPageDefault = 10; // Jumlah item default per halaman
    
        // Upcoming releases, dipaginasi dengan nama parameter 'upcomings_page'
        $upcomings = Upcoming::latest()->paginate($perPageDefault, ['*'], 'upcomings_page'); 
        
        // Video terbaru, dipaginasi 6 item per halaman dengan nama parameter 'videos_page'
        $videos = Video::latest()->paginate(12, ['*'], 'videos_page'); 
        
        // Popular, dipaginasi dengan nama parameter 'populars_page'
        $populars = Popular::latest()->paginate($perPageDefault, ['*'], 'populars_page');
        
        return view('welcome', compact('upcomings', 'videos', 'populars'));
    }
    public function index5()
    {
        $upcomings = Upcoming::all(); // Fetch all upcoming releases for "Up Coming"
        $videos = Video::latest()->paginate(12); // Fetch latest 6 videos for "Video Terbaru"
        $populars = Popular::all();
        return view('dramabox.browse', compact('upcomings', 'videos', 'populars'));
    }
    
    public function detail1($id): View
    {
        // Ambil video yang sedang ditonton dengan relasi
        $video = Video::with(['likedByUsers', 'collectedByUsers', 'comments' => function ($query) {
            $query->with('user')->latest();
        }])->findOrFail($id);

        // Debugging
        Log::info('Video loaded: ' . $video->id . ', Category: ' . json_encode($video->category));

        // Ambil kategori dari video yang sedang ditonton
        $categories = is_array($video->category) ? $video->category : (json_decode($video->category, true) ?? []);

        // Ambil video rekomendasi berdasarkan kategori yang sama
        $recommendedVideos = Video::query()
            ->where('id', '!=', $video->id) // Kecualikan video yang sedang ditonton
            ->when(!empty($categories), function ($query) use ($categories) {
                $query->where(function ($q) use ($categories) {
                    foreach ($categories as $category) {
                        $q->orWhereJsonContains('category', $category)
                          ->orWhere('category', 'like', '%' . $category . '%');
                    }
                });
            }, function ($query) {
                // Fallback ke video populer jika tidak ada kategori
                $query->where('is_popular', true);
            })
            ->orderBy('rating', 'desc')
            ->take(6) // Batasi 6 video untuk rekomendasi
            ->get();

        // Inisialisasi variabel untuk pengguna
        $isLiked = false;
        $isCollected = false;
        $watchHistory = null;

        if (Auth::check()) {
            $user = Auth::user();
            $isLiked = $video->likedByUsers()->where('user_id', $user->id)->exists();
            $isCollected = $video->collectedByUsers()->where('user_id', $user->id)->exists();

            // Kelola riwayat tontonan
            $watchHistory = WatchHistory::firstOrNew([
                'user_id' => $user->id,
                'video_id' => $video->id,
            ]);

            if (!$watchHistory->exists) {
                $watchHistory->title = $video->name;
                $watchHistory->category = $video->category;
                $watchHistory->description = $video->description;
                $watchHistory->image = $video->poster_image ? Storage::url($video->poster_image) : 'https://placehold.co/80x120/cccccc/ffffff?text=No+Image';
                $watchHistory->watched_seconds = 0;
                $watchHistory->progress = 0;
            }

            $totalDuration = $video->duration ?? 0;
            if ($totalDuration > 0) {
                $watchHistory->progress = min(100, round(($watchHistory->watched_seconds / $totalDuration) * 100));
            } else {
                $watchHistory->progress = 0;
            }

            $watchedTimeFormatted = gmdate("H:i:s", $watchHistory->watched_seconds);
            $totalDurationFormatted = gmdate("H:i:s", $totalDuration);
            $watchHistory->watched_time = $watchedTimeFormatted . ' / ' . $totalDurationFormatted;

            $watchHistory->save();
        }

        return view('users.detail', compact('video', 'recommendedVideos', 'isLiked', 'isCollected', 'watchHistory'));
    }
    public function search(Request $request)
{
    $query = $request->input('query');
    $category = $request->input('category');
    $perPage = 15; // Jumlah item per halaman, bisa Anda sesuaikan

    // --- Filter untuk Model Video ---
    $videos = Video::query();
    if ($query) {
        $videos->where('name', 'like', '%' . $query . '%');
    }
    if ($category && $category !== 'all') {
        $videos->whereJsonContains('category', $category); // Filter untuk array JSON di Video
    }
    $videos = $videos->latest()->paginate($perPage)->appends(request()->query());

    // --- Filter untuk Model Upcoming ---
    $upcomings = Upcoming::query();
    if ($query) {
        $upcomings->where('title', 'like', '%' . $query . '%');
    }
    if ($category && $category !== 'all') {
        // Asumsi Upcoming menggunakan string untuk category, gunakan like jika bukan array
        $upcomings->where('category', 'like', '%' . $category . '%');
    }
    $upcomings = $upcomings->latest()->paginate($perPage)->appends(request()->query());

    // --- Filter untuk Model Popular ---
    $populars = Popular::query();
    if ($query) {
        $populars->where('title', 'like', '%' . $query . '%');
    }
    if ($category && $category !== 'all') {
        // Asumsi Popular menggunakan string untuk category, gunakan like jika bukan array
        $populars->where('category', 'like', '%' . $category . '%');
    }
    $populars = $populars->latest()->paginate($perPage)->appends(request()->query());

    // --- Daftar Kategori ---
    $allCategories = [
        "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
        "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
        "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
        "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
        "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu", "Manusia Serigala",
        "Dominasi & Submisi", "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif",
        "Anak Nakal", "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
        "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
    ];

    // Pastikan 'all' ada di daftar kategori untuk opsi filter
    if (!in_array('all', $allCategories)) {
        $allCategories[] = 'all';
    }

    // --- Mengirim Data ke View ---
    return view('users.browse', compact('videos', 'upcomings', 'populars', 'allCategories', 'category', 'query'));
}
    
}
