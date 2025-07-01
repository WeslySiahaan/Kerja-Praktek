<?php

namespace App\Http\Controllers;

use App\Models\LayananPelanggan;
use Illuminate\Http\Request;

class LayananPelangganController extends Controller
{
    // Tampilan user
    public function index()
    {
        $layanan = LayananPelanggan::first();

        if (!$layanan) {
            $layanan = new LayananPelanggan([
                'kontak' => '',
                'pertanyaan' => '',
                'bantuan' => '',
            ]);
        }

        return view('profile.layananPelanggan', compact('layanan'));
    }

    // Tampilan form edit admin
    public function edit()
{
    $layanan = LayananPelanggan::first();
    if (!$layanan) {
        $layanan = LayananPelanggan::create([
            'kontak' => '',
            'pertanyaan' => '',
            'bantuan' => '',
        ]);
    }
    return view('admin.layananpelanggan.index', compact('layanan'));
}


    // Simpan perubahan dari admin
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kontak' => 'nullable|string',
            'pertanyaan' => 'nullable|string',
            'bantuan' => 'nullable|string',
        ]);

        $layanan = LayananPelanggan::findOrFail($id);
        $layanan->update($validated);

        return redirect()->route('layanan_pelanggan.edit')->with('success', 'Data layanan pelanggan diperbarui.');
    }
}
