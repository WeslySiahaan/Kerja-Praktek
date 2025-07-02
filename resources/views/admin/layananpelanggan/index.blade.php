@extends('layouts.app')


@section('content')
<div class="container mt-5">
    <h2 class="fw-bold mb-4">Edit Layanan Pelanggan</h2>
    <form method="POST" action="{{ route('layanan_pelanggan.update', $layanan->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <div class="border-bottom border-2 border-primary mb-2">
                <h5 class="fw-bold">Kontak Kami</h5>
            </div>
            <textarea name="kontak" class="form-control" rows="3">{{ old('kontak', $layanan->kontak) }}</textarea>
        </div>

        <div class="mb-4">
            <div class="border-bottom border-2 border-primary mb-2">
                <h5 class="fw-bold">Pertanyaan Umum</h5>
            </div>
            <textarea name="pertanyaan" class="form-control" rows="3">{{ old('pertanyaan', $layanan->pertanyaan) }}</textarea>
        </div>

        <div class="mb-4">
            <div class="border-bottom border-2 border-primary mb-2">
                <h5 class="fw-bold">Bantuan Teknis</h5>
            </div>
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


