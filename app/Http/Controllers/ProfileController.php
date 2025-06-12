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

        // Validasi data yang diterima
        $validated = $request->validated();

        // Perbarui data pengguna
        $user->fill($validated);

        // Jika email berubah, reset email_verified_at
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Tangani upload foto profil
        if ($request->hasFile('profile_photo')) {
            // Buat direktori profiles jika belum ada
            $directory = 'public/profiles';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            // Hapus foto lama jika ada
            if ($user->profile_photo) {
                Storage::delete('public/profiles/' . $user->profile_photo);
            }

            // Simpan foto baru
            $path = $request->file('profile_photo')->store('public/profiles');
            $user->profile_photo = basename($path); // Simpan hanya nama file
        }

        // Simpan perubahan
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

        // Hapus foto profil saat akun dihapus
        if ($user->profile_photo) {
            Storage::delete('public/profiles/' . $user->profile_photo);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}