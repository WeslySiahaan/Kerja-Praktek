<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function editAll()
    {
        $faqs = Faq::all()->groupBy('kategori');
        return view('admin.pertanyaanumum.edit', compact('faqs'));
    }
    public function updateAll(Request $request)
    {
        if (!is_array($request->faq)) {
            return back()->withErrors(['faq' => 'Tidak ada data yang dikirim.']);
        }

        foreach ($request->faq as $id => $jawaban) {
            $faq = Faq::find($id);
            if ($faq) {
                $faq->jawaban = $jawaban;
                if (isset($request->pertanyaan[$id])) {
                    $faq->pertanyaan = $request->pertanyaan[$id];
                }
                $faq->save();
            }
        }

        return redirect()->back()->with('success', 'Semua FAQ berhasil diperbarui!');
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

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }

    public function destroyKategori($kategori)
    {
        Faq::where('kategori', $kategori)->delete();

        return redirect()->route('faq.editAll')->with('success', "Kategori '$kategori' berhasil dihapus.");
    }
}
