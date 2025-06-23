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

        // Filter for Video
        $videos = Video::query();
        if ($query) {
            $videos->where('name', 'like', '%' . $query . '%');
        }
        if ($category && $category !== 'all') {
            $videos->where('category', $category); // Correct: 'category' for Video model
        }
        $videos = $videos->latest()->get();

        // Filter for Upcoming
        $upcomings = Upcoming::query();
        if ($query) {
            $upcomings->where('title', 'like', '%' . $query . '%');
        }
        if ($category && $category !== 'all') {
            // FIX HERE: Change 'categories' to 'category' if your Upcoming table has a 'category' column
            $upcomings->where('category', $category);
        }
        $upcomings = $upcomings->latest()->get();

        // Filter for Popular
        $populars = Popular::query();
        if ($query) {
            $populars->where('title', 'like', '%' . $query . '%');
        }
        if ($category && $category !== 'all') {
            // FIX HERE: Change 'categories' to 'category' if your Popular table has a 'category' column
            $populars->where('category', $category);
        }
        $populars = $populars->latest()->get();

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

        return view('dramabox.browse', compact('videos', 'upcomings', 'populars', 'allCategories', 'category'));
    }
}