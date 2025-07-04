@extends('layouts.app1') {{-- Pastikan layout ini benar --}}

@section('category_navbar')
    @include('profile.partials.category_navbar')
@endsection

@section('styles')
<style>
    /* Efek menonjol untuk kartu */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        border: 1px solid transparent;
        border-radius: 12px;
        overflow: hidden;
        background: #2c2c2c;
    }

    .card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2), 0 0 10px rgba(0, 123, 255, 0.5);
        border: 1px solid #007bff;
    }

    /* Efek zoom pada gambar poster saat hover */
    .card-img-top {
        transition: transform 0.3s ease;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
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
        .btn-sm {
            font-size: 0.8rem;
            padding: 6px 12px;
        }
    }

    @media (max-width: 576px) {
        .card-title {
            font-size: 0.9rem;
        }
        .card-text {
            font-size: 0.8rem;
        }
        .btn-sm {
            font-size: 0.75rem;
            padding: 5px 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    {{-- Optional: Tampilkan query pencarian atau kategori yang aktif --}}
    @if(isset($query) && $query)
        <h4 class="text-warning fw-semibold mb-2" style="font-size: 1.25rem;">
            Hasil pencarian untuk: 
            <span class="text-white">"{{ $query }}"</span>
        </h4>
    @endif

    <section class="px-3 py-4">
        {{-- Nama kategori --}}
        @if(isset($category) && $category && $category !== 'all')
            <h5 class="text-warning fw-semibold mb-2">
                Kategori: <span class="text-light">"{{ $category }}"</span>
            </h5>
        @elseif(isset($category) && $category === 'all')
            <h5 class="text-warning fw-semibold mb-2">Menampilkan Semua Kategori</h5>
        @endif

        {{-- Judul utama --}}
        <h1 class="fw-bold text-white mb-2" style="font-size: 1.8rem;">
            Pilihan Video Sesuai Kategori
        </h1>

        {{-- Subjudul --}}
        <p class="text-secondary" style="font-size: 1rem;">
            Temukan berbagai video menarik yang sesuai dengan kategori favoritmu.
        </p>
    </section>

    @if($videos->isEmpty())
        <p class="text-center text-muted py-4 px-3">Tidak ada video ditemukan.</p>
    @else
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3">
            @foreach ($videos as $video)
                <div class="col">
                    <div class="card bg-dark text-white h-100 d-flex flex-column">
                        <a href="{{ route('dramabox.detail', ['id' => $video->id]) }}" class="text-decoration-none text-white">
                            <img src="{{ $video->poster_image ? asset('storage/' . $video->poster_image) : asset('Drama__box.png') }}"
                                 class="card-img-top"
                                 alt="{{ $video->name }} poster"
                                 style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate">{{ $video->name }}</h5>
                            <p class="card-text text-white"><small>Kategori: {{ is_array($video->category) ? implode(', ', $video->category) : $video->category }}</small></p>
                            <p class="card-title text-truncate text-white"><small>Total {{ count($video->episodes ?? []) }} Episode</small></p>
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
                                <a href="{{ route('dramabox.detail', $video->id) }}" class="btn btn-primary btn-sm bi bi-play-fill">Menonton</a>
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

{{-- Bagian Tampilkan Upcomings (jika ingin ditampilkan, aktifkan dan samakan strukturnya) --}}
{{-- Hapus komentar jika ingin digunakan --}}
{{--
<section class="mb-5">
    <h2 class="display-6 fw-bold mb-4 px-3 text-white">Upcoming Shows</h2>
    @if($upcomings->isEmpty())
        <p class="text-center text-muted py-4 px-3">Tidak ada acara mendatang ditemukan.</p>
    @else
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3">
            @foreach($upcomings as $upcoming)
                <div class="col">
                    <div class="card bg-dark text-white h-100 d-flex flex-column">
                        <a href="#" class="text-decoration-none text-white">
                            <img src="{{ $upcoming->poster ? asset('storage/' . $upcoming->poster) : asset('Drama__box.png') }}"
                                class="card-img-top"
                                alt="{{ $upcoming->title }} poster"
                                style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate">{{ $upcoming->title }}</h5>
                            <p class="card-text">{{ Str::limit($upcoming->description, 100) ?? 'No description available.' }}</p>
                            <p class="card-text text-white"><small>Kategori: {{ is_array($upcoming->category) ? implode(', ', $upcoming->category) : $upcoming->category }}</small></p>
                            <p class="card-title text-truncate text-white"><small>Rilis: {{ $upcoming->release_date->format('d M Y') }}</small></p>
                            <div class="mt-auto d-flex gap-2">
                                <div class="d-flex gap-2 invisible">
                                    <button type="button" class="btn btn-link p-0"><i class="bi bi-heart fs-5"></i></button>
                                    <button type="button" class="btn btn-link p-0"><i class="bi bi-bookmark fs-5"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
--}}

{{-- Bagian Tampilkan Populars (jika ingin ditampilkan, aktifkan dan samakan strukturnya) --}}
{{--
<section class="mb-5">
    <h2 class="display-6 fw-bold mb-4 px-3 text-white">Popular Shows</h2>
    @if($populars->isEmpty())
        <p class="text-center text-muted py-4 px-3">Tidak ada acara populer ditemukan.</p>
    @else
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3">
            @foreach($populars as $popular)
                <div class="col">
                    <div class="card bg-dark text-white h-100 d-flex flex-column">
                        <a href="#" class="text-decoration-none text-white">
                            <img src="{{ $popular->poster ? asset('storage/' . $popular->poster) : asset('Drama__box.png') }}"
                                class="card-img-top"
                                alt="{{ $popular->title }} poster"
                                style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate">{{ $popular->title }}</h5>
                            <p class="card-text">{{ Str::limit($popular->description, 100) ?? 'No description available.' }}</p>
                            <p class="card-text text-white"><small>Kategori: {{ is_array($popular->category) ? implode(', ', $popular->category) : $popular->category }}</small></p>
                            <p class="card-title text-truncate invisible"><small>Placeholder</small></p>
                            <div class="mt-auto d-flex gap-2">
                                @if (Auth::check())
                                    <form action="{{ route('populars.like', $popular) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 like-btn" title="{{ $popular->likedByUsers->contains(Auth::id()) ? 'Batal Suka' : 'Suka' }}">
                                            <i class="bi {{ $popular->likedByUsers->contains(Auth::id()) ? 'bi-heart-fill text-danger' : 'bi-heart text-white' }} fs-5"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('populars.save', $popular) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0" title="{{ $popular->collectedByUsers->contains(Auth::id()) ? 'Sudah Disimpan' : 'Simpan' }}"
                                                {{ $popular->collectedByUsers->contains(Auth::id()) ? 'disabled' : '' }}>
                                            <i class="bi {{ $popular->collectedByUsers->contains(Auth::id()) ? 'bi-bookmark-fill text-success' : 'bi-bookmark text-white' }} fs-5"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
--}}
</div>
@endsection

@push('scripts')
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

    // Add click event for category buttons
    document.querySelectorAll('.category-buttons button').forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            window.location.href = `{{ route('dramabox.search1') }}?category=${category}`;
        });
    });

    // Optional: Add active class to the current category button
    const urlParams = new URLSearchParams(window.location.search);
    const activeCategory = urlParams.get('category') || 'all';
    document.querySelectorAll('.category-buttons button').forEach(button => {
        if (button.getAttribute('data-category') === activeCategory) {
            button.classList.add('active');
            button.classList.remove('btn-outline-secondary');
            button.classList.add('btn-secondary');
        } else {
             button.classList.remove('active', 'btn-secondary');
             button.classList.add('btn-outline-secondary');
        }
    });
</script>
@endpush