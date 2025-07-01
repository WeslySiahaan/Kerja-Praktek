<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Models\UserAgreement;
use App\Models\LayananPelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\WatchHistory;
use Carbon\Carbon; 

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Perbarui data pengguna (nama dan email)
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // --- START PERUBAHAN ---
        // Tangani upload foto profil
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada, menggunakan nama kolom yang benar
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // --- START PERUBAHAN ---
        // Hapus foto profil saat akun dihapus, menggunakan nama kolom yang benar
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        // --- AKHIR PERUBAHAN ---

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    public function pertanyaanUmum()
    {
        return view('profile.pertanyaanUmum');
    }

    public function layananPelanggan()
{
    $policies = LayananPelanggan::all(); // <-- GANTI dari $agreements jadi $policies
    return view('profile.layananPelanggan', compact('policies'));
}

    public function pengaturan()
    {
        return view('profile.pengaturan');
    }

    public function persetujuan()
{
    $policies = UserAgreement::all(); // <-- GANTI dari $agreements jadi $policies
    return view('profile.persetujuan', compact('policies'));
}


    public function kebijakan()
    {
        $policies = PrivacyPolicy::all(); // Fetch all privacy policies from the database
        return view('profile.kebijakan', compact('policies'));
    }


     public function riwayatTontonan(): View
    {
        return view('profile.riwayat-tontonan', [
        ]);
    }


    public function showWatchHistory(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Ambil semua riwayat tontonan untuk user yang sedang login
        // Urutkan berdasarkan updated_at terbaru
        $watchHistoryItems = WatchHistory::where('user_id', $user->id)
                                        ->latest('updated_at')
                                        ->get();

        foreach ($watchHistoryItems as $item) {
            // Pastikan relasi video ada dan durasi tersedia
            // Jika Anda menyimpan total_duration di WatchHistory, gunakan $item->total_duration
            $totalDuration = $item->video->duration ?? 0;

            if ($totalDuration > 0) {
                $watchedSecondsToUse = min($item->watched_seconds, $totalDuration);
                $item->progress = min(100, round(($watchedSecondsToUse / $totalDuration) * 100));
            } else {
                $item->progress = 0;
            }

            $item->watched_time_formatted = $this->formatTime($item->watched_seconds);
            $item->total_duration_formatted = $this->formatTime($totalDuration);
            $item->description = $item->video->description ?? 'Tidak ada deskripsi.'; // Ambil deskripsi dari model Video
            $item->category = $item->video->category->name ?? 'Tidak ada kategori.'; // Ambil kategori dari model Video (sesuaikan)
        }

        // Hanya kirim watchHistoryItems ke view, tanpa variabel filter tanggal
        return view('profile.riwayat-tontonan', compact('watchHistoryItems'));
    }

    private function formatTime($seconds) {
        if ($seconds === null || !is_numeric($seconds)) { // Tambahkan validasi is_numeric
            return "00:00:00";
        }
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $secs = $seconds % 60;
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $secs);
    }
}
