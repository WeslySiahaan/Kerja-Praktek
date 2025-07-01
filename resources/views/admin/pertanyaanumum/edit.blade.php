@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fw-bold">Kelola Pertanyaan Umum</h1>
    <a href="{{ route('faq.create') }}" class="btn btn-success">
      <i class="bi bi-plus-circle"></i> Tambah Pertanyaan
    </a>
  </div>

  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  {{-- Form utama --}}
  <form action="{{ route('faq.updateAll') }}" method="POST">
    @csrf
    @method('PUT')

    @forelse ($faqs as $kategori => $faqList)
    <div class="mb-4 p-3 bg-white rounded border shadow-sm position-relative">
      {{-- Header kategori --}}
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="text-primary mb-0">{{ $kategori }}</h5>

        <button type="button" class="btn btn-sm btn-danger" onclick="submitDeleteKategori('{{ $kategori }}')">
          <i class="bi bi-trash3"></i> Hapus Kategori
        </button>
      </div>

      {{-- Daftar pertanyaan --}}
      @foreach ($faqList as $i => $faq)
      <div class="mb-4">
        {{-- Pertanyaan --}}
        <label class="form-label fw-semibold">
          <i class="bi bi-question-circle-fill text-primary me-1"></i>
          {{ $i + 1 }}. Pertanyaan:
        </label>
        <input type="text" name="pertanyaan[{{ $faq->id }}]" class="form-control mb-2"
          value="{{ old("pertanyaan.$faq->id", $faq->pertanyaan) }}" required>

        {{-- Jawaban --}}
        <label class="form-label">Jawaban:</label>
        <textarea name="faq[{{ $faq->id }}]" class="form-control summernote" required>{{ old("faq.$faq->id", $faq->jawaban) }}</textarea>

        {{-- Preview --}}
        <div class="mt-2">
          <label class="form-label text-muted">Preview Jawaban:</label>
          <div class="border rounded p-3 bg-light">{!! $faq->jawaban !!}</div>
        </div>

        {{-- Tombol hapus pertanyaan --}}
        <button type="button" class="btn btn-outline-danger btn-sm mt-2" onclick="submitDeletePertanyaan({{ $faq->id }})">
          <i class="bi bi-trash3"></i> Hapus Pertanyaan
        </button>
      </div>
      @endforeach
    </div>
    @empty
    <p class="text-muted">Belum ada pertanyaan yang tersedia.</p>
    @endforelse

    {{-- Tombol Simpan --}}
    <div class="text-end mt-4">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save2 me-1"></i> Simpan Perubahan
      </button>
    </div>
  </form>

  {{-- Form tersembunyi untuk hapus pertanyaan --}}
  <form id="delete-pertanyaan-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
  </form>

  </form> <!-- akhir form utama -->
  {{-- ganti bagian ini --}}
  <form id="delete-kategori-form" method="POST" style="display:none;" action="">
    @csrf
    @method('DELETE')
  </form>

  <script>
    function submitDeleteKategori(kategori) {
      if (confirm('Yakin hapus seluruh kategori ini?')) {
        const form = document.getElementById('delete-kategori-form');
        form.action = "{{ url('/admin/pertanyaan-umum/delete-kategori') }}/" + encodeURIComponent(kategori);
        form.submit();
      }
    }
  </script>
</div>
@endsection