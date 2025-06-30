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

}
