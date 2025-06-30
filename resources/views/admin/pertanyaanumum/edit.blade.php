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

  <form action="{{ route('faq.updateAll') }}" method="POST" class="bg-white p-4 rounded shadow-sm border">
    @csrf
    @method('PUT')

    @forelse ($faqs as $index => $faq)
    <div class="mb-4">
      <label class="form-label fw-semibold">
        <i class="bi bi-question-circle-fill text-primary me-1"></i>
        {{ $index + 1 }}. {{ $faq->pertanyaan }}
      </label>
      <textarea name="faq[{{ $faq->id }}]" class="form-control d-none" id="jawaban-{{ $faq->id }}" required>{{ old("faq.$faq->id", $faq->jawaban) }}</textarea>
      <trix-editor input="jawaban-{{ $faq->id }}"></trix-editor>

    </div>
    @empty
    <p class="text-muted">Belum ada pertanyaan yang tersedia.</p>
    @endforelse

    <div class="text-end">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save2 me-1"></i> Simpan Perubahan
      </button>
    </div>
  </form>
</div>
@endsection