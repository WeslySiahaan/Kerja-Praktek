<?php

namespace App\Http\Controllers;

use App\Models\Upcoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpcomingController extends Controller
{
    // Daftar kategori yang diizinkan
    private $categories = [
        "Sudden Wealth", "Werewolves", "Popular", "Average", "Divine Tycoon", "Love Triangle", "Revenge", "Paranormal",
        "Marriage", "Cinderella", "Underdog Rise", "Son-in-Law", "Secret Identity", "Second-chance Love", "Comedy", "Boy's Love",
        "Marriage Before Love", "Mafia", "Influencer", "Forbidden Love", "Uplifting Series", "Strong Female Lead", "Romance", "CEO",
        "Harem", "Fantasy", "Information Gaps", "Soulmate", "Trending", "Concealed Identity", "Counterattack", "Disguise",
        "Sweet Love", "Suspense", "Betrayal", "Urban", "Cross-dressing", "Time Travel Harem", "Werewolf",
        "SM", "Enemies to Lovers", "Mystery", "Super Power", "Billionaire", "Hated", "Dominant", "Alternative History",
        "Badboy", "Rebirth", "Small Potato", "Contract Lover", "Wealthy", "Humor", "Misunderstanding", "True Love",
        "Comeback", "Toxic Relationship", "Contract Marriage", "Family", "Time Travel", "Bitter Love", "Steamy", "Destiny"
    ];

    public function index()
    {
        $upcomings = Upcoming::all();
        return view('dramabox.upcomings.index', compact('upcomings'));
    }

    public function create()
    {
        $categories = $this->categories;
        return view('dramabox.upcomings.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'required|date',
            'category' => 'required|array', // Validasi sebagai array
            'category.*' => 'in:' . implode(',', $this->categories), // Validasi setiap kategori
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer' => 'nullable|file|mimes:mp4,mov,avi|max:102400', // Mendukung video, maks 100MB
        ]);

        // Proses unggah poster
        $posterPath = $request->file('poster')
            ? $request->file('poster')->store('posters', 'public')
            : null;

        // Proses unggah trailer
        $trailerPath = $request->file('trailer')
            ? $request->file('trailer')->store('trailers', 'public')
            : null;

        // Simpan data, category disimpan sebagai JSON
        Upcoming::create([
            'title' => $request->title,
            'description' => $request->description,
            'release_date' => $request->release_date,
            'category' => $request->category, // Array akan otomatis diserialisasi ke JSON
            'poster' => $posterPath,
            'trailer' => $trailerPath,
        ]);

        return redirect()->route('upcomings.index')->with('success', 'Upcoming release added successfully.');
    }

    public function edit(Upcoming $upcoming)
    {
        $categories = $this->categories;
        return view('dramabox.upcomings.edit', compact('upcoming', 'categories'));
    }

    public function update(Request $request, Upcoming $upcoming)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'required|date',
            'category' => 'required|array',
            'category.*' => 'in:' . implode(',', $this->categories),
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer' => 'nullable|file|mimes:mp4,mov,avi|max:102400',
        ]);

        $data = $request->only(['title', 'description', 'release_date', 'category']);

        if ($request->hasFile('poster')) {
            if ($upcoming->poster) {
                Storage::disk('public')->delete($upcoming->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        if ($request->hasFile('trailer')) {
            if ($upcoming->trailer) {
                Storage::disk('public')->delete($upcoming->trailer);
            }
            $data['trailer'] = $request->file('trailer')->store('trailers', 'public');
        }

        $upcoming->update($data);

        return redirect()->route('upcomings.index')->with('success', 'Upcoming release updated successfully.');
    }

    public function destroy(Upcoming $upcoming)
    {
        if ($upcoming->poster) {
            Storage::disk('public')->delete($upcoming->poster);
        }
        if ($upcoming->trailer) {
            Storage::disk('public')->delete($upcoming->trailer);
        }
        $upcoming->delete();

        return redirect()->route('upcomings.index')->with('success', 'Upcoming release deleted successfully.');
    }
}