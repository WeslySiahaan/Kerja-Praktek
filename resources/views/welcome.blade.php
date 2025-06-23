@extends('layouts.app1')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<section class="position-relative">
    <div class="swiper netflixSwiper">
        <div class="swiper-wrapper">
            @foreach ($upcomings as $upcoming)
                <div class="swiper-slide position-relative" style="height: 90vh;">
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
                                        data-bs-target="#globalDetailModal"
                                        data-id="{{ $upcoming->id }}"
                                        data-title="{{ $upcoming->title }}"
                                        data-description="{{ $upcoming->description }}"
                                        data-poster-url="{{ $upcoming->poster_url ?? asset('Drama__box.png') }}"
                                        data-trailer-url="{{ $upcoming->trailer_url ?? '' }}"
                                        data-category="{{ is_array($upcoming->category) ? implode(', ', $upcoming->category) : $upcoming->category }}"
                                        data-year="{{ $upcoming->year ?? 'N/A' }}"
                                        data-duration="{{ $upcoming->duration ?? 'N/A' }}"
                                        data-rating="{{ $upcoming->rating ?? 'N/A' }}"
                                        data-synopsis="{{ $upcoming->synopsis ?? 'No synopsis available' }}"
                                        data-cast="{{ $upcoming->cast ?? 'N/A' }}"
                                        data-genre="{{ $upcoming->genre ?? 'N/A' }}"
                                        >
                                    <i class="bi bi-info-circle"></i> More Info
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="container-fluid" style="margin-top: 5px;position: relative; z-index: 10; margin-bottom: 20px;">  
    <h2 class="display-6 fw-bold mb-4 px-3">Popular</h2>

    @if (session('error'))
        <div class="alert alert-danger px-3">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success px-3">{{ session('success') }}</div>
    @endif

    @if ($videos->isEmpty())
        <p class="text-center text-muted py-4 px-3">No popular videos available at the moment.</p>
    @else
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3">
            @foreach ($videos as $video)
                <div class="col">
                    <div class="card bg-dark text-white h-100 d-flex flex-column">
                        <a href="{{ route('video.detail', ['id' => $video->id]) }}" class="text-decoration-none text-white">
                            <img src="{{ $video->poster_image ? asset('storage/' . $video->poster_image) : asset('Drama__box.png') }}"
                                 class="card-img-top" 
                                 alt="{{ $video->name }} poster"
                                 style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate">{{ $video->name }}</h5>
                            <p class="card-text">{{ Str::limit($video->description, 100) }}</p>
                            <p class="card-title text-truncate">Ep {{ count($video->episodes ?? []) }}</p>
                            <div class="mt-auto d-flex gap-2">
                                @if (Auth::check())
                                    <form action="{{ route('videos.like', $video) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 like-btn" title="{{ $video->likedByUsers->contains(Auth::id()) ? 'Batal Suka' : 'Suka' }}">
                                            <i class="bi {{ $video->likedByUsers->contains(Auth::id()) ? 'bi-heart-fill text-danger' : 'bi-heart text-white' }} fs-5"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('videos.save', $video) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0" title="{{ $video->collectedByUsers->contains(Auth::id()) ? 'Sudah Disimpan' : 'Simpan' }}"
                                                {{ $video->collectedByUsers->contains(Auth::id()) ? 'disabled' : '' }}>
                                            <i class="bi {{ $video->collectedByUsers->contains(Auth::id()) ? 'bi-bookmark-fill text-success' : 'bi-bookmark text-white' }} fs-5"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
         <!-- Pagination -->
