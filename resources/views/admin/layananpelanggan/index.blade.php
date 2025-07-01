@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Layanan Pelanggan</h2>
    <form method="POST" action="{{ route('layanan_pelanggan.update', $layanan->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="kontak">Kontak Kami</label>
            <textarea name="kontak" class="form-control" rows="3">{{ old('kontak', $layanan->kontak) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="pertanyaan">Pertanyaan Umum</label>
            <textarea name="pertanyaan" class="form-control" rows="3">{{ old('pertanyaan', $layanan->pertanyaan) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="bantuan">Bantuan Teknis</label>
            <textarea name="bantuan" class="form-control" rows="3">{{ old('bantuan', $layanan->bantuan) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif
@endpush


