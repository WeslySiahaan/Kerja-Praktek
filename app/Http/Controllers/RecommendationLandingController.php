<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecommendationLandingController extends Controller
{
    /**
     * Display a listing of the recommendations.
     */
    public function index()
    {
        $recommendations = Recommendation::latest()->paginate(15);
       $categories = [
    "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
    "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
    "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
    "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
    "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu", 
    "Dominasi & Submisi", "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif",
    "Anak Nakal", "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
    "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
    "semua"
];

        $category = request('category', 'all'); // Default ke 'all' jika tidak ada kategori dipilih
        return view('dramabox.recommendation.index', compact('recommendations', 'categories', 'category'));
    }

    /**
     * Show the form for creating a new recommendation.
     */
    public function create()
    {
       $categories = [
    "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
    "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
    "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
    "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
    "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu", "Manusia Serigala",
    "Dominasi & Submisi", "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif",
    "Anak Nakal", "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
    "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
];

        return view('dramabox.recommendation.create', compact('categories'));
    }

    /**
     * Store a newly created recommendation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'category' => 'required|array',
           'category.*' => 'string|in:' . implode(',', [
    "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
    "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
    "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
    "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
    "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu",
    "Dominasi & Submisi", "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif",
    "Anak Nakal", "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
    "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
]),

            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'episodes.*' => 'nullable|file|mimes:mp4,mov,avi|max:102400',
        ]);

        // Simpan file gambar poster
        $posterImagePath = null;
        if ($request->hasFile('poster_image')) {
            $posterImage = $request->file('poster_image');
            $posterFileName = time() . '_poster.' . $posterImage->extension();
            $posterImagePath = $posterImage->storeAs('posters', $posterFileName, 'public');
        }

        // Simpan file episode
        $episodes = [];
        if ($request->hasFile('episodes')) {
            foreach ($request->file('episodes') as $index => $episode) {
                if ($episode) {
                    $episodeFileName = time() . '_episode_' . $index . '.' . $episode->extension();
                    $episodes[] = $episode->storeAs('episodes', $episodeFileName, 'public');
                }
            }
        }

        Recommendation::create([
            'name' => $request->name,
            'description' => $request->description,
            'rating' => $request->rating,
            'category' => $request->category,
            'poster_image' => $posterImagePath,
            'episodes' => $episodes,
        ]);

        return redirect()->route('recommendations.index')->with('success', 'Recommendation added successfully!');
    }

    /**
     * Show the form for editing the specified recommendation.
     */
    public function edit(Recommendation $recommendation)
    {
       $categories = [
    "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
    "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
    "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
    "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
    "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu", "Manusia Serigala",
    "Dominasi & Submisi", "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif",
    "Anak Nakal", "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
    "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
];

        return view('dramabox.recommendation.edit', compact('recommendation', 'categories'));
    }

    /**
     * Update the specified recommendation in storage.
     */
    public function update(Request $request, Recommendation $recommendation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'category' => 'required|array',
            'category.*' => 'string|in:' . implode(',', [
    "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
    "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
    "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
    "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
    "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu",
    "Dominasi & Submisi", "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif",
    "Anak Nakal", "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
    "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
]),

            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'episodes.*' => 'nullable|file|mimes:mp4,mov,avi|max:102400',
            'existing_episodes.*' => 'nullable|string',
        ]);

        // Update poster image jika di-upload ulang
        $posterImagePath = $recommendation->poster_image;
        if ($request->hasFile('poster_image')) {
            if ($recommendation->poster_image) {
                Storage::disk('public')->delete($recommendation->poster_image);
            }
            $posterImage = $request->file('poster_image');
            $posterFileName = time() . '_poster.' . $posterImage->extension();
            $posterImagePath = $posterImage->storeAs('posters', $posterFileName, 'public');
        }

        // Ambil episode yang dipertahankan dari input hidden
        $retainedEpisodes = $request->input('existing_episodes', []);

        // Ambil episode baru yang diunggah
        $newlyUploadedEpisodePaths = [];
        if ($request->hasFile('episodes')) {
            foreach ($request->file('episodes') as $episodeFile) {
                if ($episodeFile) {
                    $episodeFileName = time() . '_episode_' . $episodeFile->getClientOriginalName();
                    $newlyUploadedEpisodePaths[] = $episodeFile->storeAs('episodes', $episodeFileName, 'public');
                }
            }
        }

        // Gabungkan episode yang dipertahankan dengan yang baru diunggah
        $updatedEpisodesList = array_merge($retainedEpisodes, $newlyUploadedEpisodePaths);

        // Identifikasi episode lama yang tidak lagi ada di daftar baru (untuk dihapus dari storage)
        $oldEpisodes = $recommendation->episodes ?? [];
        $episodesToDelete = array_diff($oldEpisodes, $updatedEpisodesList);

        foreach ($episodesToDelete as $pathToDelete) {
            Storage::disk('public')->delete($pathToDelete);
        }

        // Simpan perubahan
        $recommendation->update([
            'name' => $request->name,
            'description' => $request->description,
            'rating' => $request->rating,
            'category' => $request->category,
            'poster_image' => $posterImagePath,
            'episodes' => $updatedEpisodesList,
        ]);

        return redirect()->route('recommendations.index')->with('success', 'Recommendation updated successfully!');
    }

    /**
     * Remove the specified recommendation from storage.
     */
    public function destroy(Recommendation $recommendation)
    {
        // Hapus file poster jika ada
        if ($recommendation->poster_image) {
            Storage::disk('public')->delete($recommendation->poster_image);
        }
        // Hapus file episode jika ada
        if ($recommendation->episodes) {
            foreach ($recommendation->episodes as $episode) {
                if ($episode) {
                    Storage::disk('public')->delete($episode);
                }
            }
        }
        $recommendation->delete();
        return redirect()->route('recommendations.index')->with('success', 'Recommendation deleted successfully!');
    }

    /**
     * Search recommendations based on query and category.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $perPage = 15;

        $recommendations = Recommendation::query();
        if ($query) {
            $recommendations->where('name', 'like', '%' . $query . '%');
        }
        if ($category && $category !== 'all') {
            $recommendations->whereJsonContains('category', $category);
        }
        $recommendations = $recommendations->latest()->paginate($perPage)->appends(request()->query());

       $categories = [
    "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
    "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
    "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
    "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
    "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu", "Manusia Serigala",
    "Dominasi & Submisi", "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif",
    "Anak Nakal", "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
    "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
    "semua"
];


        return view('dramabox.recommendation.index', compact('recommendations', 'categories', 'category'));
    }
}