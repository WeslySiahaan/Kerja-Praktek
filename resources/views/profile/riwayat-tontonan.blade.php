@extends('layouts.app')

@section('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f5f5;
        padding: 0;
        margin: 0;
    }

    /* Adaptasi gaya container dari contoh Nonaktifkan Akun */
    .history-container {
        max-width: 1300px;
        margin: 10px auto;
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Adaptasi gaya H1 dari contoh Nonaktifkan Akun */
    h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #000;
        text-align: left;
    }

    /* Adaptasi gaya P dari contoh Nonaktifkan Akun */
    p {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        line-height: 1.6;
        color: #333;
        text-align: justify;
        margin-bottom: 15px;
    }

    /* Gaya spesifik untuk Riwayat Tontonan */
    .history-section {
        background: #fff;
        border-radius: 10px;
        padding: 0;
        margin-bottom: 20px;
    }

    /* Gaya untuk setiap item dalam daftar */
    .list-group-item {
        border-top: 1px solid #eee;
        padding: 12px 0;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #333;
        transition: background-color 0.2s ease;
    }

    .list-group-item:first-of-type {
        border-top: none;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    /* Gambar thumbnail */
    .history-item img {
        width: 80px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 15px;
        flex-shrink: 0;
    }

    /* Konten teks (judul, kategori, deskripsi) */
    .history-item .flex-grow-1 {
        flex-grow: 1;
        flex-shrink: 1;
        min-width: 0;
    }

    /* Judul Film */
    .history-item h6 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    /* Kategori & Waktu */
    .history-item .small {
        font-size: 14px;
        color: #6c757d;
    }

    /* Deskripsi */
    .history-item p.text-truncate {
        max-width: 100%;
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-height: 1.5em;
        max-height: 3em;
    }

    /* Progress Bar */
    .history-item .progress {
        height: 5px;
        margin-top: 8px;
        margin-bottom: 5px;
        border-radius: 5px;
        background-color: #e9ecef;
    }

    .history-item .progress-bar {
        background-color: #4A90E2;
    }

    /* Tombol Kosongkan Riwayat (btn-outline-danger) */
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 6px;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }

    /* Modal Styling */
    .modal-body .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        font-family: 'Poppins', sans-serif;
        padding: 8px 20px;
        border-radius: 6px;
    }
    .modal-body .btn-secondary {
        font-family: 'Poppins', sans-serif;
        padding: 8px 20px;
        border-radius: 6px;
    }
    .modal-body i {
        font-size: 3rem;
    }
    .modal-header .btn-close {
        padding: 0.5rem;
        margin: -0.5rem -0.5rem -0.5rem auto;
    }
</style>
@endsection

@section('content')
<div class="history-container">
    <h1 class="fw-bold">Riwayat Tontonan</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="history-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0 fw-bold">Hari Ini</h5>
            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#clearHistoryModal">
                <i class="bi bi-trash"></i> Kosongkan riwayat tontonan
            </button>
        </div>

        <div class="list-group">
            @forelse ($watchHistoryItems as $item)
                <a href="{{ route('dramabox.detail', ['id' => $item->video_id]) }}" class="list-group-item list-group-item-action d-flex align-items-center py-3 position-relative history-item">
                    <img src="{{ $item->image ?: 'https://placehold.co/80x120/cccccc/ffffff?text=No+Image' }}" alt="Thumbnail" class="img-fluid rounded">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $item->title }}</h6>
                        <p class="small text-muted mb-1">Category: 
                            @if(is_array($item->category))
                                {{ implode(', ', array_map('htmlspecialchars', $item->category)) }}
                            @else
                                {{ htmlspecialchars($item->category ?? 'No Category') }}
                            @endif
                        </p>
                        <p class="mb-1 text-truncate">{{ $item->description }}</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $item->progress }}%;" aria-valuenow="{{ $item->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">{{ $item->watched_time }}</small>
                    </div>
                    <form action="{{ route('profile.riwayatTontonan.destroy', $item->id) }}" method="POST" class="position-absolute top-0 end-0 mt-2 me-2" onclick="event.stopPropagation();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-close" aria-label="Close" data-bs-toggle="tooltip" data-bs-placement="left" title="Hapus dari riwayat tontonan"></button>
                    </form>
                </a>
            @empty
                <p class="text-center text-muted py-4">Belum ada riwayat tontonan.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="modal fade" id="clearHistoryModal" tabindex="-1" aria-labelledby="clearHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-0">
                <i class="bi bi-trash-fill text-danger mb-3" style="font-size: 3rem;"></i>
                <h5 class="mb-3">Bersihkan semua riwayat tontonan?</h5>
                @auth
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                @endauth
                @guest
                    <p class="text-muted">Pengguna tidak teridentifikasi</p>
                @endguest
                <p class="mb-4">Semua riwayat tontonan Anda akan dihapus secara permanen dan tidak dapat dikembalikan. Lanjutkan?</p>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('profile.riwayatTontonan.clearAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush