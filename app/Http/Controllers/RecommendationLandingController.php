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
            "Sudden Wealth", "Werewolves", "Popular", "Average", "Divine Tycoon", "Love Triangle", "Revenge", "Paranormal",
            "Marriage", "Cinderella", "Underdog Rise", "Son-in-Law", "Secret Identity", "Second-chance Love", "Comedy", "Boy's Love",
            "Marriage Before Love", "Mafia", "Influencer", "Forbidden Love", "Uplifting Series", "Strong Female Lead", "Romance", "CEO",
            "Harem", "Fantasy", "Information Gaps", "Soulmate", "Trending", "Concealed Identity", "Counterattack", "Disguise",
            "Sweet Love", "Suspense", "Betrayal", "Urban", "Cross-dressing", "Time Travel Harem", "Werewolf",
            "SM", "Enemies to Lovers", "Mystery", "Super Power", "Billionaire", "Hated", "Dominant", "Alternative History",
            "Badboy", "Rebirth", "Small Potato", "Contract Lover", "Wealthy", "Humor", "Misunderstanding", "True Love",
            "Comeback", "Toxic Relationship", "Contract Marriage", "Family", "Time Travel", "Bitter Love", "Steamy", "Destiny",
            "all"
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
            "Sudden Wealth", "Werewolves", "Popular", "Average", "Divine Tycoon", "Love Triangle", "Revenge", "Paranormal",
            "Marriage", "Cinderella", "Underdog Rise", "Son-in-Law", "Secret Identity", "Second-chance Love", "Comedy", "Boy's Love",
            "Marriage Before Love", "Mafia", "Influencer", "Forbidden Love", "Uplifting Series", "Strong Female Lead", "Romance", "CEO",
            "Harem", "Fantasy", "Information Gaps", "Soulmate", "Trending", "Concealed Identity", "Counterattack", "Disguise",
            "Sweet Love", "Suspense", "Betrayal", "Urban", "Cross-dressing", "Time Travel Harem", "Werewolf",
            "SM", "Enemies to Lovers", "Mystery", "Super Power", "Billionaire", "Hated", "Dominant", "Alternative History",
            "Badboy", "Rebirth", "Small Potato", "Contract Lover", "Wealthy", "Humor", "Misunderstanding", "True Love",
            "Comeback", "Toxic Relationship", "Contract Marriage", "Family", "Time Travel", "Bitter Love", "Steamy", "Destiny"
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
            'category.*' => 'string|in:Sudden Wealth,Werewolves,Popular,Average,Divine Tycoon,Love Triangle,Revenge,Paranormal,Marriage,Cinderella,Underdog Rise,Son-in-Law,Secret Identity,Second-chance Love,Comedy,Boy\'s Love,Marriage Before Love,Mafia,Influencer,Forbidden Love,Uplifting Series,Strong Female Lead,Romance,CEO,Hloosely Harem,Fantasy,Information Gaps,Soulmate,Trending,Concealed Identity,Counterattack,Disguise,Sweet Love,Suspense,Betrayal,Urban,Cross-dressing,Time Travel Harem,Werewolf,SM,Enemies to Lovers,Mystery,Super Power,Billionaire,Hated,Dominant,Alternative History,Badboy,Rebirth,Small Potato,Contract Lover,Wealthy,Humor,Misunderstanding,True Love,Comeback,Toxic Relationship,Contract Marriage,Family,Time Travel,Bitter Love,Steamy,Destiny',
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
            "Sudden Wealth", "Werewolves", "Popular", "Average", "Divine Tycoon", "Love Triangle", "Revenge", "Paranormal",
            "Marriage", "Cinderella", "Underdog Rise", "Son-in-Law", "Secret Identity", "Second-chance Love", "Comedy", "Boy's Love",
            "Marriage Before Love", "Mafia", "Influencer", "Forbidden Love", "Uplifting Series", "Strong Female Lead", "Romance", "CEO",
            "Harem", "Fantasy", "Information Gaps", "Soulmate", "Trending", "Concealed Identity", "Counterattack", "Disguise",
            "Sweet Love", "Suspense", "Betrayal", "Urban", "Cross-dressing", "Time Travel Harem", "Werewolf",
            "SM", "Enemies to Lovers", "Mystery", "Super Power", "Billionaire", "Hated", "Dominant", "Alternative History",
            "Badboy", "Rebirth", "Small Potato", "Contract Lover", "Wealthy", "Humor", "Misunderstanding", "True Love",
            "Comeback", "Toxic Relationship", "Contract Marriage", "Family", "Time Travel", "Bitter Love", "Steamy", "Destiny"
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
            'category.*' => 'string|in:Sudden Wealth,Werewolves,Popular,Average,Divine Tycoon,Love Triangle,Revenge,Paranormal,Marriage,Cinderella,Underdog Rise,Son-in-Law,Secret Identity,Second-chance Love,Comedy,Boy\'s Love,Marriage Before Love,Mafia,Influencer,Forbidden Love,Uplifting Series,Strong Female Lead,Romance,CEO,Harem,Fantasy,Information Gaps,Soulmate,Trending,Concealed Identity,Counterattack,Disguise,Sweet Love,Suspense,Betrayal,Urban,Cross-dressing,Time Travel Harem,Werewolf,SM,Enemies to Lovers,Mystery,Super Power,Billionaire,Hated,Dominant,Alternative History,Badboy,Rebirth,Small Potato,Contract Lover,Wealthy,Humor,Misunderstanding,True Love,Comeback,Toxic Relationship,Contract Marriage,Family,Time Travel,Bitter Love,Steamy,Destiny',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'episodes.*' => 'nullable|file|mimes:mp4,mov,avi|max:102400',
            'existing_episodes.*' => 'nullable|stringrama string',
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
            "Sudden Wealth", "Werewolves", "Popular", "Average", "Divine Tycoon", "Love Triangle", "Revenge", "Paranormal",
            "Marriage", "Cinderella", "Underdog Rise", "Son-in-Law", "Secret Identity", "Second-chance Love", "Comedy", "Boy's Love",
            "Marriage Before Love", "Mafia", "Influencer", "Forbidden Love", "Uplifting Series", "Strong Female Lead", "Romance", "CEO",
            "Harem", "Fantasy", "Information Gaps", "Soulmate", "Trending", "Concealed Identity", "Counterattack", "Disguise",
            "Sweet Love", "Suspense", "Betrayal", "Urban", "Cross-dressing", "Time Travel Harem", "Werewolf",
            "SM", "Enemies to Lovers", "Mystery", "Super Power", "Billionaire", "Hated", "Dominant", "Alternative History",
            "Badboy", "Rebirth", "Small Potato", "Contract Lover", "Wealthy", "Humor", "Misunderstanding", "True Love",
            "Comeback", "Toxic Relationship", "Contract Marriage", "Family", "Time Travel", "Bitter Love", "Steamy", "Destiny",
            "all"
        ];

        return view('dramabox.recommendation.index', compact('recommendations', 'categories', 'category'));
    }
}