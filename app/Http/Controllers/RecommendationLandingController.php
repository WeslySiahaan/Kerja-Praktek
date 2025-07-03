<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RecommendationLandingController extends Controller
{
    // Konfigurasi kategori sebagai konstanta
    private const CATEGORIES = [
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

    /**
     * Display a listing of the recommendations.
     */
    public function index()
    {
        $recommendations = Recommendation::latest()->paginate(15);
        $category = request('category', 'all');
        return view('dramabox.recommendation.index', compact('recommendations', 'category') + ['categories' => self::CATEGORIES]);
    }

    /**
     * Show the form for creating a new recommendation.
     */
    public function create()
    {
        return view('dramabox.recommendation.create', ['categories' => self::CATEGORIES]);
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
            'category.*' => 'string|in:' . implode(',', array_diff(self::CATEGORIES, ['semua'])),
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'episodes' => 'nullable|array',
            'episodes.*' => 'nullable|file|mimes:mp4,mov,avi|max:102400',
        ]);

        try {
            $posterImagePath = $this->handlePosterImage($request);
            $episodes = $this->handleEpisodes($request);

            Recommendation::create([
                'name' => $request->name,
                'description' => $request->description,
                'rating' => $request->rating,
                'category' => $request->category,
                'poster_image' => $posterImagePath,
                'episodes' => $episodes,
            ]);

            return redirect()->route('recommendations.index')->with('success', 'Recommendation added successfully!');
        } catch (\Exception $e) {
            Log::error('Error storing recommendation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add recommendation. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified recommendation.
     */
    public function edit(Recommendation $recommendation)
    {
        return view('dramabox.recommendation.edit', compact('recommendation') + ['categories' => self::CATEGORIES]);
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
            'category.*' => 'string|in:' . implode(',', array_diff(self::CATEGORIES, ['semua'])),
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'episodes' => 'nullable|array',
            'episodes.*' => 'nullable|file|mimes:mp4,mov,avi|max:102400',
            'existing_episodes.*' => 'nullable|string',
        ]);

        try {
            $posterImagePath = $this->handlePosterImage($request, $recommendation->poster_image);
            $updatedEpisodes = $this->handleEpisodesUpdate($request, $recommendation->episodes);

            $recommendation->update([
                'name' => $request->name,
                'description' => $request->description,
                'rating' => $request->rating,
                'category' => $request->category,
                'poster_image' => $posterImagePath,
                'episodes' => $updatedEpisodes,
            ]);

            return redirect()->route('recommendations.index')->with('success', 'Recommendation updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating recommendation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update recommendation. Please try again.');
        }
    }

    /**
     * Remove the specified recommendation from storage.
     */
    public function destroy(Recommendation $recommendation)
    {
        try {
            $this->deleteMedia($recommendation->poster_image, $recommendation->episodes);
            $recommendation->delete();
            return redirect()->route('recommendations.index')->with('success', 'Recommendation deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting recommendation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete recommendation. Please try again.');
        }
    }

    /**
     * Search recommendations based on query and category.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category', 'all');
        $perPage = 15;

        $recommendations = Recommendation::query()
            ->when($query, fn($q) => $q->where('name', 'like', '%' . $query . '%'))
            ->when($category && $category !== 'all', fn($q) => $q->whereJsonContains('category', $category))
            ->latest()
            ->paginate($perPage)
            ->appends(request()->query());

        return view('dramabox.recommendation.index', compact('recommendations', 'category') + ['categories' => self::CATEGORIES]);
    }

    /**
     * Display the specified recommendation's details.
     */
    public function detail($id)
    {
        $recommendation = Recommendation::with(['comments', 'likedByUsers', 'collectedByUsers'])->findOrFail($id);
        return view('dramabox.recommendation.detail', compact('recommendation') + ['categories' => self::CATEGORIES]);
    }

    /**
     * Handle like action for the recommendation.
     */
    public function like(Request $request, Recommendation $recommendation)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Please log in to like a recommendation.');
            }

            if ($recommendation->likedByUsers()->where('user_id', $user->id)->exists()) {
                $recommendation->likedByUsers()->detach($user->id);
                return redirect()->back()->with('success', 'Berhasil batal menyukai.');
            }

            $recommendation->likedByUsers()->attach($user->id);
            return redirect()->back()->with('success', 'Berhasil menyukai.');
        } catch (\Exception $e) {
            Log::error('Error liking recommendation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to like recommendation. Please try again.');
        }
    }

    /**
     * Handle save action for the recommendation.
     */
    public function save(Request $request, Recommendation $recommendation)
{
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to save a recommendation.');
        }

        // Cek apakah sudah disimpan
        if ($recommendation->collectedByUsers()->where('user_id', $user->id)->exists()) {
            // Jika sudah, detach (batalkan simpan)
            $recommendation->collectedByUsers()->detach($user->id);
            return redirect()->route('users.koleksi')->with('success', 'Berhasil batal menyimpan rekomendasi.');
        }

        // Jika belum, attach (simpan)
        $recommendation->collectedByUsers()->attach($user->id);
        return redirect()->route('users.koleksi')->with('success', 'Rekomendasi berhasil disimpan ke koleksi Anda.');

}


    /**
     * Handle poster image upload or retention.
     */
    private function handlePosterImage(Request $request, $existingPath = null)
    {
        if ($request->hasFile('poster_image')) {
            if ($existingPath) {
                Storage::disk('public')->delete($existingPath);
            }
            $posterImage = $request->file('poster_image');
            $posterFileName = time() . '_poster.' . $posterImage->extension();
            return $posterImage->storeAs('posters', $posterFileName, 'public');
        }
        return $existingPath;
    }

    /**
     * Handle episode uploads for create action.
     */
    private function handleEpisodes(Request $request)
    {
        $episodes = [];
        if ($request->hasFile('episodes')) {
            foreach ($request->file('episodes') as $index => $episode) {
                if ($episode) {
                    $episodeFileName = time() . '_episode_' . $index . '.' . $episode->extension();
                    $episodes[] = $episode->storeAs('episodes', $episodeFileName, 'public');
                }
            }
        }
        return $episodes;
    }

    /**
     * Handle episode updates for update action.
     */
    private function handleEpisodesUpdate(Request $request, $existingEpisodes)
    {
        $retainedEpisodes = $request->input('existing_episodes', []);
        $newEpisodes = [];
        if ($request->hasFile('episodes')) {
            foreach ($request->file('episodes') as $index => $episode) {
                if ($episode) {
                    $episodeFileName = time() . '_episode_' . $index . '.' . $episode->extension();
                    $newEpisodes[] = $episode->storeAs('episodes', $episodeFileName, 'public');
                }
            }
        }
        $updatedEpisodes = array_merge($retainedEpisodes, $newEpisodes);
        $episodesToDelete = array_diff($existingEpisodes ?? [], $updatedEpisodes);
        foreach ($episodesToDelete as $pathToDelete) {
            Storage::disk('public')->delete($pathToDelete);
        }
        return $updatedEpisodes;
    }

    /**
     * Delete media files (poster and episodes).
     */
    private function deleteMedia($posterPath, $episodePaths)
    {
        if ($posterPath) {
            Storage::disk('public')->delete($posterPath);
        }
        if (is_array($episodePaths)) {
            foreach ($episodePaths as $episodePath) {
                if ($episodePath) {
                    Storage::disk('public')->delete($episodePath);
                }
            }
        }
    }
}