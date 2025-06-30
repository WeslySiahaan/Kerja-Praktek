<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function editAll()
    {
        $faqs = \App\Models\Faq::orderBy('id')->get();
        return view('admin.pertanyaanUmum.edit', compact('faqs'));
    }

    public function updateAll(Request $request)
    {
        foreach ($request->faq as $id => $jawaban) {
            \App\Models\Faq::where('id', $id)->update(['jawaban' => $jawaban]);
        }

        return redirect()->route('faq.editAll')->with('success', 'Semua FAQ berhasil diperbarui!');
    }

    public function create()
    {
        return view('admin.pertanyaanUmum.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
        ]);

        Faq::create($request->only(['kategori', 'pertanyaan', 'jawaban']));

        return redirect()->route('faq.editAll')->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    public function showToUser()
{
    $faqs = Faq::all()->groupBy('kategori');
    return view('user.profile.faq', compact('faqs'));
}

}