<div style="margin-top: 20px;" class="d-flex justify-content-center">
  {{ $videos->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>
    @endif
</section>

<div class="modal fade" id="globalDetailModal" tabindex="-1"
     aria-labelledby="globalDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="globalDetailModalLabel"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <img id="modalPoster" src="" alt="Poster" class="img-fluid rounded" style="height: 300px; object-fit: cover;">
                    </div>
                    <div class="col-md-8">
                        <p class="text-muted mb-2">
                            <span id="modalYear"></span> |
                            <span id="modalDuration"></span> |
                            <span id="modalRating"></span>
                        </p>
                        <p id="modalDescription"></p>
                        <p><small class="text-muted">Cast: <span id="modalCast"></span></small></p>
                        <p><small class="text-muted">Genre: <span id="modalGenre"></span></small></p>
                        <p><small class="text-muted">Category: <span id="modalCategory"></span></small></p>
                    </div>
                </div>
                <div class="mb-3 mt-4" id="modalTrailerContainer">
                    <h4>Trailer:</h4>
                    <video id="modalTrailerVideo" controls width="100%" class="rounded">
                        <source src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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

    .netflixSwiper .swiper-slide {
        width: 100%;
    }

    .card {
        height: 100%;
        margin: 0;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                },
                beforeTransitionStart: function() {
                    const activeVideo = this.slides[this.activeIndex].querySelector('video');
                    if (activeVideo) activeVideo.pause();
                },
                afterTransitionEnd: function() {
                    const anyModalOpen = document.querySelector('.modal.show');
                    if (!anyModalOpen) {
                        const activeVideo = this.slides[this.activeIndex].querySelector('video');
                        if (activeVideo) activeVideo.play();
                    }
                }
            }
        });

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

        const globalDetailModalElement = document.getElementById('globalDetailModal');
        if (globalDetailModalElement) {
            globalDetailModalElement.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');
                const title = button.getAttribute('data-title');
                const description = button.getAttribute('data-description');
                const posterUrl = button.getAttribute('data-poster-url');
                const trailerUrl = button.getAttribute('data-trailer-url');
                const category = button.getAttribute('data-category');
                const year = button.getAttribute('data-year');
                const duration = button.getAttribute('data-duration');
                const rating = button.getAttribute('data-rating');
                const synopsis = button.getAttribute('data-synopsis');
                const cast = button.getAttribute('data-cast');
                const genre = button.getAttribute('data-genre');

                const modalTitle = globalDetailModalElement.querySelector('.modal-title');
                const modalPoster = globalDetailModalElement.querySelector('#modalPoster');
                const modalDescription = globalDetailModalElement.querySelector('#modalDescription');
                const modalCategory = globalDetailModalElement.querySelector('#modalCategory');
                const modalYear = globalDetailModalElement.querySelector('#modalYear');
                const modalDuration = globalDetailModalElement.querySelector('#modalDuration');
                const modalRating = globalDetailModalElement.querySelector('#modalRating');
                const modalSynopsis = globalDetailModalElement.querySelector('#modalSynopsis');
                const modalCast = globalDetailModalElement.querySelector('#modalCast');
                const modalGenre = globalDetailModalElement.querySelector('#modalGenre');
                const modalTrailerContainer = globalDetailModalElement.querySelector('#modalTrailerContainer');
                const modalTrailerVideo = modalTrailerContainer ? modalTrailerContainer.querySelector('#modalTrailerVideo') : null;
                const modalTrailerSource = modalTrailerVideo ? modalTrailerVideo.querySelector('source') : null;

                if (modalTitle) modalTitle.textContent = title;
                if (modalPoster) modalPoster.src = posterUrl;
                if (modalDescription) modalDescription.textContent = description;
                if (modalCategory) modalCategory.textContent = category;
                if (modalYear) modalYear.textContent = year;
                if (modalDuration) modalDuration.textContent = duration;
                if (modalRating) modalRating.textContent = rating;
                if (modalSynopsis) modalSynopsis.textContent = synopsis;
                if (modalCast) modalCast.textContent = cast;
                if (modalGenre) modalGenre.textContent = genre;

                if (trailerUrl && modalTrailerSource) {
                    modalTrailerSource.src = trailerUrl;
                    if (modalTrailerVideo) {
                        modalTrailerVideo.load();
                        modalTrailerVideo.play();
                    }
                    if (modalTrailerContainer) {
                        modalTrailerContainer.style.display = 'block';
                    }
                } else {
                    if (modalTrailerVideo) {
                        modalTrailerVideo.pause();
                        modalTrailerVideo.removeAttribute('src');
                        if (modalTrailerSource) {
                            modalTrailerSource.removeAttribute('src');
                        }
                    }
                    if (modalTrailerContainer) {
                        modalTrailerContainer.style.display = 'none';
                    }
                }

                const swiperInstance = document.querySelector('.netflixSwiper').swiper;
                if (swiperInstance && swiperInstance.autoplay.running) {
                    swiperInstance.autoplay.stop();
                }
            });

            globalDetailModalElement.addEventListener('hide.bs.modal', function () {
                const modalVideo = globalDetailModalElement.querySelector('#modalTrailerVideo');
                if (modalVideo) {
                    modalVideo.pause();
                    modalVideo.currentTime = 0;
                }

                const swiperInstance = document.querySelector('.netflixSwiper').swiper;
                if (swiperInstance && !swiperInstance.autoplay.running) {
                    swiperInstance.autoplay.start();
                }
            });
        }
    });
</script>
@endsection