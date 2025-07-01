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

}

