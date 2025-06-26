<?php

namespace App\Http\Controllers;

use App\Models\Popular; // Jika digunakan
use App\Models\Upcoming; // Jika digunakan
use App\Models\Video;
use App\Models\User; // Pastikan ini diimpor
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\WatchHistory; // <-- Pastikan ini diimpor!
use Illuminate\Support\Facades\Storage; // <-- Pastikan ini diimpor!

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::withCount(['likedByUsers', 'collectedByUsers'])->paginate(10);
        $categories = [
            "Sudden Wealth", "Werewolves", "Popular", "Average", "Divine Tycoon", "Love Triangle", "Revenge", "Paranormal",
            "Marriage", "Cinderella", "Underdog Rise", "Son-in-Law", "Secret Identity", "Second-chance Love", "Comedy", "Boy's Love",
            "Marriage Before Love", "Mafia", "Influencer", "Forbidden Love", "Uplifting Series", "Strong Female Lead", "Romance", "CEO",
            "Harem", "Fantasy", "Information Gaps", "Soulmate", "Trending", "Concealed Identity", "Counterattack", "Disguise",
            "Sweet Love", "Suspense", "Betrayal", "Urban", "Cross-dressing", "Time Travel Harem", "Werewolf",
            "SM", "Enemies to Lovers", "Mystery", "Super Power", "Billionaire", "Hated", "Dominant", "Alternative History",
            "Badboy", "Rebirth", "Small Potato", "Contract Lover", "Wealthy", "Humor", "Misunderstanding", "True Love",
            "Comeback", "Toxic Relationship", "Contract Marriage", "Family", "Time Travel", "Bitter Love", "Steamy", "Destiny"
        ];
        return view('dramabox.videos.index', compact('videos', 'categories'));
    }

    public function create()
    {
        $categories = [
            "Sudden Wealth", "Werewolves", "Popular", "Average", "Divine Tycoon", "Love Triangle", "Revenge", "Paranormal",
            "Marriage", "Cinderella", "Underdog Rise", "Son-in-Law", "Secret Identity", "Second-chance Love", "Comedy", "Boy's Love",
            "Marriage Before Love", "Mafia", "Influencer", "Forbidden Love", "Uplifting Series", "Strong Female Lead", "Romance", "CEO",
            "Harem", "Fantasy", "Information Gaps", "Soulmate", "Trending", "Concealed Identity", "Counterattack", "Disguise",
            "Sweet Love", "Suspense", "Betrayal", "Urban", "Cross-dressing", "Time Travel Harem", "Werewolf",
            "SM", "Enemies to Lovers", "Mystery", "Super Power", "Billionaire", "Hated", "Dominant", "Alternative History",
            "Badboy", "Rebirth", "Small Potato", "Contract Lover", "Wealthy", "Humor", "Misunderstanding", "True Love",
            "Comeback", "Toxic Relationship", "Contract Marriage", "Family", "Time Travel", "Bitter Love", "Steamy", "Destiny"
        ];
        return view('dramabox.videos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'category' => 'required',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'episodes.*' => 'nullable|file|mimes:mp4,mov,avi|max:102400', // Validasi untuk setiap episode
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

        Video::create([
            'name' => $request->name,
            'description' => $request->description,
            'rating' => $request->rating,
            'category' => $request->category,
            'is_popular' => $request->has('is_popular'),
            'poster_image' => $posterImagePath,
            'episodes' => $episodes, // JANGAN gunakan json_encode() karena model akan mengurusnya
        ]);

        return redirect()->route('videos.index')->with('success', 'Video added successfully!');
    }

    public function edit(Video $video)
    {
        $categories = [
            "Sudden Wealth", "Werewolves", "Popular", "Average", "Divine Tycoon", "Love Triangle", "Revenge", "Paranormal",
            "Marriage", "Cinderella", "Underdog Rise", "Son-in-Law", "Secret Identity", "Second-chance Love", "Comedy", "Boy's Love",
            "Marriage Before Love", "Mafia", "Influencer", "Forbidden Love", "Uplifting Series", "Strong Female Lead", "Romance", "CEO",
            "Harem", "Fantasy", "Information Gaps", "Soulmate", "Trending", "Concealed Identity", "Counterattack", "Disguise",
            "Sweet Love", "Suspense", "Betrayal", "Urban", "Cross-dressing", "Time Travel Harem", "Werewolf",
            "SM", "Enemies to Lovers", "Mystery", "Super Power", "Billionaire", "Hated", "Dominant", "Alternative History",
            "Badboy", "Rebirth", "Small Potato", "Contract Lover", "Wealthy", "Humor", "Misunderstanding", "True Love",
            "Comeback", "Toxic Relationship", "Contract Marriage", "Family", "Time Travel", "Bitter Love", "Steamy", "Destiny"
        ];
        return view('dramabox.videos.edit', compact('video', 'categories'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'category' => 'required',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'episodes.*' => 'nullable|file|mimes:mp4,mov,avi|max:102400',
            'existing_episodes.*' => 'nullable|string', // Untuk menangani episode yang dipertahankan
        ]);

        // Update poster image jika di-upload ulang
        $posterImagePath = $video->poster_image;
        if ($request->hasFile('poster_image')) {
            if ($video->poster_image) {
                Storage::disk('public')->delete($video->poster_image);
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
                    $newlyUploadedEpisodePaths[] = $episodeFile->storeAs('episodes', time() . '_' . $episodeFile->getClientOriginalName(), 'public');
                }
            }
        }

        // Gabungkan episode yang dipertahankan dengan yang baru diunggah
        $updatedEpisodesList = array_merge($retainedEpisodes, $newlyUploadedEpisodePaths);

        // Identifikasi episode lama yang tidak lagi ada di daftar baru (untuk dihapus dari storage)
        $oldEpisodes = $video->episodes ?? []; // Ambil versi asli dari DB
        $episodesToDelete = array_diff($oldEpisodes, $updatedEpisodesList);

        foreach ($episodesToDelete as $pathToDelete) {
            Storage::disk('public')->delete($pathToDelete);
        }

        // Simpan perubahan
        $video->update([
            'name' => $request->name,
            'description' => $request->description,
            'rating' => $request->rating,
            'category' => $request->category,
            'is_popular' => $request->has('is_popular'),
            'poster_image' => $posterImagePath,
            'episodes' => $updatedEpisodesList, // Laravel akan meng-cast otomatis ke JSON
        ]);

        return redirect()->route('videos.index')->with('success', 'Video updated successfully!');
    }

    public function destroy(Video $video)
    {
        // Hapus file poster jika ada
        if ($video->poster_image) {
            Storage::disk('public')->delete($video->poster_image);
        }
        // Hapus file episode jika ada
        if ($video->episodes) {
            foreach ($video->episodes as $episode) {
                if ($episode) {
                    Storage::disk('public')->delete($episode);
                }
            }
        }
        $video->delete();
        return redirect()->route('videos.index')->with('success', 'Video deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $perPage = 15; // Jumlah item per halaman, Anda bisa sesuaikan

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

        // Pastikan 'all' ada di daftar kategori untuk opsi filter
        if (!in_array('all', $allCategories)) {
            $allCategories[] = 'all';
        }

        // --- Mengirim Data ke View ---
        return view('welcome', compact('videos', 'upcomings', 'populars', 'allCategories', 'category'));
    }

    public function detail($id): View
    {
        $video = Video::findOrFail($id);
        return view('dramabox.detail', compact('video'));
    }

    public function detail1($id): View
    {
        $video = Video::findOrFail($id);

        // --- PENTING: Definisikan variabel di sini, sebelum blok if (Auth::check()) ---
        $isLiked = false;
        $isCollected = false;
        $watchHistory = null; // Inisialisasi watchHistory agar selalu ada

        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Variabel ini akan di-override jika user login
            $isLiked = $video->likedByUsers()->where('user_id', Auth::id())->exists();
            $isCollected = $video->collectedByUsers()->where('user_id', Auth::id())->exists();

            $watchHistory = WatchHistory::firstOrNew([
                'user_id' => $user->id,
                'video_id' => $video->id,
            ]);

            // Inisialisasi jika ini adalah entri baru
            if (!$watchHistory->exists) {
                $watchHistory->title = $video->name;
                $watchHistory->category = $video->category;
                $watchHistory->description = $video->description;
                $watchHistory->image = $video->poster_image ? Storage::url($video->poster_image) : 'https://placehold.co/80x120/cccccc/ffffff?text=No+Image';
                $watchHistory->watched_seconds = 0; // Mulai dari 0 detik untuk entri baru
                $watchHistory->progress = 0; // Mulai dari 0% untuk entri baru
            }

            // Hitung ulang progress dan watched_time setiap kali halaman dimuat
            // Ini juga akan menjadi nilai awal yang dibaca oleh JavaScript
            $totalDuration = $video->duration ?? 0; // Pastikan $video->duration ada dan dalam detik
            if ($totalDuration > 0) {
                $watchHistory->progress = min(100, round(($watchHistory->watched_seconds / $totalDuration) * 100));
            } else {
                $watchHistory->progress = 0;
            }

            // Format waktu tontonan
            $watchedTimeFormatted = gmdate("H:i:s", $watchHistory->watched_seconds);
            $totalDurationFormatted = gmdate("H:i:s", $totalDuration); // Gunakan H:i:s untuk akurasi
            $watchHistory->watched_time = $watchedTimeFormatted . ' / ' . $totalDurationFormatted;

            $watchHistory->save(); // Simpan pembaruan (termasuk watched_time yang diformat)
        }

        // Kirim $watchHistory ke view, bahkan jika null (jika tidak login)
        return view('dramabox.detail', compact('video', 'isLiked', 'isCollected', 'watchHistory'));
    }

    // <-- MULAI DARI SINI: Tambahkan metode baru updateWatchTime() -->
    public function updateWatchTime(Request $request)
    {
        $request->validate([
            'video_id' => 'required|exists:videos,id',
            'watched_seconds' => 'required|integer|min:0',
            'total_duration' => 'required|integer|min:1', // Total durasi video dari frontend
        ]);

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $videoId = $request->input('video_id');
        $watchedSeconds = $request->input('watched_seconds');
        $totalDuration = $request->input('total_duration');

        $watchHistory = WatchHistory::firstOrNew([
            'user_id' => $user->id,
            'video_id' => $videoId,
        ]);

        // Perbarui hanya jika waktu yang baru lebih besar dari yang tersimpan
        // atau jika perbedaan cukup signifikan (misal: lebih dari 10 detik)
        // atau jika sudah mencapai akhir video.
        if ($watchedSeconds > $watchHistory->watched_seconds || ($watchedSeconds == $totalDuration && $totalDuration > 0)) {
            $watchHistory->watched_seconds = $watchedSeconds;
            // Hitung progress baru
            $watchHistory->progress = min(100, round(($watchedSeconds / $totalDuration) * 100));

            // Format ulang watched_time untuk konsistensi, meskipun ini lebih untuk tampilan
            $watchedTimeFormatted = gmdate("H:i:s", $watchedSeconds);
            $totalDurationFormatted = gmdate("H:i:s", $totalDuration);
            $watchHistory->watched_time = $watchedTimeFormatted . ' / ' . $totalDurationFormatted;

            $watchHistory->save();
        }

        return response()->json(['status' => 'success', 'progress' => $watchHistory->progress, 'watched_seconds' => $watchHistory->watched_seconds]);
    }
    // <-- AKHIR DARI updateWatchTime() -->

    public function like(Request $request, Video $video)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk menyukai video.');
        }

        $user = Auth::user();
        if ($video->likedByUsers()->where('user_id', $user->id)->exists()) {
            $video->likedByUsers()->detach($user->id);
        } else {
            $video->likedByUsers()->attach($user->id);
        }

        return redirect()->back()->with('success');
    }

    public function save(Request $request, Video $video)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk menyimpan video.');
        }

        $user = Auth::user();
        if ($video->collectedByUsers()->where('user_id', $user->id)->exists()) {
            $message = 'Video sudah ada di koleksi.';
        } else {
            $video->collectedByUsers()->attach($user->id);
            $message = 'Video berhasil disimpan ke koleksi!';
        }

        return redirect()->route('users.koleksi')->with('success', $message);
    }

    public function show(Video $video)
    {
        $video->load([
            'likedByUsers',
            'collectedByUsers',
            'comments.user' => function ($query) {
                $query->latest(); // Mengurutkan komentar terbaru di atas berdasarkan created_at
            }
        ]);
        return view('dramabox.detail', compact('video'));
    }
}