<?php
// app/Http/Controllers/PopularController.php
namespace App\Http\Controllers;

use App\Models\Popular;
use App\Models\video;
use App\Models\upcoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PopularController extends Controller
{
    public function index()
    {
        $populars = Popular::all();
        return view('dramabox.popular.index', compact('populars'));
    }

    public function create()
    {
        return view('dramabox.popular.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|array',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'trailer' => 'required|mimes:mp4|max:102400',
            'description' => 'required|string',
        ]);

        $posterPath = $request->file('poster')->store('posters', 'public');
        $trailerPath = $request->file('trailer')->store('trailers', 'public');

        Popular::create([
            'title' => $request->title,
            'category' => json_encode($request->category),
            'poster' => $posterPath,
            'trailer' => $trailerPath,
            'description' => $request->description,
        ]);

        return redirect()->route('populars.index')->with('success', 'Popular item created successfully.');
    }

    public function edit(Popular $popular)
    {
        return view('dramabox.popular.edit', compact('popular'));
    }

    public function update(Request $request, Popular $popular)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|array',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'trailer' => 'nullable|mimes:mp4|max:10240',
            'description' => 'required|string',
        ]);

        $data = [
            'title' => $request->title,
            'category' => json_encode($request->category),
            'description' => $request->description,
        ];

        if ($request->hasFile('poster')) {
            Storage::disk('public')->delete($popular->poster);
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        if ($request->hasFile('trailer')) {
            Storage::disk('public')->delete($popular->trailer);
            $data['trailer'] = $request->file('trailer')->store('trailers', 'public');
        }

        $popular->update($data);

        return redirect()->route('populars.index')->with('success', 'Popular item updated successfully.');
    }

    public function destroy(Popular $popular)
    {
        Storage::disk('public')->delete([$popular->poster, $popular->trailer]);
        $popular->delete();
        return redirect()->route('populars.index')->with('success', 'Popular item deleted successfully.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $perPage = 12; // Jumlah item per halaman, Anda bisa sesuaikan

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
        return view('dramabox.browse', compact('videos', 'upcomings', 'populars', 'allCategories', 'category'));
    }
}