@extends('layouts.app1')

@section('breadcrumb')
<nav aria-label="breadcrumb" class="container my-3">
  <style>
    .breadcrumb-item + .breadcrumb-item::before {
      content: none !important; 
    }
  </style>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="{{ route('dramabox.beranda') }}" class="text-white text-decoration-none fw-normal">
        <i class="bi bi-house-fill"></i> 
      </a>
    </li>

    <li class="breadcrumb-item">
      <i class="bi bi-chevron-right mx-1"></i> 
      <a href="{{ route('dramabox.browse') }}?category={{ is_array($video->category) ? urlencode(implode(',', $video->category)) : urlencode($video->category ?? 'Kategori') }}" class="text-white text-decoration-none fw-normal">
        {!! is_array($video->category) ? implode('<span class="separator"> / </span>', array_map('htmlspecialchars', $video->category)) : htmlspecialchars($video->category ?? 'Kategori') !!}
      </a>
    </li>

    <li class="breadcrumb-item">
      <i class="bi bi-chevron-right mx-1"></i> {{-- Icon > --}}
      <a href="{{ route('dramabox.detail', $video) }}" class="text-white text-decoration-none fw-normal">
        {{ htmlspecialchars($video->name ?? 'Menonton') }}
      </a>
    </li>

    <li class="breadcrumb-item active text-white fw-bold" aria-current="page" id="episode-breadcrumb">
  <i class="bi bi-chevron-right mx-1"></i> {{-- Icon > --}}
  <span id="episode-text">Episode {{ !empty($episodes) ? (request()->query('episode', 1)) : '1' }}</span>
</li>

  </ol>
</nav>



<style>
        nav[aria-label="breadcrumb"] {
            border-bottom: 0.5px solid; 
            padding-bottom: 10px; 
            margin-bottom: 20px; 
        }
    </style>
@endsection


@section('content')
<section class="container my-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (!$video)
        <p class="text-center text-muted py-4">Video tidak ditemukan.</p>
    @else
        @php
            $episodes = $video->episodes ?? [];
            if (is_string($episodes)) {
                $episodes = json_decode($episodes, true) ?? [];
            }
            $firstEpisodePath = !empty($episodes) ? $episodes[0] : null;
        @endphp

        <div class="row mb-5">
            <div class="col-md-8">
                <div class="ratio ratio-16x9 mb-3 video-player-with-border">
                    @if ($firstEpisodePath)
                        <video controls width="900" height="450" class="w-100 video-highlight" id="videoPlayer">
                            <source src="{{ asset('storage/' . rawurlencode($firstEpisodePath)) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <div class="text-center text-white py-5">Tidak ada video episode yang tersedia.</div>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="bg-dark p-3 rounded h-100 overflow-auto" style="max-height: 485px;">
                    <h6 class="text-white">Daftar Episode</h6>
                    @guest
                    <h6 class="text-danger mb-3">Anda harus login untuk mengakses semua Episode</h6>
                    @endguest

                    @if (!empty($episodes))
                    <div class="mb-2 text-white" id="episode-info">Episode 1 dari {{ count($episodes) }} episode</div>
                    <div class="row row-cols-3 g-2">
                        @foreach ($episodes as $index => $episodePath)
                        <div class="col">
                            <button class="btn btn-sm btn-episode w-100 {{ $index === 0 ? 'active' : '' }}"
                                    onclick="handleEpisodeClick('{{ asset('storage/' . rawurlencode($episodePath)) }}', {{ $index + 1 }}, {{ count($episodes) }}, {{ $index }})"
                                    data-episode-path="{{ asset('storage/' . rawurlencode($episodePath)) }}"
                                    data-episode-index="{{ $index + 1 }}"
                                    {{ $index > 0 && !Auth::check() ? 'disabled' : '' }}>
                                Ep {{ $index + 1 }}
                            </button>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <small class="text-muted">Tidak ada episode yang tersedia.</small>
                    @endif
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $video->name }}</h5>
                        <p class="card-text text-break">{{ $video->description }}</p>
                        <p class="card-text text-break">
                            <span class="me-3"><strong>Category:</strong> 
                                @if(is_array($video->category))
                                    {{ implode(', ', array_map('htmlspecialchars', $video->category)) }}
                                @else
                                    {{ htmlspecialchars($video->category ?? 'No Category') }}
                                @endif
                            </span>
                        </p>
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
                            @else
                                <a href="{{ route('login') }}" class="btn btn-link p-0" title="Suka">
                                    <i class="bi bi-heart text-white fs-5"></i>
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-link p-0" title="Simpan">
                                    <i class="bi bi-bookmark text-white fs-5"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Komentar</h5>
                        @if (Auth::check())
                            <form action="{{ route('comments.store', $video) }}" method="POST" class="mb-3" id="commentForm">
                                @csrf
                                <div class="input-group">
                                    <textarea name="content" class="form-control" rows="1" placeholder="Tulis komentar Anda..." required></textarea>
                                    <button type="submit" class="btn btn-primary" title="Kirim">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </div>
                                @error('content')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </form>
                        @else
                            <p class="text-break">
                                Silakan 
                                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-box-arrow-in-right"></i> masuk
                                </a>
                                untuk menulis komentar.
                            </p>
                        @endif

                        <div id="comments-list" class="mt-3" style="max-height: 400px; overflow-y: auto;">
                            @if ($video->comments->isEmpty())
                                <p class="text-muted">Belum ada komentar.</p>
                            @else
                                @foreach ($video->comments->sortByDesc('created_at') as $comment)
                                    <div class="comment-item" id="comment-{{ $comment->id }}" style="border-bottom: 1px solid #495057; padding: 10px 0;">
                                        <div class="d-flex align-items-start">
                                            <img src="{{ $comment->user->profile_photo_path ? asset('storage/' . $comment->user->profile_photo_path) : asset('user.png') }}"
                                                 alt="{{ $comment->user->name }}" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <p>
                                                    <strong class="text-primary">{{ $comment->user->name }}</strong>
                                                    <small class="text-white updated-at ms-2" data-timestamp="{{ $comment->created_at->timestamp }}">
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </small>
                                                </p>
                                                <p class="comment-content">{{ $comment->content }}</p>

                                                @auth
                                                    @if (Auth::id() === $comment->user_id)
                                                        <form action="{{ route('comments.update', $comment) }}" method="POST" class="edit-comment-form mt-2" style="display: none;" id="edit-form-{{ $comment->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="input-group mb-2">
                                                                <textarea name="content" class="form-control comment-edit-content" rows="2" required>{{ $comment->content }}</textarea>
                                                                <button type="submit" class="btn btn-primary" title="Simpan">
                                                                    <i class="bi bi-check"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-secondary cancel-edit" data-comment-id="{{ $comment->id }}" title="Batal">
                                                                    <i class="bi bi-x"></i>
                                                                </button>
                                                            </div>
                                                            @error('content')
                                                                <div class="text-danger mt-1">{{ $message }}</div>
                                                            @enderror
                                                        </form>
                                                    @endif
                                                @endauth

                                                @auth
                                                    @if (Auth::id() === $comment->user_id)
                                                        <div class="d-flex justify-content-end align-items-center mt-2">
                                                            <button type="button" class="btn btn-sm btn-link text-info edit-comment" data-comment-id="{{ $comment->id }}" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="ms-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-link text-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>

