

@extends('layouts.app1')

@section('styles')
<style>
    /* Efek menonjol untuk kartu di bagian Popular */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    /* Efek menonjol untuk poster di Swiper */
    .content-overlay img {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .content-overlay img:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Overlay untuk video di Swiper */
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

    /* Gaya tombol volume */
    .volume-toggle-btn {
        transition: all 0.3s ease-in-out;
        border: 2px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        background-color: rgba(0, 0, 0, 0.6);
    }

    .volume-toggle-btn:hover {
        transform: scale(1.1);
        border-color: rgba(255, 255, 255, 0.8);
        background-color: rgba(0, 0, 0, 0.8);
    }

    /* Gaya Swiper */
    .swiper {
        width: 100%;
        overflow-x: auto;
    }

    .netflixSwiper .swiper-slide {
        width: 100%;
        height: 90vh;
    }

    /* Responsivitas */
    @media (max-width: 768px) {
        .card {
            margin-bottom: 15px;
        }
        .card-img-top {
            height: 200px !important;
        }
        .card-title {
            font-size: 1rem;
        }
        .card-text {
            font-size: 0.85rem;
        }
        .content-overlay {
            max-width: 80% !important;
            top: 10% !important;
            left: 5% !important;
        }
        .content-overlay img {
            width: 150px !important;
            height: 200px !important;
        }
        .content-overlay h1 {
            font-size: 1.5rem;
        }
        .upcoming-meta p {
            font-size: 0.9rem;
        }
        .upcoming-meta .btn {
            font-size: 0.9rem;
            padding: 8px 16px;
        }
        .volume-toggle-btn {
            width: 35px;
            height: 35px;
            bottom: 15px;
            right: 15px;
        }
    }

    @media (max-width: 576px) {
        .netflixSwiper .swiper-slide {
            height: 60vh;
        }
        .content-overlay h1 {
            font-size: 1.2rem;
        }
        .content-overlay img {
            width: 120px !important;
            height: 160px !important;
        }
    }
</style>
@endsection

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
                                   autoplay loop playsinline>
                                <source src="{{ $upcoming->trailer_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <button class="btn btn-dark btn-sm position-absolute rounded-circle volume-toggle-btn"
                                    style="bottom: 20px; right: 20px; z-index: 4; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Toggle volume">
                                <i class="bi bi-volume-mute-fill fs-5"></i>
                            </button>
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
                                {{ $upcoming->category ? (is_array($upcoming->category) ? implode(', ', array_map('htmlspecialchars', $upcoming->category)) : htmlspecialchars($upcoming->category)) : 'No category available' }}
                            </p>
                            <div class="d-flex gap-3">
                                <a href="{{ route('dramabox.detail', ['id' => $upcoming->id]) }}"
   class="btn text-dark fw-semibold px-4 py-2 d-flex align-items-center gap-2 fs-5"
   style="background-color: rgba(245, 197, 24, 0.5);">
    <i class="bi bi-play-fill"></i> Putar
</a>
                                <button type="button"
        class="btn btn-secondary fw-semibold px-4 py-2 d-flex align-items-center gap-2 fs-5"
        style="background-color: rgba(128, 128, 128, 0.5); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06); border: none; border-radius: 12px; overflow: hidden;"
        data-bs-toggle="modal"
        data-bs-target="#globalDetailModal"
        data-id="{{ $upcoming->id }}"
        data-title="{{ $upcoming->title }}"
        data-description="{{ $upcoming->description }}"
        data-poster-url="{{ $upcoming->poster_url ?? asset('Drama__box.png') }}"
        data-trailer-url="{{ $upcoming->trailer_url ?? '' }}"
        data-category="{{ is_array($upcoming->category) ? implode(', ', array_map('htmlspecialchars', $upcoming->category)) : htmlspecialchars($upcoming->category) }}"
        data-year="{{ $upcoming->year ?? 'N/A' }}"
        data-duration="{{ $upcoming->duration ?? 'N/A' }}"
        data-rating="{{ $upcoming->rating ?? 'N/A' }}"
        data-synopsis="{{ $upcoming->synopsis ?? 'No synopsis available' }}"
        data-cast="{{ $upcoming->cast ?? 'N/A' }}"
        data-genre="{{ $upcoming->genre ?? 'N/A' }}">
    <i class="bi bi-info-circle"></i> Info Selengkapnya
</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="container-fluid" style="margin-top: 5px; position: relative; z-index: 10; margin-bottom: 20px;">
    <h2 class="display-6 fw-bold mb-4 px-3 text-white">Popular</h2>

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
                        <a href="{{ route('dramabox.detail', ['id' => $video->id]) }}" class="text-decoration-none text-white">
                            <img src="{{ $video->poster_image ? asset('storage/' . $video->poster_image) : asset('Drama__box.png') }}"
                                 class="card-img-top"
                                 alt="{{ htmlspecialchars($video->name) }} poster"
                                 style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate">{{ htmlspecialchars($video->name) }}</h5>
                            <p class="card-text">Kategori: 
                                @if(is_array($video->category))
                                    {{ implode(', ', array_map('htmlspecialchars', $video->category)) }}
                                @else
                                    {{ htmlspecialchars($video->category ?? 'No Category') }}
                                @endif
                            </p>
                            <p class="card-title text-truncate text-white">Total Episode: {{ count($video->episodes ?? []) }}</p>
                            <div class="mt-auto d-flex gap-2">
                                <a href="{{ route('dramabox.detail', ['id' => $video->id]) }}" class="btn btn-warning btn-sm bi bi-play-fill">Menonton</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="margin-top: 20px;" class="d-flex justify-content-center">
            {{ $videos->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @endif
</section>

<div class="modal fade" id="globalDetailModal" tabindex="-1" aria-labelledby="globalDetailModalLabel" aria-hidden="true">
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
                        <p class="text-white mb-2">
                            <span id="modalYear"></span> |
                            <span id="modalDuration"></span> |
                            <span id="modalRating"></span>
                        </p>
                        <p id="modalDescription"></p>
                        <p><small class="text-white">Cast: <span id="modalCast"></span></small></p>
                        <p><small class="text-white">Genre: <span id="modalGenre"></span></small></p>
                        <p><small class="text-white">Kategori: <span id="modalCategory"></span></small></p>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi tooltip untuk tombol volume
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Variabel global untuk status mute
        let isMutedGlobally = true;

        const netflixSwiper = new Swiper('.netflixSwiper', {
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
                init: function() {
                    const activeVideo = this.slides[this.activeIndex].querySelector('video');
                    if (activeVideo) {
                        activeVideo.muted = isMutedGlobally;
                        activeVideo.play().catch(error => {
                            console.log("Autoplay diblokir (init):", error);
                            activeVideo.muted = true;
                            isMutedGlobally = true;
                            updateVolumeButtonIcon(activeVideo, this.slides[this.activeIndex].querySelector('.volume-toggle-btn'));
                        });
                        updateVolumeButtonIcon(activeVideo, this.slides[this.activeIndex].querySelector('.volume-toggle-btn'));
                    }
                },
                beforeTransitionStart: function() {
                    const prevVideo = this.slides[this.previousIndex].querySelector('video');
                    if (prevVideo) prevVideo.pause();
                },
                slideChangeTransitionEnd: function() {
                    const activeVideo = this.slides[this.activeIndex].querySelector('video');
                    if (activeVideo) {
                        const anyModalOpen = document.querySelector('.modal.show');
                        if (!anyModalOpen) {
                            activeVideo.muted = isMutedGlobally;
                            activeVideo.play().catch(error => {
                                console.log("Autoplay diblokir (slideChangeTransitionEnd):", error);
                                activeVideo.muted = true;
                                isMutedGlobally = true;
                                updateVolumeButtonIcon(activeVideo, this.slides[this.activeIndex].querySelector('.volume-toggle-btn'));
                            });
                            updateVolumeButtonIcon(activeVideo, this.slides[this.activeIndex].querySelector('.volume-toggle-btn'));
                        }
                    }
                },
                autoplayStop: function() {
                    const activeVideo = this.slides[this.activeIndex].querySelector('video');
                    if (activeVideo) activeVideo.pause();
                },
                autoplayStart: function() {
                    const activeVideo = this.slides[this.activeIndex].querySelector('video');
                    if (activeVideo) {
                        activeVideo.muted = isMutedGlobally;
                        activeVideo.play().catch(error => {
                            console.log("Autoplay diblokir (autoplayStart):", error);
                            activeVideo.muted = true;
                            isMutedGlobally = true;
                            updateVolumeButtonIcon(activeVideo, this.slides[this.activeIndex].querySelector('.volume-toggle-btn'));
                        });
                        updateVolumeButtonIcon(activeVideo, this.slides[this.activeIndex].querySelector('.volume-toggle-btn'));
                    }
                }
            }
        });

        function updateVolumeButtonIcon(videoElement, buttonElement) {
            if (buttonElement) {
                buttonElement.innerHTML = videoElement.muted ? '<i class="bi bi-volume-mute-fill fs-5"></i>' : '<i class="bi bi-volume-up-fill fs-5"></i>';
            }
        }

        document.querySelectorAll('.volume-toggle-btn').forEach(button => {
            button.addEventListener('click', function() {
                const video = this.closest('.swiper-slide').querySelector('video');
                if (video) {
                    video.muted = !video.muted;
                    isMutedGlobally = video.muted;
                    updateVolumeButtonIcon(video, this);

                    netflixSwiper.slides.forEach((slide, index) => {
                        const slideVideo = slide.querySelector('video');
                        if (slideVideo && slideVideo !== video) {
                            slideVideo.muted = isMutedGlobally;
                        }
                    });

                    if (!video.muted) {
                        video.play().catch(e => {
                            console.error("Error playing on unmute click:", e);
                            video.muted = true;
                            isMutedGlobally = true;
                            updateVolumeButtonIcon(video, this);
                        });
                    }
                }
            });
        });

        const globalDetailModalElement = document.getElementById('globalDetailModal');
        if (globalDetailModalElement) {
            globalDetailModalElement.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const trailerUrl = button.getAttribute('data-trailer-url');
                const modalTrailerVideo = globalDetailModalElement.querySelector('#modalTrailerVideo');
                const modalTrailerSource = modalTrailerVideo ? modalTrailerVideo.querySelector('source') : null;

                if (netflixSwiper && netflixSwiper.autoplay.running) {
                    netflixSwiper.autoplay.stop();
                    const activeVideoInSwiper = netflixSwiper.slides[netflixSwiper.activeIndex].querySelector('video');
                    if (activeVideoInSwiper) activeVideoInSwiper.pause();
                }

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

                if (modalTitle) modalTitle.textContent = button.getAttribute('data-title');
                if (modalPoster) modalPoster.src = button.getAttribute('data-poster-url');
                if (modalDescription) modalDescription.textContent = button.getAttribute('data-description');
                if (modalCategory) modalCategory.textContent = button.getAttribute('data-category');
                if (modalYear) modalYear.textContent = button.getAttribute('data-year');
                if (modalDuration) modalDuration.textContent = button.getAttribute('data-duration');
                if (modalRating) modalRating.textContent = button.getAttribute('data-rating');
                if (modalSynopsis) modalSynopsis.textContent = button.getAttribute('data-synopsis');
                if (modalCast) modalCast.textContent = button.getAttribute('data-cast');
                if (modalGenre) modalGenre.textContent = button.getAttribute('data-genre');

                if (trailerUrl && modalTrailerSource) {
                    modalTrailerSource.src = trailerUrl;
                    if (modalTrailerVideo) {
                        modalTrailerVideo.muted = false;
                        modalTrailerVideo.load();
                        modalTrailerVideo.play().catch(e => console.error("Error playing modal trailer:", e));
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
                        modalTrailerContainer.display = 'none';
                    }
                }
            });

            globalDetailModalElement.addEventListener('hide.bs.modal', function () {
                const modalVideo = globalDetailModalElement.querySelector('#modalTrailerVideo');
                if (modalVideo) {
                    modalVideo.pause();
                    modalVideo.currentTime = 0;
                }

                if (netflixSwiper && !netflixSwiper.autoplay.running) {
                    netflixSwiper.autoplay.start();
                    const activeVideoInSwiper = netflixSwiper.slides[netflixSwiper.activeIndex].querySelector('video');
                    if (activeVideoInSwiper) {
                        activeVideoInSwiper.muted = isMutedGlobally;
                        activeVideoInSwiper.play().catch(e => console.error("Error playing swiper video on modal close:", e));
                        updateVolumeButtonIcon(activeVideoInSwiper, netflixSwiper.slides[netflixSwiper.activeIndex].querySelector('.volume-toggle-btn'));
                    }
                }
            });
        }
    });
</script>
@endpush