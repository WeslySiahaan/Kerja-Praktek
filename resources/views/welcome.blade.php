@extends('layouts.app1')

@section('content')
<!-- Import Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Upcoming Section -->
<section class="position-relative">
    <div class="swiper netflixSwiper">
        <div class="swiper-wrapper">
            @foreach ($upcomings as $upcoming)
                <div class="swiper-slide position-relative" style="height: 90vh;">
                    <!-- Video/Image Container -->
                    <div class="video-container position-relative w-100 h-100" style="overflow: hidden;">
                        <div class="video-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index: 1;"></div>
                        
                        @if ($upcoming->trailer_url)
                            <video class="w-100 h-100" style="object-fit: cover; object-position: center;" 
                                   autoplay muted loop playsinline>
                                <source src="{{ $upcoming->trailer_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <img src="{{ $upcoming->poster_url ?? asset('Drama__box.png') }}" 
                                 alt="{{ $upcoming->title ?? 'Upcoming Film' }}"
                                 class="w-100 h-100" style="object-fit: cover; object-position: center;">
                        @endif
                    </div>

                    <!-- Content Overlay -->
                    <div class="content-overlay position-absolute text-white" style="top: 13%; left: 3%; z-index: 3; max-width: 30%;">
                        @if ($upcoming->poster_url)
                            <img src="{{ $upcoming->poster_url }}" 
                                 alt="{{ $upcoming->title }}"
                                 class="mb-4 rounded" 
                                 style="width: 200px; height: 250px; box-shadow: 0 0 10px #000; object-fit: cover;">
                        @endif

                        <h1 class="fw-bold mb-2">{{ $upcoming->title }}</h1>
                        <div class="upcoming-meta" style="transition: margin-top 0.6s ease;">
                            <p class="text-white-50 mb-3">
                                {{ $upcoming->category ? (is_array($upcoming->category) ? implode(', ', $upcoming->category) : $upcoming->category) : 'No category available' }}
                            </p>
                            <div class="d-flex gap-3">
                                <a href="{{ route('dramabox.detail', ['id' => $upcoming->id]) }}"
                                   class="btn btn-light text-dark fw-semibold px-4 py-2 d-flex align-items-center gap-2 fs-5">
                                    <i class="bi bi-play-fill"></i> Play
                                </a>
                                <button type="button" 
                                        class="btn btn-secondary fw-semibold px-4 py-2 d-flex align-items-center gap-2 fs-5"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#detailModal{{ $upcoming->id }}">
                                    <i class="bi bi-info-circle"></i> More Info
                                </button>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="detailModal{{ $upcoming->id }}" tabindex="-1" 
                             aria-labelledby="detailModalLabel{{ $upcoming->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title" id="detailModalLabel{{ $upcoming->id }}">{{ $upcoming->title }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-4">
                                            <div class="col-md-4">
                                                <img src="{{ $upcoming->poster_url ?? asset('Drama__box.png') }}" 
                                                     alt="{{ $upcoming->title }}"
                                                     class="img-fluid rounded" 
                                                     style="height: 300px; object-fit: cover;">
                                            </div>
                                            <div class="col-md-8">
                                                <p class="text-muted mb-2">
                                                    {{ $upcoming->year ?? 'Year N/A' }} | 
                                                    {{ $upcoming->duration ?? 'Duration N/A' }} | 
                                                    {{ $upcoming->rating ?? 'Rating N/A' }}
                                                </p>
                                                <p>{{ $upcoming->synopsis ?? 'No synopsis available' }}</p>
                                                <p><small class="text-muted">Cast: {{ $upcoming->cast ?? 'Cast N/A' }}</small></p>
                                                <p><small class="text-muted">Genre: {{ $upcoming->genre ?? 'Genre N/A' }}</small></p>
                                                <p><small class="text-muted">Category: {{ $upcoming->category ? (is_array($upcoming->category) ? implode(', ', $upcoming->category) : $upcoming->category) : 'No category available' }}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- <div class="swiper-button-next"></div> -->
        <!-- <div class="swiper-button-prev"></div> -->
    </div>
</section>

<!-- Popular Videos Section -->
<section class="container-fluid" style="margin-top: -120px; position: relative; z-index: 10;">
    <h2 class="display-6 fw-bold mb-4 px-3">Popular</h2>

    @if ($videos->isEmpty())
        <p class="text-center text-muted py-4 px-3">No popular videos available at the moment.</p>
    @else
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3">
            @foreach ($videos as $video)
                <div class="col">
                    <a href="{{ route('dramabox.detail', ['id' => $video->id]) }}" class="text-decoration-none text-white">
                        <div class="card bg-dark text-white h-100 d-flex flex-column">
                            <img src="{{ $video->poster_image ? asset('storage/' . $video->poster_image) : asset('Drama__box.png') }}"
                                 class="card-img-top" 
                                 alt="{{ $video->name }} poster"
                                 style="height: 300px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate">{{ $video->name }}</h5>
                                <p class="card-text mb-2">
                                    <small>★ {{ $video->rating ?? 'N/A' }}</small> |
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

<!-- Popular Movies Section -->
<section class="container-fluid mb-5">
    <h2 class="display-6 fw-bold mb-4 px-3">Popular Movies</h2>

    @if ($populars->isEmpty())
        <p class="text-center text-muted py-4 px-3">No popular movies available at the moment.</p>
    @else
        <div class="swiper moviePopularSwiper">
            <div class="swiper-wrapper">
                @foreach ($populars as $popular)
                    <div class="swiper-slide" style="width: 250px;">
                        <div class="card bg-dark text-white h-100 d-flex flex-column">
                            <img src="{{ $popular->poster_url ?? asset('Drama__box.png') }}"
                                 class="card-img-top" 
                                 alt="{{ $popular->title }}"
                                 style="height: 300px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate">{{ $popular->title }}</h5>
                                <p class="card-text mb-2">
                                    <small>★ {{ $popular->rating ?? 'N/A' }}</small> |
                                    <small>{{ $popular->duration ?? '01:30' }} HD</small>
                                </p>
                                <p class="card-text">{{ Str::limit($popular->description, 100) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next movie-swiper-next"></div>
            <div class="swiper-button-prev movie-swiper-prev"></div>
            <div class="swiper-scrollbar"></div>
        </div>
    @endif
</section>

<!-- Styles -->
<style>
    .video-overlay::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 40%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        z-index: 2;
    }

    .swiper {
        width: 100%;
        overflow-x: auto;
    }

    .swiper-slide {
        flex-shrink: 0;
        width: 250px;
        height: auto;
    }

    .card {
        height: 100%;
        margin: 0;
    }
</style>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Netflix Swiper (Upcoming)
        new Swiper('.netflixSwiper', {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            grabCursor: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            on: {
                slideChangeTransitionEnd: function() {
                    this.slides.forEach(slide => {
                        const video = slide.querySelector('video');
                        if (video) video.pause();
                    });
                    const activeVideo = this.slides[this.activeIndex].querySelector('video');
                    if (activeVideo) activeVideo.play();
                },
                init: function() {
                    const firstVideo = this.slides[this.activeIndex].querySelector('video');
                    if (firstVideo) firstVideo.play();
                }
            }
        });

        // Movie Popular Swiper
        new Swiper('.moviePopularSwiper', {
            slidesPerView: 'auto',
            spaceBetween: 15,
            freeMode: true,
            grabCursor: true,
            navigation: {
                nextEl: '.movie-swiper-next',
                prevEl: '.movie-swiper-prev',
            },
            scrollbar: { el: '.swiper-scrollbar' },
            breakpoints: {
                320: { slidesPerView: 2.3, spaceBetween: 10 },
                480: { slidesPerView: 3.3, spaceBetween: 15 },
                640: { slidesPerView: 4.3, spaceBetween: 20 },
                768: { slidesPerView: 5.3, spaceBetween: 20 },
                1024: { slidesPerView: 6.3, spaceBetween: 25 },
                1200: { slidesPerView: 7.3, spaceBetween: 25 }
            }
        });
    });
</script>
@endsection