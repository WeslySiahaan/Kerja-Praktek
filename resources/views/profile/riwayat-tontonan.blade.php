@extends('layouts.app')

@section('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f5f5;
        padding: 0;
        margin: 0;
    }

    .history-container {
        max-width: 1300px;
        margin: 20px auto;
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #212529;
        text-align: left;
    }

    .history-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
    }

    .history-section-header h5 {
        font-weight: 600;
        color: #343a40;
        font-size: 1.5rem;
    }

    .history-item-card {
        display: flex;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        margin-bottom: 25px;
        overflow: hidden;
        position: relative;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .history-item-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .history-item-card img {
        width: 150px;
        height: 225px;
        object-fit: cover;
        flex-shrink: 0;
        border-radius: 12px 0 0 12px;
    }

    .history-item-details {
        flex-grow: 1;
        padding: 20px 25px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .history-item-details h6 {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: #212529;
    }

    .history-item-details .category-time {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 15px;
    }

    .history-item-details p.description {
        font-size: 0.95rem;
        color: #495057;
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .watch-action-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease, border-color 0.3s ease;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .watch-action-button.continue {
        background-color: #17a2b8;
        color: #fff;
        border: 1px solid #17a2b8;
    }

    .watch-action-button.continue:hover {
        background-color: #138496;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    }

    .watch-action-button.watched {
        background-color: #28a745;
        color: #fff;
        border: 1px solid #28a745;
    }

    .watch-action-button.watched:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    }

    .watch-action-button i {
        font-size: 1.1rem;
    }

    .delete-item-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.8);
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        color: #999;
        cursor: pointer;
        transition: all 0.2s ease;
        z-index: 10;
    }

    .delete-item-btn:hover {
        background: #dc3545;
        color: #fff;
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        padding: 5px 15px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }

    .modal-body .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        font-family: 'Poppins', sans-serif;
        padding: 8px 20px;
        border-radius: 6px;
    }

    .modal-body .btn-secondary {
        font-family: 'Poppins', sans-serif;
        padding: 8px 20px;
        border-radius: 6px;
    }

    .modal-body i {
        font-size: 3rem;
    }

    .modal-header .btn-close {
        padding: 0.5rem;
        margin: -0.5rem -0.5rem -0.5rem auto;
    }

    @media (max-width: 768px) {
        .history-container {
            padding: 20px;
            margin: 10px auto;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .history-section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .history-item-card {
            flex-direction: column;
            align-items: center;
            padding-bottom: 15px;
        }
        .history-item-card img {
            width: 100%;
            height: 250px;
            border-radius: 12px 12px 0 0;
            margin-bottom: 15px;
        }
        .history-item-details {
            padding: 0 15px;
            text-align: center;
        }
        .history-item-details h6 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        .history-item-details .category-time {
            font-size: 0.8rem;
            margin-bottom: 10px;
        }
        .history-item-details p.description {
            font-size: 0.9rem;
            -webkit-line-clamp: 2;
            margin-bottom: 15px;
        }
        .watch-action-button {
            width: 100%;
            justify-content: center;
            padding: 10px;
            font-size: 0.95rem;
        }
        .delete-item-btn {
            top: 10px;
            right: 10px;
            width: 25px;
            height: 25px;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="history-container">
    <h1 class="fw-bold">Riwayat Tontonan</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="history-section">
        <div class="history-section-header">
            <h5>Riwayat Tontonan Anda</h5>
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#clearHistoryModal">
                    <i class="bi bi-trash"></i> Kosongkan riwayat tontonan
                </button>
            </div>
        </div>

        <div class="history-list">
            @forelse ($watchHistoryItems as $item)
                <div class="history-item-card">
                    <a href="{{ route('video.detail', ['id' => $item->video_id]) }}">
                        <img src="{{ $item->image ?: 'https://placehold.co/150x225/cccccc/ffffff?text=No+Image' }}" alt="{{ $item->title }}">
                    </a>
                    <div class="history-item-details">
                        <div>
                            <h6>{{ $item->title }}</h6>
                            <p class="category-time">
                                @if(is_array($item->category))
                                    {{ implode(', ', array_map('htmlspecialchars', $item->category)) }}
                                @else
                                    {{ htmlspecialchars($item->category ?? 'No Category') }}
                                @endif
                                • {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}
                            </p>
                            <p class="description">{{ $item->description }}</p>
                        </div>
                        <div class="history-item-progress-actions">
                            @if ($item->progress >= 95)
                                <a href="{{ route('video.detail', ['id' => $item->video_id]) }}" class="watch-action-button watched">
                                    <i class="bi bi-check-circle-fill"></i> Sudah Ditonton
                                </a>
                            @else
                                <a href="{{ route('video.detail', ['id' => $item->video_id]) }}" class="watch-action-button continue">
                                    <i class="bi bi-play-circle-fill"></i> Lanjutkan Menonton
                                </a>
                            @endif
                            <form action="{{ route('profile.riwayatTontonan.destroy', $item->id) }}" method="POST" class="d-inline" onclick="event.stopPropagation();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-item-btn" data-bs-toggle="tooltip" data-bs-placement="left" title="Hapus dari riwayat tontonan">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted py-4">Belum ada riwayat tontonan.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Modal Kosongkan Riwayat (tetap sama) --}}
<div class="modal fade" id="clearHistoryModal" tabindex="-1" aria-labelledby="clearHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-0">
                <i class="bi bi-trash-fill text-danger mb-3" style="font-size: 3rem;"></i>
                <h5 class="mb-3">Bersihkan semua riwayat tontonan?</h5>
                @auth
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                @endguest
                <p class="mb-4">Semua riwayat tontonan Anda akan dihapus secara permanen dan tidak dapat dikembalikan. Lanjutkan?</p>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('profile.riwayatTontonan.clearAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush