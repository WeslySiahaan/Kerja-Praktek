<?php

namespace App\Http\Controllers;

use App\Models\UserAgreement;
use Illuminate\Http\Request;

class PersetujuanPenggunaController extends Controller
{
  public function index()
  {
    $agreement = UserAgreement::first();

    if (!$agreement) {
      $agreement = UserAgreement::create([
        'ketentuan_umum' => '',
        'hak_kekayaan_intelektual' => '',
        'akun_pengguna' => '',
        'pembatasan_tanggung_jawab' => '',
        'penghentian_layanan' => '',
        'kontak' => '',
      ]);
    }

    return view('admin.persetujuan.indexx', compact('agreement'));

  }

  public function update(Request $request, $id)
  {
    try {
      $validated = $request->validate([
        'ketentuan_umum' => 'nullable|string',
        'hak_kekayaan_intelektual' => 'nullable|string',
        'akun_pengguna' => 'nullable|string',
        'pembatasan_tanggung_jawab' => 'nullable|string',
        'penghentian_layanan' => 'nullable|string',
        'kontak' => 'nullable|string',
      ]);

      $agreement = UserAgreement::findOrFail
      ($id);
      $agreement->update($validated);

      return redirect()->route('user_agreements.index')->with('success', 'Persetujuan pengguna diperbarui dengan sukses');
    } catch (\Exception $e) {
      return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui persetujuan: ' . $e->getMessage())->withInput();
    }
  }
}
