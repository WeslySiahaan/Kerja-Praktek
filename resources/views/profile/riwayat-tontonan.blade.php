@extends('layouts.app')

@section('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f5f5; /* Latar belakang halaman yang lebih terang */
        padding: 0;
        margin: 0;
    }

<<<<<<< HEAD
    /* Adaptasi gaya container dari contoh Nonaktifkan Akun */
    .history-container {
        max-width: 1300px;
        margin: 10px auto;
=======
    .history-container {
        max-width: 1300px;
        margin: 20px auto; /* Margin atas/bawah ditingkatkan */
>>>>>>> 88d25e4508cb227c90c58dfd98442cd5c4fff5b3
        background: #fff;
        padding: 30px; /* Padding sedikit dikurangi untuk tampilan lebih ringkas */
        border-radius: 16px; /* Lebih rounded */
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); /* Shadow yang lebih lembut */
    }

    h1 {
        font-family: 'Poppins', sans-serif;
<<<<<<< HEAD
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
=======
        font-size: 28px; /* Ukuran H1 sedikit lebih besar */
        font-weight: 700; /* Lebih tebal */
        margin-bottom: 25px; /* Jarak lebih baik */
        color: #212529; /* Warna teks gelap */
        text-align: left;
    }

    /* Header Riwayat Tontonan */
    .history-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px; /* Jarak lebih baik dari item pertama */
        padding-bottom: 15px; /* Spasi di bawah header */
        /* Hapus border-bottom, ganti dengan box-shadow jika diperlukan atau biarkan tanpa */
>>>>>>> 88d25e4508cb227c90c58dfd98442cd5c4fff5b3
    }

    .history-section-header h5 {
        font-weight: 600; /* Lebih tebal */
        color: #343a40; /* Warna teks gelap */
        font-size: 1.5rem; /* Ukuran lebih besar */
    }

<<<<<<< HEAD
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
=======
    /* Gaya untuk setiap item riwayat (daftar yang diperbaiki) */
    .history-item-card {
        display: flex;
        background: #fff;
        border-radius: 12px; /* Lebih rounded */
        box-shadow: 0 4px 15px rgba(0,0,0,0.06); /* Shadow lebih halus */
        margin-bottom: 25px; /* Jarak antar item */
        overflow: hidden;
        position: relative;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .history-item-card:hover {
        transform: translateY(-8px); /* Efek hover lebih menonjol */
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12); /* Shadow saat hover lebih kuat */
    }

    .history-item-card img {
        width: 150px; /* Thumbnail sedikit lebih lebar */
        height: 225px; /* Tinggi thumbnail, rasio 2:3 */
        object-fit: cover;
        flex-shrink: 0;
        border-radius: 12px 0 0 12px; /* Sudut kiri yang rounded */
    }

    .history-item-details {
        flex-grow: 1;
        padding: 20px 25px; /* Padding lebih banyak */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .history-item-details h6 {
        font-size: 1.3rem; /* Judul lebih besar */
        font-weight: 700; /* Lebih tebal */
        margin-bottom: 8px; /* Jarak */
        color: #212529;
    }

    .history-item-details .category-time {
        font-size: 0.85rem; /* Sedikit lebih kecil */
        color: #6c757d;
        margin-bottom: 15px; /* Jarak lebih banyak ke deskripsi */
    }

    .history-item-details p.description {
        font-size: 0.95rem;
        color: #495057; /* Warna teks lebih gelap */
        line-height: 1.6; /* Line height lebih baik */
        margin-bottom: 20px; /* Jarak lebih banyak ke tombol */
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Batasi 3 baris */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* GAYA UNTUK TOMBOL AKSI TONTONAN */
  .watch-action-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease, border-color 0.3s ease; /* Tambahkan border-color untuk transisi */
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Shadow sedikit lebih lembut */
    }

    .watch-action-button.continue {
        /* Opsi 1: Warna teal/cyan */
        background-color: #17a2b8; /* Bootstrap info color, atau hex kustom */
        color: #fff;
        border: 1px solid #17a2b8; /* Tambahkan border solid */

        /* Opsi 2: Transparan dengan border biru (jika Anda lebih suka kesan ringan) */
        /* background-color: transparent; */
        /* color: #007bff; */
        /* border: 1px solid #007bff; */
    }
    .watch-action-button.continue:hover {
        /* Opsi 1 hover */
        background-color: #138496;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);

        /* Opsi 2 hover */
        /* background-color: #007bff; */
        /* color: #fff; */
        /* transform: translateY(-2px); */
        /* box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12); */
    }

    .watch-action-button.watched {
        background-color: #28a745; /* Tetap hijau */
        color: #fff;
        border: 1px solid #28a745;
    }
    .watch-action-button.watched:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    }

    .watch-action-button i {
        font-size: 1.1rem; /* Ukuran ikon sedikit lebih besar */
    }
    /* END GAYA BARU */


    .delete-item-btn {
        position: absolute;
        top: 15px; /* Posisi lebih baik */
        right: 15px; /* Posisi lebih baik */
        background: rgba(255, 255, 255, 0.8); /* Latar belakang semi-transparan */
        border: none;
        border-radius: 50%; /* Bulat */
        width: 30px; /* Ukuran tombol */
        height: 30px; /* Ukuran tombol */
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        color: #999;
        cursor: pointer;
        transition: all 0.2s ease;
        z-index: 10;
    }
    .delete-item-btn:hover {
        background: #dc3545; /* Merah saat hover */
        color: #fff; /* Teks putih saat hover */
>>>>>>> 88d25e4508cb227c90c58dfd98442cd5c4fff5b3
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        padding: 5px 15px; /* Padding disesuaikan */
        border-radius: 8px; /* Lebih rounded */
        transition: all 0.2s ease;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }

