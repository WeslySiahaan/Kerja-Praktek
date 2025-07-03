@extends('layouts.app2')

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

    /* Gaya tombol Like dan Save */
    .like-btn, .save-btn {
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .like-btn:hover, .save-btn:hover {
        transform: scale(1.2);
        color: #007bff;
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
    <section class="container-fluid" style="margin-top: 20px; position: relative; z-index: 10; margin-bottom: 20px;">
        <div class="d-flex justify-content-between align-items-center mb-4 px-3">
            <h5 class="display-6 fw-bold m-0 text-white">Rekomendasi untuk Anda</h5>
            @auth
            <div class="edit-buttons d-flex gap-2">
            </div>
            @endauth
        </div>

        <div id="notifications" class="px-3"></div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show px-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show px-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show px-3" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($recommendedVideos->isEmpty())
            <p class="text-center text-muted py-4 px-3">Tidak ada rekomendasi untuk saat ini.</p>
        @else
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3" id="videoGrid">
                @foreach ($recommendedVideos as $video)
                    <div class="col">
                        <div class="card bg-dark text-white h-100 d-flex flex-column movie-card" data-video-id="{{ $video->id }}">
                            <a href="{{ route('dramabox.detail', $video) }}" class="text-decoration-none text-white">
                                <img src="{{ $video->poster_image ? asset('storage/' . $video->poster_image) : asset('Drama__box.png') }}"
                                     class="card-img-top movie-poster"
                                     alt="{{ $video->name }} poster"
                                     style="height: 300px; object-fit: cover;">
                            </a>
                            <div class="card-body d-flex flex-column movie-info">
                                <h5 class="card-title text-truncate">{{ $video->name }}</h5>
                                <p class="card-title text-truncate text-white"><small>Total {{ count($video->episodes ?? []) }} episode</small></p>
                                <p class="card-text text-white"><small>Likes: {{ $video->like_count }}</small></p>
                                <div class="mt-auto">
                                    <a href="{{ route('dramabox.detail', $video) }}"  class="btn btn-primary btn-sm bi bi-play-fill">Menonton</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection