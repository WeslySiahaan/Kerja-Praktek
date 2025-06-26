<?php

namespace App\Http\Controllers;

use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // <-- Tambahkan ini untuk type hinting

class WatchHistoryController extends Controller
{
    /**
     * Menampilkan daftar riwayat tontonan.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melihat riwayat tontonan.');
        }

        /** @var \App\Models\User $user */ // DocBlock untuk membantu Intelephense
        $user = Auth::user();

        $watchHistoryItems = $user->watchHistories()->orderBy('created_at', 'desc')->get();

        // Pastikan nama view sesuai dengan lokasi file Anda
        return view('profile.riwayat-tontonan', compact('watchHistoryItems'));
    }

    /**
     * Menghapus item tertentu dari riwayat tontonan.
     */
    public function destroy(WatchHistory $watchHistory)
    {
        if ($watchHistory->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $watchHistory->delete();

        return back()->with('success', 'Item riwayat tontonan berhasil dihapus.');
    }

    /**
     * Menghapus semua riwayat tontonan untuk user yang terautentikasi.
     */
    public function clearAll()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk membersihkan riwayat tontonan.');
        }

        /** @var \App\Models\User $user */ // DocBlock untuk membantu Intelephense
        $user = Auth::user();
        $user->watchHistories()->delete();

        return back()->with('success', 'Semua riwayat tontonan berhasil dihapus.');
    }

    // Metode ini bisa Anda gunakan jika ingin menambahkan riwayat dari tempat lain (opsional)
    public function addHistory(Request $request)
    {
        $request->validate([
            'video_id' => 'required|exists:videos,id',
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'progress' => 'nullable|integer|min:0|max:100',
            'watched_time' => 'nullable|string|max:255',
        ]);

        if (!Auth::check()) {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $history = $user->watchHistories()->create([
            'video_id' => $request->video_id,
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $request->image,
            'progress' => $request->progress ?? 0,
            'watched_time' => $request->watched_time ?? '00:00 / 00:00',
        ]);

        return back()->with('success', 'Riwayat tontonan berhasil ditambahkan.');
    }
}