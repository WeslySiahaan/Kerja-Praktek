@extends('layouts.app2')

@section('content')
<!-- Import Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Upcoming Section -->
<section class="position-relative">
    <div class="swiper netflixSwiper">
        <div class="swiper-wrapper">
            @foreach ($upcomings as $upcoming)
                <div class="swiper-slide position-relative" style="height: 90vh;">
                   <div class="video-container position-relative w-100 h-100" style="overflow: hidden;">
    <div class="video-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index: 1;"></div>

    @if ($upcoming->trailer_url)
        {{-- Hapus 'muted' dari baris ini --}}
        <video class="w-100 h-100" style="object-fit: cover; object-position: center;"
               autoplay loop playsinline>
            <source src="{{ $upcoming->trailer_url }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        
        {{-- Tambahkan tombol kontrol volume --}}
        <button class="btn btn-dark btn-sm position-absolute rounded-circle volume-toggle-btn"
                style="bottom: 80px; right: 20px; z-index: 4; width: 40px; height: 40px;">
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

<section class="container-fluid popular-section" style="margin-top: 5px; position: relative; z-index: 10; margin-bottom: 20px;">
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
                        <a href="{{ route('video.detail', ['id' => $video->id]) }}" class="text-decoration-none text-white">
                            <img src="{{ $video->poster_image ? asset('storage/' . $video->poster_image) : asset('Drama__box.png') }}"
                                 class="card-img-top"
                                 alt="{{ htmlspecialchars($video->name) }} poster"
                                 style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate">{{ htmlspecialchars($video->name) }}</h5>
                            <p class="card-text">Category: 
                                @if(is_array($video->category))
                                    {{ implode(', ', array_map('htmlspecialchars', $video->category)) }}
                                @else
                                    {{ htmlspecialchars($video->category ?? 'No Category') }}
                                @endif
                            </p>
                            <p class="card-title text-truncate text-white">Total Episodes: {{ count($video->episodes ?? []) }}</p>
                            <div class="mt-auto d-flex gap-2">
                                @if (Auth::check())
                                    <!-- Tombol Like -->
                                    <form action="{{ route('videos.like', $video) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 like-btn" title="{{ $video->likedByUsers->contains(Auth::id()) ? 'Batal Suka' : 'Suka' }}">
                                            <i class="bi {{ $video->likedByUsers->contains(Auth::id()) ? 'bi-heart-fill text-danger' : 'bi-heart text-white' }} fs-5"></i>
                                        </button>
                                    </form>
                                    <!-- Tombol Simpan -->
                                    <form action="{{ route('videos.save', $video) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0" title="{{ $video->collectedByUsers->contains(Auth::id()) ? 'Sudah Disimpan' : 'Simpan' }}"
                                                {{ $video->collectedByUsers->contains(Auth::id()) ? 'disabled' : '' }}>
                                            <i class="bi {{ $video->collectedByUsers->contains(Auth::id()) ? 'bi-bookmark-fill text-success' : 'bi-bookmark text-white' }} fs-5"></i>
                                        </button>
                                    </form>
                                @else
                                    <!-- Tombol Like dan Save non-aktif untuk pengguna tidak login -->
                                    <button class="btn btn-link p-0" title="Login untuk Suka" disabled>
                                        <i class="bi bi-heart text-white fs-5"></i>
                                    </button>
                                    <button class="btn btn-link p-0" title="Login untuk Simpan" disabled>
                                        <i class="bi bi-bookmark text-white fs-5"></i>
                                    </button>
                                @endif
                                <!-- Tombol Menonton (tanpa login) -->
                                <a href="{{ route('video.detail', ['id' => $video->id]) }}" class="btn btn-primary btn-sm bi bi-play-fill">Menonton</a>
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

<style>
    .popular-section {
        margin-top: 5px;
        position: relative;
        z-index: 10;
        margin-bottom: 20px;
    }
