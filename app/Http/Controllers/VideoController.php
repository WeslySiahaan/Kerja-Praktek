<?php

namespace App\Http\Controllers;

use App\Models\Popular;
use App\Models\Upcoming;
use App\Models\Video;
use App\Models\User;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::withCount(['likedByUsers', 'collectedByUsers'])->paginate(10);
        $categories = [
            "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
            "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
            "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
            "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
            "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu", "Dominasi & Submisi",
            "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif", "Anak Nakal",
            "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
            "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
        ];

        return view('dramabox.videos.index', compact('videos', 'categories'));
    }

    public function create()
    {
        $categories = [
            "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
            "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
            "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
            "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
            "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu", "Dominasi & Submisi",
            "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif", "Anak Nakal",
            "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
            "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
        ];
        
        return view('dramabox.videos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'category' => 'required|array',
            'category.*' => 'string|in:' . implode(',', [
                "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
                "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
                "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
                "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
                "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu", "Dominasi & Submisi",
                "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif", "Anak Nakal",
                "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
                "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
            ]),
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480', // 20MB
            'episodes.*' => 'nullable|file|mimes:mp4,mov,avi|max:1048576', // 1MB
        ]);

        // Simpan file gambar poster
        $posterImagePath = null;
        if ($request->hasFile('poster_image')) {
            $posterImage = $request->file('poster_image');
            $posterFileName = time() . '_poster.' . $posterImage->getClientOriginalExtension();
            $posterImagePath = $posterImage->storeAs('posters', $posterFileName, 'public');
        }

        // Simpan file episode
        $episodes = [];
        if ($request->hasFile('episodes')) {
            foreach ($request->file('episodes') as $index => $episode) {
                if ($episode) {
                    $episodeFileName = time() . '_episode_' . $index . '.' . $episode->getClientOriginalExtension();
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
            'episodes' => $episodes,
        ]);

        return redirect()->route('videos.index')->with('success', 'Video added successfully!');
    }

    public function edit(Video $video)
    {
        $categories = [
            "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
            "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
            "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
            "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
            "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu", "Dominasi & Submisi",
            "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif", "Anak Nakal",
            "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
            "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
        ];

        return view('dramabox.videos.edit', compact('video', 'categories'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'category' => 'required|array',
            'category.*' => 'string|in:' . implode(',', [
                "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
                "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
                "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
                "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
                "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu", "Dominasi & Submisi",
                "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif", "Anak Nakal",
                "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
                "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
            ]),
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480', // 20MB
            'episodes.*' => 'nullable|file|mimes:mp4,mov,avi|max:1048576', // 1MB
            'existing_episodes.*' => 'nullable|string',
        ]);

        // Update poster image jika di-upload ulang
        $posterImagePath = $video->poster_image;
        if ($request->hasFile('poster_image')) {
            if ($video->poster_image) {
                Storage::disk('public')->delete($video->poster_image);
            }
            $posterImage = $request->file('poster_image');
            $posterFileName = time() . '_poster.' . $posterImage->getClientOriginalExtension();
            $posterImagePath = $posterImage->storeAs('posters', $posterFileName, 'public');
        }

        // Ambil episode yang dipertahankan dari input hidden
        $retainedEpisodes = $request->input('existing_episodes', []);

        // Ambil episode baru yang diunggah
        $newlyUploadedEpisodePaths = [];
        if ($request->hasFile('episodes')) {
            foreach ($request->file('episodes') as $episodeFile) {
                if ($episodeFile) {
                    $episodeFileName = time() . '_' . $episodeFile->getClientOriginalName();
                    $newlyUploadedEpisodePaths[] = $episodeFile->storeAs('episodes', $episodeFileName, 'public');
                }
            }
        }

        // Gabungkan episode yang dipertahankan dengan yang baru diunggah
        $updatedEpisodesList = array_merge($retainedEpisodes, $newlyUploadedEpisodePaths);

        // Identifikasi episode lama yang tidak lagi ada di daftar baru (untuk dihapus dari storage)
        $oldEpisodes = $video->episodes ?? [];
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
            'episodes' => $updatedEpisodesList,
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
    return view('welcome', compact('videos', 'upcomings', 'populars', 'allCategories', 'category', 'query'));
}

    public function detail($id): View
    {
        $video = Video::with(['likedByUsers', 'collectedByUsers', 'comments' => function ($query) {
            $query->with('user')->latest();
        }])->findOrFail($id);
        return view('dramabox.detail', compact('video'));
    }

    public function detail1($id): View
    {
        $video = Video::with(['likedByUsers', 'collectedByUsers', 'comments' => function ($query) {
            $query->with('user')->latest();
        }])->findOrFail($id);

        $isLiked = false;
        $isCollected = false;
        $watchHistory = null;

        if (Auth::check()) {
            $user = Auth::user();
            $isLiked = $video->likedByUsers()->where('user_id', $user->id)->exists();
            $isCollected = $video->collectedByUsers()->where('user_id', $user->id)->exists();

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

        return view('dramabox.detail', compact('video', 'isLiked', 'isCollected', 'watchHistory'));
    }

    public function updateWatchTime(Request $request)
    {
        $request->validate([
            'video_id' => 'required|exists:videos,id',
            'watched_seconds' => 'required|integer|min:0',
            'total_duration' => 'required|integer|min:1',
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

        if ($watchedSeconds > $watchHistory->watched_seconds || ($watchedSeconds == $totalDuration && $totalDuration > 0)) {
            $watchHistory->watched_seconds = $watchedSeconds;
            $watchHistory->progress = min(100, round(($watchedSeconds / $totalDuration) * 100));

            $watchedTimeFormatted = gmdate("H:i:s", $watchedSeconds);
            $totalDurationFormatted = gmdate("H:i:s", $totalDuration);
            $watchHistory->watched_time = $watchedTimeFormatted . ' / ' . $totalDurationFormatted;

            $watchHistory->save();
        }

        return response()->json(['status' => 'success', 'progress' => $watchHistory->progress, 'watched_seconds' => $watchHistory->watched_seconds]);
    }

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

        return redirect()->back()->with('success', 'Like status updated successfully!');
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
                $query->latest();
            }
        ]);
        return view('dramabox.detail', compact('video'));
    }
}