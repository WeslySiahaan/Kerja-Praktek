@extends('layouts.app2')

@section('content')
<section class="container-fluid" style="margin-top: 5px; position: relative; z-index: 10; margin-bottom: 20px;">
    @if (session('error'))
        <div class="alert alert-danger px-3">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success px-3">{{ session('success') }}</div>
    @endif
    @if (session('info'))
        <div class="alert alert-info px-3">{{ session('info') }}</div>
    @endif

    <h2 class="display-6 fw-bold mb-4 px-3 text-white">Rekomendasi untuk Anda</h2>

    @if ($recommendedVideos->isEmpty())
        <p class="text-center text-muted py-4 px-3">Tidak ada rekomendasi untuk saat ini. Coba sukai beberapa video!</p>
    @else
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3" id="videoGrid">
            @foreach ($recommendedVideos as $video)
                <div class="col">
                    <div class="card bg-dark text-white h-100 d-flex flex-column">
                        <a href="{{ $video->is_dramabox ? route('dramabox.detail', $video) : route('video.detail', ['id' => $video->id]) }}"
                           class="text-decoration-none text-white">
                            <img src="{{ $video->poster_image ? asset('storage/' . $video->poster_image) : asset('Drama__box.png') }}"
                                 class="card-img-top"
                                 alt="{{ htmlspecialchars($video->name) }} poster"
                                 style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate">{{ htmlspecialchars($video->name) }}</h5>
                            <p class="card-text">
                                Category: 
                                @if(is_array($video->category))
                                    {{ implode(', ', array_map('htmlspecialchars', $video->category)) }}
                                @else
                                    {{ htmlspecialchars($video->category ?? 'No Category') }}
                                @endif
                            </p>
                            <p class="card-title text-truncate text-white">Total Episodes: {{ count($video->episodes ?? []) }}</p>
                            <div class="mt-auto d-flex gap-2">
                                @auth
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
                                @else
                                    <button class="btn btn-link p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Login untuk Suka" disabled>
                                        <i class="bi bi-heart text-white fs-5"></i>
                                    </button>
                                    <button class="btn btn-link p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Login untuk Simpan" disabled>
                                        <i class="bi bi-bookmark text-white fs-5"></i>
                                    </button>
                                @endauth
                                <a href="{{ $video->is_dramabox ? route('dramabox.detail', $video) : route('video.detail', ['id' => $video->id]) }}"
                                   class="btn btn-primary btn-sm bi bi-play-fill">Menonton</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="margin-top: 20px;" class="d-flex justify-content-center">
            {{ $recommendedVideos->links('pagination::bootstrap-4') }}
        </div>
    @endif
</section>

<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: scale(1.05);
    }
    .card-img-top {
        border-radius: 8px 8px 0 0;
    }
    .card-body {
        padding: 0.75rem;
    }
    [data-bs-toggle="tooltip"] {
        cursor: pointer;
    }
    .card-title {
        font-weight: 600;
        font-size: 1rem;
    }
    .card-text, .card-title.text-white {
        font-size: 0.85rem;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
</style>

<script>
    // Inisialisasi tooltip Bootstrap
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection