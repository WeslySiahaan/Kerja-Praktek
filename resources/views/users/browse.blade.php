@extends('layouts.app2')

@section('content')

<!-- Hero Banner -->
<section class="hero-banner">
  <div class="hero-content">
    <h2>Kampung Digital</h2>
    <p>Mengisahkan perjalanan teknologi dan kehidupan masyarakat dalam satu desa.</p>
    <a href="#" class="btn btn-warning mt-2">Mulai Menonton</a>
  </div>
</section>

<!-- Dynamic Movie Sections -->
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

<!-- Footer -->
<footer>
  <div class="container text-center text-md-start">
    <div class="row">
      <div class="col-md-3">
        <h5>Tentang</h5>
        <ul class="list-unstyled">
          <li><a href="#">Syarat & Ketentuan</a></li>
          <li><a href="#">Kebijakan Privasi</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Lainnya</h5>
        <ul class="list-unstyled">
          <li><a href="#">Resource</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Kontak Kami</h5>
        <ul class="list-unstyled">
          <li><a href="mailto:support@moraclips.com">Email</a></li>
          <li><a href="#">Kolaborasi Bisnis</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Komunitas</h5>
        <ul class="list-unstyled">
          <li><a href="#">Facebook</a></li>
          <li><a href="#">YouTube</a></li>
          <li><a href="#">TikTok</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom text-center mt-3">
      © MoraClips 2025 - All rights reserved.
    </div>
  </div>
</footer>

@endsection

@push('scripts')
<!-- Swiper & Bootstrap Scripts -->
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
