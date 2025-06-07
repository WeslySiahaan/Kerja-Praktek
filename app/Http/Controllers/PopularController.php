<?php
// app/Http/Controllers/PopularController.php
namespace App\Http\Controllers;

use App\Models\Popular;
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
            'categories' => 'required|array',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'trailer' => 'required|mimes:mp4|max:102400',
            'description' => 'required|string',
        ]);

        $posterPath = $request->file('poster')->store('posters', 'public');
        $trailerPath = $request->file('trailer')->store('trailers', 'public');

        Popular::create([
            'title' => $request->title,
            'categories' => json_encode($request->categories),
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
            'categories' => 'required|array',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'trailer' => 'nullable|mimes:mp4|max:10240',
            'description' => 'required|string',
        ]);

        $data = [
            'title' => $request->title,
            'categories' => json_encode($request->categories),
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
}