<<<<<<< HEAD
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
=======
    /* Modal Styling (tetap sama) */
    .modal-body .btn-primary { background-color: #007bff; border-color: #007bff; font-family: 'Poppins', sans-serif; padding: 8px 20px; border-radius: 6px; }
    .modal-body .btn-secondary { font-family: 'Poppins', sans-serif; padding: 8px 20px; border-radius: 6px; }
    .modal-body i { font-size: 3rem; }
    .modal-header .btn-close { padding: 0.5rem; margin: -0.5rem -0.5rem -0.5rem auto; }

    /* Media queries untuk responsif */
    @media (max-width: 768px) {
        .history-container {
            padding: 20px;
            margin: 10px auto;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .history-section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .history-item-card {
            flex-direction: column;
            align-items: center;
            padding-bottom: 15px; /* Tambahkan padding bawah saat stack */
        }
        .history-item-card img {
            width: 100%;
            height: 250px; /* Tinggi di mobile */
            border-radius: 12px 12px 0 0;
            margin-bottom: 15px; /* Jarak gambar dan detail */
        }
        .history-item-details {
            padding: 0 15px;
            text-align: center;
        }
        .history-item-details h6 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        .history-item-details .category-time {
            font-size: 0.8rem;
            margin-bottom: 10px;
        }
        .history-item-details p.description {
            font-size: 0.9rem;
            -webkit-line-clamp: 2; /* Batasi deskripsi lebih pendek di mobile */
            margin-bottom: 15px;
        }
        .watch-action-button {
            width: 100%;
            justify-content: center;
            padding: 10px;
            font-size: 0.95rem;
        }
        .delete-item-btn {
            top: 10px;
            right: 10px;
            width: 25px;
            height: 25px;
            font-size: 0.9rem;
        }
>>>>>>> 88d25e4508cb227c90c58dfd98442cd5c4fff5b3
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
        <div class="history-section-header">
            <div></div> 
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#clearHistoryModal">
                    <i class="bi bi-trash"></i> Kosongkan riwayat tontonan
                </button>
            </div>
        </div>

        <div class="history-list">
            @forelse ($watchHistoryItems as $item)
<<<<<<< HEAD
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
=======
                <div class="history-item-card">
                    <img src="{{ $item->image ?: 'https://placehold.co/150x225/cccccc/ffffff?text=No+Image' }}" alt="{{ $item->title }}">
                    <div class="history-item-details">
                        <div>
                            <h6>{{ $item->title }}</h6>
                            <p class="category-time">{{ $item->category }} &bull; {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</p>
                            <p class="description">{{ $item->description }}</p>
                        </div>
                        <div class="history-item-progress-actions">
                          @if ($item->progress >= 95)
    {{-- Jika sudah selesai, tombol "Sudah Ditonton" tetap membawa ke awal video atau bisa juga ke waktu yang tersimpan, tergantung keinginan --}}
    <a href="{{ route('dramabox.detail', ['id' => $item->video_id]) }}" class="watch-action-button watched">
        <i class="bi bi-check-circle-fill"></i> Sudah Ditonton
    </a>
@else
    {{-- Untuk "Lanjutkan Menonton", kita akan tambahkan parameter reset=1 --}}
    <a href="{{ route('dramabox.detail', ['id' => $item->video_id, 'reset' => 1]) }}" class="watch-action-button continue">
        <i class="bi bi-play-circle-fill"></i> Lanjutkan Menonton
    </a>
@endif
                            <form action="{{ route('profile.riwayatTontonan.destroy', $item->id) }}" method="POST" class="d-inline" onclick="event.stopPropagation();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-item-btn" data-bs-toggle="tooltip" data-bs-placement="left" title="Hapus dari riwayat tontonan">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
>>>>>>> 88d25e4508cb227c90c58dfd98442cd5c4fff5b3
                        </div>
                    </div>
<<<<<<< HEAD
                    <form action="{{ route('profile.riwayatTontonan.destroy', $item->id) }}" method="POST" class="position-absolute top-0 end-0 mt-2 me-2" onclick="event.stopPropagation();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-close" aria-label="Close" data-bs-toggle="tooltip" data-bs-placement="left" title="Hapus dari riwayat tontonan"></button>
                    </form>
                </a>
=======
                </div>
>>>>>>> 88d25e4508cb227c90c58dfd98442cd5c4fff5b3
            @empty
                <p class="text-center text-muted py-4">Belum ada riwayat tontonan.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Modal Kosongkan Riwayat (tetap sama) --}}
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
        });
    });
</script>
@endpush