<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

            // Simpan file baru di 'storage/app/public/profiles'
            // dan simpan path relatifnya ke database.
            $path = $request->file('profile_photo')->store('profiles', 'public');
            
            // Simpan path ke kolom yang benar di database
            $user->profile_photo_path = $path; 
        }
        // --- AKHIR PERUBAHAN ---

        // Simpan semua perubahan (nama, email, dan path foto)
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

    public function pertanyaanUmum()
{
    return view('profile.pertanyaanUmum');
}

   public function layananPelanggan()
{
    return view('profile.layananPelanggan');

}

   public function hubungi()
{
    return view('profile.hubungi');

}
}
