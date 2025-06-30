<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
  public function index()
  {
    // Ambil policy pertama
    $policy = PrivacyPolicy::first();

    // Jika belum ada, buat default kosong
    if (!$policy) {
      $policy = PrivacyPolicy::create([
        'history' => '',
        'usage' => '',
        'security' => '',
        'rights' => '',
        'cookies' => '',
        'changes' => '',
      ]);
    }

    // Kirim ke view
    return view('admin.privacy.index', compact('policy'));
  }

  public function update(Request $request, $id)
  {
    $validated = $request->validate([
      'history' => 'nullable|string',
      'usage' => 'nullable|string',
      'security' => 'nullable|string',
      'rights' => 'nullable|string',
      'cookies' => 'nullable|string',
      'changes' => 'nullable|string',
    ]);

    $policy = PrivacyPolicy::findOrFail($id);
    $policy->update($validated);

    return redirect()->route('privacy_policies.index')->with('success', 'Privacy policy updated successfully');
  }
}