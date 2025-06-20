@extends('layouts.app2')

@section('content')
<section class="container-fluid" style="margin-top: 20px; position: relative; z-index: 10;">
    <div class="d-flex justify-content-between align-items-center mb-4 px-3">
        <h5 class="display-6 fw-bold m-0">Daftar Koleksi</h5>
        <div class="edit-buttons">
            <button class="edit-title-btn btn btn-secondary fw-semibold px-3 py-1 d-flex align-items-center gap-2">
                <i class="bi bi-pencil"></i> Edit
            </button>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger px-3">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success px-3">{{ session('success') }}</div>
    @endif

    @if ($videos->isEmpty())
        <p class="text-center text-muted py-4 px-3">Belum ada video dalam koleksi Anda.</p>
    @else
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3">
            @foreach ($videos as $video)
                <div class="col">
                    <div class="card bg-dark text-white h-100 d-flex flex-column movie-card" data-video-id="{{ $video->id }}">
                        <span class="movie-select position-absolute top-0 end-0 m-2" data-video-id="{{ $video->id }}" style="display: none; width: 24px; height: 24px; border: 2px solid #fff; border-radius: 50%; background-color: rgba(0,0,0,0.5); cursor: pointer;"></span>
                        <a href="{{ route('video.detail', ['id' => $video->id]) }}" class="text-decoration-none text-white">
                            <img src="{{ $video->poster_image ? asset('storage/' . $video->poster_image) : asset('Drama__box.png') }}"
                                 class="card-img-top movie-poster"
                                 alt="{{ $video->name }} poster"
                                 style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column movie-info">
                            <h5 class="card-title text-truncate">{{ $video->name }}</h5>
                            <p class="card-text movie-episode">Ep {{ $video->episodes ? count($video->episodes) : rand(1, 10) }} / Ep 20</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus <span id="selectedCount" class="text-danger fw-bold">0</span> film yang dipilih?
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Peringatan -->
    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="warningModalLabel">Peringatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Pilih film yang ingin dihapus terlebih dahulu.
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection