@extends('layouts.app2')

@section('content')
<section class="container-fluid" style="margin-top: 20px; position: relative; z-index: 10; margin-bottom: 20px;">
    <div class="d-flex justify-content-between align-items-center mb-4 px-3">
        <h5 class="display-6 fw-bold m-0 text-white">Daftar Koleksi</h5>
        @auth
        <div class="edit-buttons d-flex gap-2">
            @if (request()->has('edit') && request()->get('edit') === 'true')
                <a href="{{ route('users.koleksi') }}" class="btn btn-secondary fw-semibold px-3 py-1 d-flex align-items-center gap-2">
                    <i class="bi bi-x-lg"></i> Batal
                </a>
            @else
                <a href="{{ route('users.koleksi') }}?edit=true" class="btn btn-secondary fw-semibold px-3 py-1 d-flex align-items-center gap-2">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            @endif
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

    @if ($videos->isEmpty())
        <p class="text-center text-muted py-4 px-3">Belum ada video dalam koleksi Anda.</p>
    @else
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3" id="videoGrid">
            @foreach ($videos as $video)
                <div class="col">
                    <div class="card bg-dark text-white h-100 d-flex flex-column movie-card" data-video-id="{{ $video->id }}">
                        @auth
                        @if (request()->has('edit') && request()->get('edit') === 'true')
                        <form action="{{ route('collections.destroy_multiple') }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="video_ids[]" value="{{ $video->id }}">
                            <button type="submit" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus {{ $video->name }} dari koleksi Anda?');">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                        @endauth
                        <a href="{{ route('dramabox.detail', $video) }}" class="text-decoration-none text-white">
                            <img src="{{ $video->poster_image ? asset('storage/' . $video->poster_image) : asset('Drama__box.png') }}"
                                 class="card-img-top movie-poster"
                                 alt="{{ $video->name }} poster"
                                 style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column movie-info">
                            <h5 class="card-title text-truncate">{{ $video->name }}</h5>
                            <p class="card-text text-white"><small>Kategori: {{ is_array($video->category) ? implode(', ', $video->category) : $video->category }}</small></p>
                            <p class="card-title text-truncate text-white"><small>Total {{ count($video->episodes ?? []) }} episode</small></p>
                            <div class="mt-auto">
                                <a href="{{ route('dramabox.detail', $video) }}"  class="btn btn-primary btn-sm bi bi-play-fill">Menonton</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($videos->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $videos->links() }}
        </div>
        @endif
    @endif
</section>
@endsection