<style>
    .btn-episode.active {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }
    .btn-episode {
        background-color: #343a40;
        color: #f8f9fa;
        border: 1px solid #495057;
    }
    .btn-episode:hover {
        background-color: #495057;
    }
    .btn-episode:disabled {
        background-color: #6c757d;
        color: #ccc;
        cursor: not-allowed;
    }
    .video-player-with-border {
        border: 3px solid white;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        border-radius: 5px;
        overflow: hidden;
    }
    .comment-item:last-child {
        border-bottom: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const videoPlayer = document.getElementById('videoPlayer');
        const episodeButtons = document.querySelectorAll('.btn-episode');
        const episodeBreadcrumb = document.getElementById('episode-breadcrumb');

        if (videoPlayer && {{ !empty($episodes) ? 'true' : 'false' }}) {
            videoPlayer.innerHTML = `<source src="{{ asset('storage/' . rawurlencode($firstEpisodePath ?? '')) }}" type="video/mp4">`;
            videoPlayer.load();

            if (episodeButtons.length > 0) {
                episodeButtons[0].classList.add('active');
            }
        }

        window.handleEpisodeClick = function(episodePath, episodeNumber, totalEpisodes, index) {
            if (videoPlayer && episodePath) {
                try {
                    if (episodeNumber > 1 && !{{ Auth::check() ? 'true' : 'false' }}) {
                        alert('Silakan login untuk menonton episode ini.');
                        window.location.href = '{{ route('login') }}';
                        return;
                    }
                    videoPlayer.innerHTML = `<source src="${episodePath.replace(/'/g, "\\'")}" type="video/mp4">`;
                    videoPlayer.load();
                    videoPlayer.play().catch(error => {
                        console.error('Error playing video:', error);
                        alert('Gagal memutar video. Silakan coba lagi.');
                    });

                    episodeButtons.forEach(btn => btn.classList.remove('active'));
                    document.querySelector(`.btn-episode[data-episode-index="${episodeNumber}"]`).classList.add('active');
                    document.getElementById('episode-info').textContent = `Episode ${episodeNumber} dari ${totalEpisodes} episode`;

                    // Update breadcrumb with episode number
                    if (episodeBreadcrumb) {
                        episodeBreadcrumb.textContent = `Episode ${episodeNumber}`;
                    }
                } catch (e) {
                    console.error('Error changing episode:', e);
                    alert('Terjadi kesalahan saat mengganti episode.');
                }
            } else {
                console.log('Error: Invalid episode path or video player not found.');
            }
        };

        document.querySelectorAll('.edit-comment').forEach(button => {
            button.addEventListener('click', function () {
                const commentId = this.getAttribute('data-comment-id');
                const commentItem = document.getElementById(`comment-${commentId}`);
                const contentP = commentItem.querySelector('.comment-content');
                const editForm = commentItem.querySelector('.edit-comment-form');

                contentP.style.display = 'none';
                editForm.style.display = 'block';
            });
        });

        document.querySelectorAll('.cancel-edit').forEach(button => {
            button.addEventListener('click', function () {
                const commentItem = this.closest('.comment-item');
                const contentP = commentItem.querySelector('.comment-content');
                const editForm = commentItem.querySelector('.edit-comment-form');

                contentP.style.display = 'block';
                editForm.style.display = 'none';
            });
        });

        document.querySelectorAll('form[action^="/comments/"]').forEach(form => {
            form.querySelector('button[type="submit"]').addEventListener('click', function (e) {
                e.preventDefault();
                if (!confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
                    return;
                }

                const commentId = form.getAttribute('action').split('/').pop();
                fetch(`/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    const commentElement = document.getElementById(`comment-${commentId}`);
                    if (commentElement) {
                        commentElement.remove();
                        if (document.querySelectorAll('.comment-item').length === 0) {
                            document.getElementById('comments-list').innerHTML = '<p class="text-muted">Belum ada komentar.</p>';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error deleting comment:', error);
                    alert('Terjadi kesalahan saat menghapus komentar.');
                });
            });
        });
    });
</script>
@endsection