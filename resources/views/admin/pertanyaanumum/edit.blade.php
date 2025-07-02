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

  <form action="{{ route('faq.updateAll') }}" method="POST">
    @csrf
    @method('PUT')

    @forelse ($faqs as $kategori => $faqList)
    <div class="mb-4 p-3 bg-white rounded border shadow-sm position-relative">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="text-primary mb-0">{{ $kategori }}</h5>

        <button type="button" class="btn btn-sm btn-danger" onclick="submitDeleteKategori('{{ $kategori }}')">
          <i class="bi bi-trash3"></i> Hapus Kategori
        </button>
      </div>

      @foreach ($faqList as $i => $faq)
      <div class="mb-4">
        <label class="form-label fw-semibold">
          <i class="bi bi-question-circle-fill text-primary me-1"></i>
          {{ $i + 1 }}. Pertanyaan:
        </label>
        <input type="text" name="pertanyaan[{{ $faq->id }}]" class="form-control mb-2"
          value="{{ old("pertanyaan.$faq->id", $faq->pertanyaan) }}" required>

        <label class="form-label">Jawaban:</label>
        <textarea name="faq[{{ $faq->id }}]" class="form-control summernote" required>{{ old("faq.$faq->id", $faq->jawaban) }}</textarea>

        <div class="mt-2">
          <label class="form-label text-muted">Preview Jawaban:</label>
          <div class="border rounded p-3 bg-light">{!! $faq->jawaban !!}</div>
        </div>

        <button type="button" class="btn btn-outline-danger btn-sm mt-2" onclick="submitDeletePertanyaan({{ $faq->id }})">
          <i class="bi bi-trash3"></i> Hapus Pertanyaan
        </button>
      </div>
      @endforeach
    </div>
    @empty
    <p class="text-muted">Belum ada pertanyaan yang tersedia.</p>
    @endforelse

    <div class="text-end mt-4">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save2 me-1"></i> Simpan Perubahan
      </button>
    </div>
  </form>

  {{-- Modal Konfirmasi --}}
  <div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formKonfirmasiHapus" method="POST">
          @csrf
          @method('DELETE')
          <div class="modal-header">
            <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            <p id="hapusMessage">Apakah Anda yakin ingin menghapus item ini?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(function() {
    $('.summernote').summernote({
      height: 150
    });

    $('form').on('submit', function() {
      $('.summernote').each(function() {
        $(this).val($(this).summernote('code'));
      });
    });

    window.modalHapus = new bootstrap.Modal(document.getElementById('modalKonfirmasiHapus'));
    window.deleteForm = document.getElementById('formKonfirmasiHapus');
    window.deleteMessage = document.getElementById('hapusMessage');
  });

  function submitDeletePertanyaan(id) {
    if (!modalHapus || !deleteForm || !deleteMessage) {
      alert('Gagal memuat modal hapus.');
      return;
    }
    deleteForm.action = `/admin/pertanyaan-umum/${id}`;
    deleteMessage.innerText = 'Yakin ingin menghapus pertanyaan ini?';
    modalHapus.show();
  }

  function submitDeleteKategori(kategori) {
    if (!modalHapus || !deleteForm || !deleteMessage) {
      alert('Gagal memuat modal hapus.');
      return;
    }
    deleteForm.action = `/admin/pertanyaan-umum/delete-kategori/${encodeURIComponent(kategori)}`;
    deleteMessage.innerText = `Yakin ingin menghapus semua pertanyaan dalam kategori "${kategori}"?`;
    modalHapus.show();
  }
</script>
@endpush