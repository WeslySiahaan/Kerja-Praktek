@extends('layouts.app1')

{{-- Bagian ini khusus untuk mengisi slot navbar kategori di layout utama --}}
@section('category_navbar')
<nav class="navbar navbar-expand-lg navbar-dark" id="kategoriNavbar" style="background-color: #141414; border-top: 1px solid #333;">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <h5 class="text-white mb-0 me-4">Film</h5>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Semua Genre
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">Aksi</a></li>
                    <li><a class="dropdown-item" href="#">Komedi</a></li>
                    <li><a class="dropdown-item" href="#">Horor</a></li>
                    <li><a class="dropdown-item" href="#">Romantis</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
@endsection


{{-- Bagian ini adalah untuk konten utama halaman --}}
@section('content')

{{-- Hero Banner dan konten lainnya dimulai di sini --}}
<section class="hero-banner">
    <div class="hero-content">
        <h2>Kampung Digital</h2>
        <p>Mengisahkan perjalanan teknologi dan kehidupan masyarakat dalam satu desa.</p>
        <a href="#" class="btn btn-warning mt-2">Mulai Menonton</a>
    </div>
</section>

@php
    $sections = ['Populer', 'Terbaru', 'Top 10 Terlaris', 'Akan Tayang'];
    $movies = [
        'Final Shot', 'Operasi Senyap', 'Misi Tanpa Nama', 'Chase',
        'Blackout', 'Detik Zona Mati', 'Gedung Coklat', 'Penghancur',
        'Kunci Neraka', 'Zona 14'
    ];
@endphp

<div class="container-fluid px-4">
    @foreach ($sections as $section)
    <div class="my-4">
        <h4 class="fw-bold">{{ $section }}</h4>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ($movies as $movie)
                <div class="swiper-slide">
                    <div class="card card-movie">
                        <img src="{{ asset('poster.jpg') }}" alt="{{ $movie }}">
                        <div class="card-title">{{ $movie }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection

@push('scripts')
{{-- Script khusus untuk halaman ini (misalnya Swiper.js) akan dimasukkan ke slot @stack('scripts') di layout --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swipers = document.querySelectorAll('.swiper');
    swipers.forEach(s => {
        new Swiper(s, {
            slidesPerView: 6,
            spaceBetween: 15,
            freeMode: true,
        });
    });
</script>
@endpush