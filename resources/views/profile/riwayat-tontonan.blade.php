@extends('layouts.app')

@section('styles')
<style>
    /* Font family, background, padding, margin untuk body secara global harusnya di layouts/app.blade.php */
    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f5f5;
        padding: 0;
        margin: 0;
    }

    /* H2 yang Anda definisikan di pertanyaan umum, saya samakan menjadi h1 di sini */
    h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .history-section {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        width: 100%;
        /* max-width: 100vw; Ini yang bisa menyebabkan masalah, saya sarankan dihapus jika sudah diatasi oleh kontainer Bootstrap */
    }

    /* Gaya spesifik untuk Riwayat Tontonan */
    .history-item {
        border-top: 1px solid #eee;
        padding: 12px 0;
    }

    .history-item:first-of-type {
        border-top: none;
    }

    .history-item img {
        border-radius: 8px; /* Lebih rounded dari default Bootstrap */
    }

    .history-item .progress {
        height: 5px;
        margin-top: 5px;
        border-radius: 5px; /* Rounded progress bar */
    }

    .history-item .progress-bar {
        background-color: #4A90E2; /* Warna progress bar agar sesuai tema */
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }

    .modal-body .btn-primary {
        background-color: #007bff; /* Warna biru untuk tombol "Ya" */
        border-color: #007bff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid"> {{-- Gunakan container-fluid atau container sesuai kebutuhan lebar --}}
    <h1 class="fw-bold" style="font-size: 28px; margin-bottom: 20px;">Riwayat Tontonan</h1>

    <div class="history-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">Hari Ini</h5>
            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#clearHistoryModal">
                <i class="bi bi-trash"></i> Kosongkan riwayat tontonan
            </button>
        </div>

        <div class="list-group">
            {{-- Bagian ini akan menampilkan riwayat tontonan.
                 Kamu akan mengganti loop statis ini dengan data dari database. --}}
            @php
                $watchHistoryItems = [
                    [
                        'image' => 'https://placehold.co/80x120/FF5733/ffffff?text=FILM+1',
                        'title' => 'Bidak Emas Terakhir',
                        'category' => 'Aksi / Spionase',
                        'description' => 'Seorang analis intelijen menemukan celah keamanan total dalam sistem pengawasan metropolitan Jakarta yang baru.',
                        'progress' => 70,
                        'time' => '08:30 / 12:35'
                    ],
                    [
                        'image' => 'https://placehold.co/80x120/33FF57/ffffff?text=FILM+2',
                        'title' => 'Cahaya di Balik Kabut',
                        'category' => 'Drama / Misteri',
                        'description' => 'Kisah seorang detektif yang mengungkap kebenaran di balik hilangnya seorang seniman terkenal di pegunungan terpencil.',
                        'progress' => 45,
                        'time' => '00:30 / 10:35'
                    ],
                    [
                        'image' => 'https://placehold.co/80x120/3366FF/ffffff?text=FILM+3',
                        'title' => 'Perjalanan Sang Ksatria',
                        'category' => 'Fantasi / Petualangan',
                        'description' => 'Seorang pahlawan muda memulai perjalanan epik untuk menyelamatkan kerajaannya dari ancaman kegelapan yang kuno.',
                        'progress' => 90,
                        'time' => '08:30 / 12:35'
                    ],
                    [
                        'image' => 'https://placehold.co/80x120/FF33CC/ffffff?text=FILM+4',
                        'title' => 'Senandung Malam',
                        'category' => 'Horor / Thriller',
                        'description' => 'Sebuah keluarga pindah ke rumah baru dan menemukan rahasia kelam yang menghantui masa lalu mereka.',
                        'progress' => 20,
                        'time' => '00:30 / 12:25'
                    ],
                    [
                        'image' => 'https://placehold.co/80x120/33FFFF/ffffff?text=FILM+5',
                        'title' => 'Tarian Ombak',
                        'category' => 'Romantis / Komedi',
                        'description' => 'Dua insan yang berbeda dunia bertemu di sebuah pulau tropis dan menemukan cinta di tengah perbedaan mereka.',
                        'progress' => 60,
                        'time' => '00:30 / 19:35'
                    ],
                    [
                        'image' => 'https://placehold.co/80x120/FFD700/ffffff?text=FILM+6',
                        'title' => 'Garuda Merah',
                        'category' => 'Laga / Sejarah',
                        'description' => 'Kisah heroik para pejuang kemerdekaan yang berjuang demi kebebasan tanah air.',
                        'progress' => 85,
                        'time' => '06:30 / 19:35'
                    ],
                    [
                        'image' => 'https://placehold.co/80x120/8A2BE2/ffffff?text=FILM+7',
                        'title' => 'Resonansi Hati',
                        'category' => 'Drama / Musikal',
                        'description' => 'Perjalanan seorang musisi muda yang menemukan jati diri dan cintanya melalui melodi dan harmoni.',
                        'progress' => 75,
                        'time' => '08:30 / 13:36'
                    ],
                    [
                        'image' => 'https://placehold.co/80x120/008000/ffffff?text=FILM+8',
                        'title' => 'Desa Misterius',
                        'category' => 'Horor / Pedesaan',
                        'description' => 'Sekelompok teman tersesat di desa terpencil yang menyimpan rahasia mengerikan dan entitas tak terlihat.',
                        'progress' => 30,
                        'time' => '08:30 / 12:30'
                    ]
                ];
            @endphp

            @foreach ($watchHistoryItems as $item)
                <div class="list-group-item list-group-item-action d-flex align-items-center py-3 position-relative history-item">
                    <img src="{{ $item['image'] }}" alt="Thumbnail" class="img-fluid rounded me-3" style="width: 80px; height: 120px; object-fit: cover;">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $item['title'] }}</h6>
                        <p class="small text-muted mb-1">{{ $item['category'] }}</p>
                        <p class="mb-1 text-truncate" style="max-width: 90%;">{{ $item['description'] }}</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $item['progress'] }}%;" aria-valuenow="{{ $item['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">{{ $item['time'] }}</small>
                    </div>
                    {{-- Tombol 'X' untuk hapus individual --}}
                    <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2" aria-label="Close" data-bs-toggle="tooltip" data-bs-placement="left" title="Hapus dari riwayat tontonan"></button>
                </div>
            @endforeach
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
                    <button type="button" class="btn btn-primary">Ya</button> {{-- Di sini kamu akan menambahkan action untuk menghapus --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Menginisialisasi Tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@ewndpush