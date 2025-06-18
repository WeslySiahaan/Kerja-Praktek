<?php

namespace App\Http\Controllers;

use App\Models\Popular; // Jika digunakan
use App\Models\Upcoming; // Jika digunakan
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();
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
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB untuk gambar
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
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

        $videos = Video::query();
        if ($query) {
            $videos->where('name', 'like', '%' . $query . '%');
        }
        $videos = $videos->latest()->get();

        $upcomings = Upcoming::query(); // Pastikan model Upcoming ada
        if ($query) {
            $upcomings->where('title', 'like', '%' . $query . '%');
        }
        $upcomings = $upcomings->latest()->get();

        $populars = Popular::query(); // Pastikan model Popular ada
        if ($query) {
            $populars->where('title', 'like', '%' . $query . '%');
        }
        $populars = $populars->latest()->get();

        return view('welcome', compact('videos', 'upcomings', 'populars'));
    }

    public function detail($id): View
    {
        $video = Video::findOrFail($id);
        return view('dramabox.detail', compact('video'));
    }
}