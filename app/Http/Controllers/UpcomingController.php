<?php

namespace App\Http\Controllers;

use App\Models\Upcoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpcomingController extends Controller
{
    // Daftar kategori yang diizinkan
    private $categories = [
       
    "Kekayaan Mendadak", "Manusia Serigala", "Populer", "Biasa Saja", "Konglomerat Ilahi", "Cinta Segitiga", "Balas Dendam", "Paranormal",
    "Pernikahan", "Cinderella", "Bangkit dari Keterpurukan", "Menantu Lelaki", "Identitas Rahasia", "Cinta Kesempatan Kedua", "Komedi", "Cinta Sesama Laki-laki",
    "Menikah Sebelum Cinta", "Mafia", "Influencer", "Cinta Terlarang", "Cerita Inspiratif", "Tokoh Perempuan Kuat", "Romansa", "CEO",
    "Harem", "Fantasi", "Kesenjangan Informasi", "Belahan Jiwa", "Sedang Tren", "Identitas Tersembunyi", "Serangan Balik", "Penyamaran",
    "Cinta Manis", "Ketegangan", "Pengkhianatan", "Kehidupan Urban", "Penyamaran Gender", "Harem Penjelajah Waktu", "Manusia Serigala",
    "Dominasi & Submisi", "Dari Musuh Jadi Cinta", "Misteri", "Kekuatan Super", "Miliarder", "Dibenci", "Dominan", "Sejarah Alternatif",
    "Anak Nakal", "Reinkarnasi", "Si Kecil yang Diremehkan", "Pasangan Kontrak", "Keluarga Kaya", "Humor", "Kesalahpahaman", "Cinta Sejati",
    "Comeback", "Hubungan Beracun", "Pernikahan Kontrak", "Keluarga", "Perjalanan Waktu", "Cinta yang Menyakitkan", "Cerita Panas", "Takdir",
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
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048',
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