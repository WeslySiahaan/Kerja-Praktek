<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use App\Models\Recommendation;

class KoleksiController extends Controller
{
    /**
     * Menampilkan halaman koleksi.
     *
     * @return View
     */
    public function index(): View
{
    if (!Auth::check()) {
        return view('users.Koleksi', [
            'videos' => collect([])->toBase(),
            'recommendations' => collect([])->toBase(),
        ]);
    }

    $user = Auth::user();

    $videos = $user->collectedVideos()->latest()->paginate(10, ['*'], 'videos_page');
    $recommendations = $user->collectedRecommendations()->latest()->paginate(10, ['*'], 'recommendations_page');

    return view('users.Koleksi', compact('videos', 'recommendations'));
}

    /**
     * Menghapus beberapa video dari koleksi.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyMultiple(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk menghapus koleksi.');
        }

        $videoIds = $request->input('video_ids', []);
        if (!is_array($videoIds)) {
            $videoIds = [$videoIds];
        }

        $request->validate([
            'video_ids' => 'required|array',
            'video_ids.*' => 'exists:videos,id',
        ]);

        $user = Auth::user();
        $detachedCount = $user->collectedVideos()->detach($videoIds);

        if ($detachedCount > 0) {
            return redirect()->route('users.koleksi')->with('success', "$detachedCount film berhasil dihapus dari koleksi Anda.");
        }

        return redirect()->route('users.koleksi')->with('error', 'Tidak ada film yang dihapus. Pastikan film yang dipilih ada di koleksi Anda.');
    }
}
