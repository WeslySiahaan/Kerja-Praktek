@extends('layouts.app2')

@section('category_navbar')
    @include('profile.partials.category_navbar')
@endsection

@section('styles')
<style>
    /* Efek menonjol untuk kartu */
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

    /* Gaya tombol Like dan Save */
    .like-btn, .save-btn {
        transition: transform 0.2s ease;
    }

    .like-btn:hover, .save-btn:hover {
        transform: scale(1.2);
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
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    @if(isset($query) && $query)
        <h4 class="text-warning fw-semibold mb-2" style="font-size: 1.25rem;">
            Hasil pencarian untuk: 
            <span class="text-white">"{{ htmlspecialchars($query) }}"</span>
        </h4>
    @endif

    <section class="px-3 py-4">
        @if(isset($category) && $category && $category !== 'all')
            <h5 class="text-warning fw-semibold mb-2">
                Kategori: <span class="text-light">"{{ htmlspecialchars($category) }}"</span>
            </h5>
        @elseif(isset($category) && $category === 'all')
            <h5 class="text-warning fw-semibold mb-2">Menampilkan Semua Kategori</h5>
        @endif

        <h1 class="fw-bold text-white mb-2" style="font-size: 1.8rem;">
            Pilihan Video Sesuai Kategori
        </h1>
        <p class="text-secondary" style="font-size: 1rem;">
            Temukan berbagai video menarik yang sesuai dengan kategori favoritmu.
        </p>

        @if($videos->isEmpty())
            <p class="text-center text-muted py-4 px-3">Tidak ada video ditemukan.</p>
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
                                <p class="card-text text-white"><small>Kategori: 
                                    {{ is_array($video->category) ? implode(', ', array_map('htmlspecialchars', $video->category)) : htmlspecialchars($video->category ?? 'No Category') }}
                                </small></p>
                                <p class="card-title text-truncate text-white"><small>Total {{ count($video->episodes ?? []) }} Episode</small></p>
                                <div class="mt-auto d-flex gap-2">
                                    @if (Auth::check())
                                        <form action="{{ route('videos.like', $video) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 like-btn" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" 
                                                    title="{{ $video->likedByUsers->contains(Auth::id()) ? 'Batal Suka' : 'Suka' }}">
                                                <i class="bi {{ $video->likedByUsers->contains(Auth::id()) ? 'bi-heart-fill text-danger' : 'bi-heart text-white' }} fs-5"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('videos.save', $video) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 save-btn" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" 
                                                    title="{{ $video->collectedByUsers->contains(Auth::id()) ? 'Sudah Disimpan' : 'Simpan' }}"
                                                    {{ $video->collectedByUsers->contains(Auth::id()) ? 'disabled' : '' }}>
                                                <i class="bi {{ $video->collectedByUsers->contains(Auth::id()) ? 'bi-bookmark-fill text-success' : 'bi-bookmark text-white' }} fs-5"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('video.detail', $video->id) }}" class="btn btn-primary btn-sm bi bi-play-fill">Menonton</a>
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
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi tooltip untuk tombol Like dan Save
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Logika tombol kategori
        document.querySelectorAll('.category-buttons button').forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                window.location.href = `{{ route('users.search') }}?category=${encodeURIComponent(category)}`;
            });
        });

        // Menandai tombol kategori aktif
        const urlParams = new URLSearchParams(window.location.search);
        const activeCategory = urlParams.get('category') || 'all';
        document.querySelectorAll('.category-buttons button').forEach(button => {
            if (button.getAttribute('data-category') === activeCategory) {
                button.classList.add('active', 'btn-secondary');
                button.classList.remove('btn-outline-secondary');
            } else {
                button.classList.remove('active', 'btn-secondary');
                button.classList.add('btn-outline-secondary');
            }
        });
    });
</script>
@endpush    