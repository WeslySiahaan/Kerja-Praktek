@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h1 class="mb-4">Tambah Pertanyaan Umum</h1>

  <form action="{{ route('faq.store') }}" method="POST" class="bg-light p-4 rounded shadow-sm">
    @csrf

    <div class="mb-3">
      <label for="kategori" class="form-label">Kategori</label>
      <input type="text" name="kategori" class="form-control" required value="{{ old('kategori') }}">
    </div>

    <div class="mb-3">
      <label for="pertanyaan" class="form-label">Pertanyaan</label>
      <textarea name="pertanyaan" class="form-control" rows="3" required>{{ old('pertanyaan') }}</textarea>
    </div>

    <div class="mb-3">
      <label for="jawaban" class="form-label">Jawaban</label>
      <textarea name="jawaban" class="form-control" rows="5" required>{{ old('jawaban') }}</textarea>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('faq.editAll') }}" class="btn btn-secondary">Kembali</a>
  </form>
</div>
@endsection