</style>

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
                        <p class="text-white mb-2">
                            <span id="modalYear"></span> |
                            <span id="modalDuration"></span> |
                            <span id="modalRating"></span>
                        </p>
                        <p id="modalDescription"></p>
                        <p><small class="text-white">Cast: <span id="modalCast"></span></small></p>
                        <p><small class="text-white">Genre: <span id="modalGenre"></span></small></p>
                        <p><small class="text-white">Category: <span id="modalCategory"></span></small></p>
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
                nextEl: '.swiper-button-next', // Pastikan tombol navigasi ini ada di HTML Anda
                prevEl: '.swiper-button-prev', // Pastikan tombol navigasi ini ada di HTML Anda
            },
            on: {
                // Event saat Swiper diinisialisasi
                init: function() {
                    const activeVideo = this.slides[this.activeIndex].querySelector('video');
                    if (activeVideo) {
                        activeVideo.muted = false; // COBA SET MUTED KE FALSE DI SINI
                        activeVideo.play().catch(error => {
                            console.log("Autoplay diblokir (init):", error);
                            // Jika diblokir, set kembali ke muted dan tampilkan ikon muted
                            activeVideo.muted = true;
                            const volumeBtn = this.slides[this.activeIndex].querySelector('.volume-toggle-btn');
                            if (volumeBtn) {
                                volumeBtn.innerHTML = '<i class="bi bi-volume-mute-fill fs-5"></i>';
                            }
                        });
                        // Atur ikon volume sesuai status awal (mungkin masih muted jika diblokir browser)
                        const volumeBtn = this.slides[this.activeIndex].querySelector('.volume-toggle-btn');
                        if (volumeBtn) {
                            volumeBtn.innerHTML = activeVideo.muted ? '<i class="bi bi-volume-mute-fill fs-5"></i>' : '<i class="bi bi-volume-up-fill fs-5"></i>';
                        }
                    }
                },
                // Event sebelum transisi slide dimulai
                beforeTransitionStart: function() {
                    const prevVideo = this.slides[this.previousIndex].querySelector('video');
                    if (prevVideo) prevVideo.pause(); // Pause video sebelumnya
                },
                // Event setelah transisi slide berakhir
                slideChangeTransitionEnd: function() {
                    const activeVideo = this.slides[this.activeIndex].querySelector('video');
                    if (activeVideo) {
                        // Hanya putar jika tidak ada modal yang terbuka
                        const anyModalOpen = document.querySelector('.modal.show');
                        if (!anyModalOpen) {
                            activeVideo.muted = false; // COBA SET MUTED KE FALSE LAGI SAAT SLIDE BERUBAH
                            activeVideo.play().catch(error => {
                                console.log("Autoplay diblokir (slideChangeTransitionEnd):", error);
                                activeVideo.muted = true; // Jika diblokir, set kembali ke muted
                            });
                            // Update ikon volume
                            const volumeBtn = this.slides[this.activeIndex].querySelector('.volume-toggle-btn');
                            if (volumeBtn) {
                                volumeBtn.innerHTML = activeVideo.muted ? '<i class="bi bi-volume-mute-fill fs-5"></i>' : '<i class="bi bi-volume-up-fill fs-5"></i>';
                            }
                        }
                    }
                },
                // Event saat Swiper dihentikan (misalnya saat klik tombol navigasi atau drag)
                autoplayStop: function() {
                    // Ketika autoplay berhenti, pastikan video yang sedang aktif juga di-pause
                    const activeVideo = this.slides[this.activeIndex].querySelector('video');
                    if (activeVideo) activeVideo.pause();
                },
                // Event saat Swiper dimulai kembali (misalnya setelah autoplay berhenti dan kemudian dimulai manual)
                autoplayStart: function() {
                    const activeVideo = this.slides[this.activeIndex].querySelector('video');
                    if (activeVideo) {
                        activeVideo.muted = false; // COBA SET MUTED KE FALSE SAAT AUTOPLAY DIMULAI
                        activeVideo.play().catch(error => {
                            console.log("Autoplay diblokir (autoplayStart):", error);
                            activeVideo.muted = true; // Jika diblokir, set kembali ke muted
                        });
                        const volumeBtn = this.slides[this.activeIndex].querySelector('.volume-toggle-btn');
                        if (volumeBtn) {
                            volumeBtn.innerHTML = activeVideo.muted ? '<i class="bi bi-volume-mute-fill fs-5"></i>' : '<i class="bi bi-volume-up-fill fs-5"></i>';
                        }
                    }
                }
            }
        });

        // Event listener untuk tombol volume di Swiper (harus di luar inisialisasi Swiper)
        document.querySelectorAll('.volume-toggle-btn').forEach(button => {
            button.addEventListener('click', function() {
                const video = this.closest('.swiper-slide').querySelector('video');
                if (video) {
                    if (video.muted) {
                        video.muted = false; // Unmute
                        this.innerHTML = '<i class="bi bi-volume-up-fill fs-5"></i>';
                        video.play().catch(e => console.error("Error playing on unmute click:", e)); // Coba play lagi
                    } else {
                        video.muted = true; // Mute
                        this.innerHTML = '<i class="bi bi-volume-mute-fill fs-5"></i>';
                    }
                }
            });
        });

        // Inisialisasi Swiper lainnya (Movie Popular Swiper)
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

        // Logic untuk Global Detail Modal
        const globalDetailModalElement = document.getElementById('globalDetailModal');
        if (globalDetailModalElement) {
            globalDetailModalElement.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const trailerUrl = button.getAttribute('data-trailer-url');
                const modalTrailerVideo = globalDetailModalElement.querySelector('#modalTrailerVideo');
                const modalTrailerSource = modalTrailerVideo ? modalTrailerVideo.querySelector('source') : null;

                // Pause the active video in netflixSwiper when modal opens
                if (netflixSwiper && netflixSwiper.autoplay.running) {
                    netflixSwiper.autoplay.stop();
                    const activeVideoInSwiper = netflixSwiper.slides[netflixSwiper.activeIndex].querySelector('video');
                    if (activeVideoInSwiper) activeVideoInSwiper.pause();
                }

                // Populate modal details
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

                // Set data to modal elements
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
                        modalTrailerVideo.muted = false; // COBA SET MUTED KE FALSE UNTUK VIDEO MODAL
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
                        modalTrailerContainer.style.display = 'none';
                    }
                }
            });

            globalDetailModalElement.addEventListener('hide.bs.modal', function () {
                const modalVideo = globalDetailModalElement.querySelector('#modalTrailerVideo');
                if (modalVideo) {
                    modalVideo.pause();
                    modalVideo.currentTime = 0;
                }

                // Resume autoplay of netflixSwiper when modal closes
                if (netflixSwiper && !netflixSwiper.autoplay.running) {
                    netflixSwiper.autoplay.start();
                    const activeVideoInSwiper = netflixSwiper.slides[netflixSwiper.activeIndex].querySelector('video');
                    if (activeVideoInSwiper) {
                        activeVideoInSwiper.muted = false; // COBA SET MUTED KE FALSE SAAT KEMBALI DARI MODAL
                        activeVideoInSwiper.play().catch(e => console.error("Error playing swiper video on modal close:", e));
                        const volumeBtn = netflixSwiper.slides[netflixSwiper.activeIndex].querySelector('.volume-toggle-btn');
                        if (volumeBtn) {
                            volumeBtn.innerHTML = activeVideoInSwiper.muted ? '<i class="bi bi-volume-mute-fill fs-5"></i>' : '<i class="bi bi-volume-up-fill fs-5"></i>';
                        }
                    }
                }
            });
        }
    });
</script>
@endsection