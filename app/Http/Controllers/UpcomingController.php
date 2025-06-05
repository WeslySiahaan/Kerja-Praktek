<?php

namespace App\Http\Controllers;

use App\Models\Upcoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpcomingController extends Controller
{
    public function index()
    {
        $upcomings = Upcoming::all();
        return view('upcomings.index', compact('upcomings'));
    }

    public function create()
    {
        $categories = ['Action', 'Drama', 'Comedy', 'Horror', 'Sci-Fi'];
        return view('upcomings.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'category' => 'required|string',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $posterPath = $request->file('poster')->store('posters', 'public');
        $trailerPath = $request->file('trailer')->store('trailers', 'public');

        Upcoming::create([
            'title' => $request->title,
            'description' => $request->description,
            'release_date' => $request->release_date,
            'category' => $request->category,
            'poster' => $posterPath,
            'trailer' => $trailerPath,
        ]);

        return redirect()->route('upcomings.index')->with('success', 'Upcoming release added successfully.');
    }

    public function edit(Upcoming $upcoming)
    {
        $categories = ['Action', 'Drama', 'Comedy', 'Horror', 'Sci-Fi'];
        return view('upcomings.edit', compact('upcoming', 'categories'));
    }

    public function update(Request $request, Upcoming $upcoming)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'category' => 'required|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'release_date', 'category']);

        if ($request->hasFile('poster')) {
            Storage::disk('public')->delete($upcoming->poster);
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        if ($request->hasFile('trailer')) {
            Storage::disk('public')->delete($upcoming->trailer);
            $data['trailer'] = $request->file('trailer')->store('trailers', 'public');
        }

        $upcoming->update($data);

        return redirect()->route('upcomings.index')->with('success', 'Upcoming release updated successfully.');
    }

    public function destroy(Upcoming $upcoming)
    {
        Storage::disk('public')->delete($upcoming->poster);
        Storage::disk('public')->delete($upcoming->trailer);
        $upcoming->delete();

        return redirect()->route('upcomings.index')->with('success', 'Upcoming release deleted successfully.');
    }
}