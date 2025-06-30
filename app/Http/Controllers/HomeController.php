<?php
namespace App\Http\Controllers;

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

    public function index1()
    {
        $upcomings = Upcoming::all(); // Fetch all upcoming releases for "Up Coming"
        $videos = Video::latest()->paginate(12); 
        $populars = Popular::all();
        return view('users.dashboard', compact('upcomings', 'videos', 'populars'));
    }

    public function dashboard()
    {
        $upcomings = Upcoming::all(); // Fetch all upcoming releases for "Up Coming"
        $videos = Video::latest()->paginate(12); 
        $populars = Popular::all();
        return view('users.dashboard', compact('upcomings', 'videos', 'populars'));
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

    public function detail($id): View
    {
      $videos = Video::findOrFail($id);
      return view('dramabox.detail', compact('videos'));
    }
    
    public function detail1($id): View
    {
      $video = Video::findOrFail($id);
      return view('users.detail', compact('video'));
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
            $videos->where('category', $category);
        }
        // Gunakan paginate() dan appends()
        $videos = $videos->latest()->paginate($perPage)->appends(request()->query());

        // --- Filter untuk Model Upcoming ---
        $upcomings = Upcoming::query();
        if ($query) {
            $upcomings->where('title', 'like', '%' . $query . '%');
        }
        if ($category && $category !== 'all') {
            // PASTIKAN nama kolom di tabel 'upcomings' adalah 'category'
            $upcomings->where('category', $category);
        }
        // Gunakan paginate() dan appends()
        $upcomings = $upcomings->latest()->paginate($perPage)->appends(request()->query());


        // --- Filter untuk Model Popular ---
        $populars = Popular::query();
        if ($query) {
            $populars->where('title', 'like', '%' . $query . '%');
        }
        if ($category && $category !== 'all') {
            // PASTIKAN nama kolom di tabel 'populars' adalah 'category'
            $populars->where('category', $category);
        }
        // Gunakan paginate() dan appends()
        $populars = $populars->latest()->paginate($perPage)->appends(request()->query());


        // --- Daftar Kategori ---
        $allCategories = [
            "Sudden Wealth", "Werewolves", "Popular", "Average", "Divine Tycoon", "Love Triangle", "Revenge", "Paranormal",
            "Marriage", "Cinderella", "Underdog Rise", "Son-in-Law", "Secret Identity", "Second-chance Love", "Comedy", "Boy's Love",
            "Marriage Before Love", "Mafia", "Influencer", "Forbidden Love", "Uplifting Series", "Strong Female Lead", "Romance", "CEO",
            "Harem", "Fantasy", "Information Gaps", "Soulmate", "Trending", "Concealed Identity", "Counterattack", "Disguise",
            "Sweet Love", "Suspense", "Betrayal", "Urban", "Cross-dressing", "Time Travel Harem", "Werewolf",
            "SM", "Enemies to Lovers", "Mystery", "Super Power", "Billionaire", "Hated", "Dominant", "Alternative History",
            "Badboy", "Rebirth", "Small Potato", "Contract Lover", "Wealthy", "Humor", "Misunderstanding", "True Love",
            "Comeback", "Toxic Relationship", "Contract Marriage", "Family", "Time Travel", "Bitter Love", "Steamy", "Destiny",
        ];

        if (!in_array('all', $allCategories)) {
            $allCategories[] = 'all';
        }

        return view('users.browse', compact('videos', 'upcomings', 'populars', 'allCategories', 'category'));
    }
    
}
