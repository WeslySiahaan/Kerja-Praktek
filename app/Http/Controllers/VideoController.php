<?php

namespace App\Http\Controllers;

use App\Models\Popular;
use App\Models\Upcoming;
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
            'video_file' => 'required|file|mimes:mp4,mov,avi|max:102400', // Max 100MB
            'episodes.*' => 'file|mimes:mp4,mov,avi|max:102400', // Validasi untuk setiap episode
        ]);

        // Simpan file video utama
        $videoFilePath = null;
        if ($request->hasFile('video_file')) {
            $videoFile = $request->file('video_file');
            $videoFileName = time() . '_video.' . $videoFile->extension();
            $videoFile->move(public_path('videos'), $videoFileName);
            $videoFilePath = $videoFileName; // Simpan hanya nama file
        }

        // Simpan file episode
        $episodes = [];
        if ($request->hasFile('episodes')) {
            foreach ($request->file('episodes') as $index => $episode) {
                if ($episode) {
                    $episodeFileName = time() . '_episode_' . $index . '.' . $episode->extension();
                    $episode->move(public_path('episodes'), $episodeFileName);
                    $episodes[] = $episodeFileName; // Simpan hanya nama file
                }
            }
        }

        Video::create([
            'name' => $request->name,
            'description' => $request->description,
            'rating' => $request->rating,
            'category' => $request->category,
            'is_popular' => $request->has('is_popular'),
            'video_file' => $videoFilePath,
            'episodes' => json_encode($episodes),
        ]);

        return redirect()->route('videos.index')->with('success', 'Video added successfully!');
    }

    public function edit(Video $video)
    {
        $videos = Video::all(); // $videos seharusnya hanya $video untuk edit tunggal
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
        return view('dramabox.videos.edit', compact('video', 'categories')); // Hapus 'videos', gunakan 'video'
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'category' => 'required',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi|max:102400',
            'episodes.*' => 'nullable|file|mimes:mp4,mov,avi|max:102400',
        ]);

        // Update video file jika di-upload ulang
        $videoFilePath = $video->video_file;
        if ($request->hasFile('video_file')) {
            if ($video->video_file) {
                Storage::disk('public')->delete('videos/' . $video->video_file);
            }
            $videoFile = $request->file('video_file');
            $videoFileName = time() . '_video.' . $videoFile->extension();
            $videoFile->move(public_path('videos'), $videoFileName);
            $videoFilePath = $videoFileName;
        }

        // Ambil data episode lama
        $existingEpisodes = $video->episodes ? json_decode($video->episodes, true) : [];

        // Handle episode baru (tanpa menghapus yang lama)
        if ($request->hasFile('episodes')) {
            foreach ($request->file('episodes') as $index => $episode) {
                if ($episode) {
                    $episodeFileName = time() . '_episode_' . $index . '.' . $episode->extension();
                    $episode->move(public_path('episodes'), $episodeFileName);
                    $existingEpisodes[] = $episodeFileName;
                }
            }
        }

        // Simpan perubahan
        $video->update([
            'name' => $request->name,
            'description' => $request->description,
            'rating' => $request->rating,
            'category' => $request->category,
            'is_popular' => $request->has('is_popular'),
            'video_file' => $videoFilePath,
            'episodes' => json_encode($existingEpisodes),
        ]);

        return redirect()->route('videos.index')->with('success', 'Video updated successfully!');
    }

    public function destroy(Video $video)
    {
        if ($video->video_file) {
            Storage::disk('public')->delete('videos/' . $video->video_file);
        }
        if ($video->episodes) {
            foreach (json_decode($video->episodes, true) as $episode) {
                if ($episode) {
                    Storage::disk('public')->delete('episodes/' . $episode);
                }
            }
        }
        $video->delete();
        return redirect()->route('videos.index')->with('success', 'Video deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
    
        // Pencarian di model Video
        $videos = Video::query();
        if ($query) {
            $videos->where('name', 'like', '%' . $query . '%');
        }
        $videos = $videos->latest()->get();
    
        // Pencarian di model Upcoming
        $upcomings = Upcoming::query();
        if ($query) {
            $upcomings->where('title', 'like', '%' . $query . '%');
        }
        $upcomings = $upcomings->latest()->get();

        // Pencarian di model Popular
        $populars = Popular::query();
        if ($query) {
            $populars->where('title', 'like', '%' . $query . '%');
        }
        $populars = $populars->latest()->get();
    
        // Kirim dua variabel ke view
        return view('welcome', compact('videos', 'upcomings', 'populars'));
    }

    public function detail($id): View
    {
        $video = Video::findOrFail($id); // Ubah $videos menjadi $video (singular)
        return view('dramabox.detail', compact('video')); // Ubah compact('videos') menjadi compact('video')
    }
}