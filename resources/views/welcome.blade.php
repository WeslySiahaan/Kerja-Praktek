@extends('layouts.app1')

@section('content')
<!-- Up Coming Fullscreen Slider -->
<section class="position-relative">
  <div class="swiper netflixSwiper">
    <div class="swiper-wrapper">
      @foreach ($upcomings as $upcoming)
        <div class="swiper-slide position-relative" style="height: 90vh;">
          <!-- Overlay -->
          <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.5); z-index: 1;"></div>

          <!-- Background Video -->
          <div class="w-100" style="height: 90vh; overflow: hidden; position: relative; padding-bottom: 0;">
            @if($upcoming->trailer)
              <video class="w-100 h-100" style="object-fit: cover; object-position: center; height: 100%;" autoplay muted loop>
                <source src="{{ $upcoming->trailer_url }}" type="video/mp4">
                Browser Anda tidak mendukung tag video.
              </video>
            @else
              <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark text-white">
                <p class="text-center">Trailer tidak tersedia.</p>
              </div>
            @endif
          </div>
          <!-- Poster dan Text -->
          <div class="position-absolute text-white" style="top: 13%; left: 3%; z-index: 2; max-width: 30%;">
            @if($upcoming->poster)
              <img src="{{ $upcoming->poster_url }}" alt="{{ $upcoming->title }}"
                style="width: 200px; height: 250px; margin-bottom: 2rem; border-radius: 8px; box-shadow: 0 0 10px #000; object-fit: cover;">
            @endif
            <h1 class="fw-bold mb-2">{{ $upcoming->title }}</h1>

            <div class="upcoming-meta" style="transition: margin-top 0.6s ease;">
              <p class="text-white-50 mb-3">{{ $upcoming->category ? implode(', ', $upcoming->category) : 'Kategori belum tersedia.' }}</p>
              <div class="d-flex gap-3">
                <a href="{{ route('dramabox.detail', ['id' => $upcoming->id]) }}"
                  class="btn btn-light text-dark fw-semibold px-4 py-2 d-flex align-items-center gap-2 fs-5">
                  <i class="bi bi-play-fill"></i> Putar
                </a>
                <button type="button" class="btn btn-secondary fw-semibold px-4 py-2 d-flex align-items-center gap-2 fs-5"
                  data-bs-toggle="modal" data-bs-target="#detailModal{{ $upcoming->id }}">
                  <i class="bi bi-info-circle"></i> Selengkapnya
                </button>
              </div>
              <!-- Modal -->
              <div class="modal fade" id="detailModal{{ $upcoming->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $upcoming->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content bg-dark text-white">
                    <div class="modal-header border-0">
                      <h5 class="modal-title" id="detailModalLabel{{ $upcoming->id }}">{{ $upcoming->title }}</h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row g-4">
                        <div class="col-md-4">
                          <img src="{{ $upcoming->poster_url }}" alt="{{ $upcoming->title }}"
                            class="img-fluid rounded" style="width: 100%; height: 300px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                          <p class="text-muted mb-2">{{ $upcoming->year ?? 'Tahun tidak tersedia' }} | {{ $upcoming->duration ?? 'Durasi tidak tersedia' }} | {{ $upcoming->rating ?? 'Rating tidak tersedia' }}</p>
                          <p>{{ $upcoming->synopsis ?? 'Sinopsis tidak tersedia.' }}</p>
                          <p><small class="text-muted">Pemeran: {{ $upcoming->cast ?? 'Pemeran tidak tersedia.' }}</small></p>
                          <p><small class="text-muted">Genre: {{ $upcoming->genre ?? 'Genre tidak tersedia.' }}</small></p>
                          <p><small class="text-muted">Kategori: {{ $upcoming->category ? implode(', ', $upcoming->category) : 'Kategori belum tersedia.' }}</small></p>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer border-0">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="container my-4">
  <h1 class="display-5 fw-bold mb-4">populer</h1>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if ($videos->isEmpty())
    <p class="text-center text-muted py-4">Tidak ada video yang diunggah.</p>
  @else
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
      @foreach ($videos as $video)
        <div class="col">
          <a href="{{ route('dramabox.detail', ['id' => $video->id]) }}" class="text-decoration-none text-white">
            <div class="card bg-dark text-white h-100 d-flex flex-column">
              @if ($video->video_file)
                <video
                  class="card-img-top w-100"
                  preload="metadata"
                  muted
                  style="height: 300px; object-fit: cover;">
                  <source src="{{ asset('videos/' . $video->video_file) }}" type="video/mp4">
                </video>
              @else
                <img
                  src="{{ asset('Drama__box.png') }}"
                  class="card-img-top w-100"
                  alt="{{ $video->name }}"
                  style="height: 300px; object-fit: cover;">
              @endif
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-truncate">{{ $video->name }}</h5>
                <p class="card-text mb-2">
                  <small>★ {{ $video->rating ?? rand(5, 7) . '.' . rand(0, 9) }}</small> |
                  <small>{{ $video->duration ?? '01:30' }} HD</small>
                </p>
                <p class="card-text">{{ Str::limit($video->description, 100) }}</p>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  @endif
</section>

<section class="container my-4">
  <h1 class="display-5 fw-bold mb-4">Film Populer</h1>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if ($populars->isEmpty())
    <p class="text-center text-muted py-4">Tidak ada film populer yang diunggah.</p>
  @else
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
      @foreach ($populars as $popular)
        <div class="col">
          <div class="card bg-dark text-white h-100 d-flex flex-column">
            @if ($popular->poster_url)
              <img
                src="{{ $popular->poster_url }}"
                class="card-img-top w-100"
                alt="{{ $popular->title }}"
                style="height: 300px; object-fit: cover;">
            @else
              <img
                src="{{ asset('Drama__box.png') }}"
                class="card-img-top w-100"
                alt="{{ $popular->title }}"
                style="height: 300px; object-fit: cover;">
            @endif
            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-truncate">{{ $popular->title }}</h5>
              <p class="card-text mb-2">
                <small>★ {{ $popular->rating ?? rand(5, 7) . '.' . rand(0, 9) }}</small> |
                <small>{{ $popular->duration ?? '01:30' }} HD</small>
              </p>
              <p class="card-text">{{ Str::limit($popular->description, 100) }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  new Swiper('.netflixSwiper', {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    autoplay: {
      delay: 6000,
      disableOnInteraction: false,
    },
    effect: 'slide',
    grabCursor: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
</script>
@endsection