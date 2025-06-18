@extends('layouts.app1')

@section('content')
<section class="container my-4">
  <h5 class="display-5 fw-bold mb-4">Menonton</h5>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if (!$video)
    <p class="text-center text-muted py-4">Video tidak ditemukan.</p>
  @else
    @php
      $episodes = $video->episodes ?? [];
    @endphp

    <div class="row mb-5">
      <div class="col-md-8">
        <div class="ratio ratio-16x9 mb-3 video-player-with-border"> {{-- Tambahkan kelas baru di sini --}}
          <video controls width="800" height="450" class="w-100 video-highlight" id="videoPlayer">
            @if (!empty($episodes))
              <source src="{{ asset('storage/' . $episodes[0]) }}" type="video/mp4">
            @else
              <p class="text-white">Tidak ada video episode yang tersedia.</p>
            @endif
            Your browser does not support the video tag.
          </video>
        </div>
      </div>

      <div class="col-md-4">
        <div class="bg-dark p-3 rounded h-100 overflow-auto" style="max-height: 450px;">
          <h6 class="text-white mb-3">Daftar Episode</h6>
          @if (!empty($episodes))
            <div class="row row-cols-3 g-2">
              @foreach ($episodes as $index => $episodePath)
                <div class="col">
                  <button class="btn btn-sm btn-episode w-100 {{ $index === 0 ? 'active' : '' }}"
                    onclick="changeEpisode('{{ asset('storage/' . rawurlencode($episodePath)) }}', {{ $index + 1 }})"
                    data-episode-path="{{ asset('storage/' . rawurlencode($episodePath)) }}"
                    data-episode-index="{{ $index + 1 }}">
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
            <p class="card-text mb-0 small text-muted">
              <span class="me-3"><strong>Category:</strong> {{ $video->category }}</span>
              <span class="me-3"><strong>Rating:</strong> ★ {{ $video->rating }}</span>
              <span><strong>Popular:</strong> {{ $video->is_popular ? 'Yes' : 'No' }}</span>
            </p>
          </div>
        </div>
      </div>
    </div>
  @endif
</section>

<style>
  /* Gaya tambahan untuk tombol episode aktif */
  .btn-episode.active {
    background-color: #007bff; /* Warna biru Bootstrap */
    border-color: #007bff;
    color: white;
  }
  .btn-episode {
    background-color: #343a40; /* Warna gelap */
    color: #f8f9fa; /* Teks terang */
    border: 1px solid #495057; /* Border sedikit lebih terang */
  }
  .btn-episode:hover {
    background-color: #495057;
  }

  /* Gaya untuk garis putih di sekeliling video */
  .video-player-with-border {
    border: 3px solid white; /* Garis putih dengan ketebalan 3px */
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.5); /* Efek bayangan untuk menonjolkan garis */
    border-radius: 5px; /* Sedikit lengkungan pada sudut */
    overflow: hidden; /* Pastikan video tidak keluar dari border-radius */
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const videoPlayer = document.getElementById('videoPlayer');
    const episodeButtons = document.querySelectorAll('.btn-episode');

    if (videoPlayer && episodeButtons.length > 0) {
      let initialEpisodePath = null;
      let initialEpisodeNumber = null;

      const savedEpisodePath = localStorage.getItem('selectedEpisodePath_video_' + {{ $video->id }});
      const savedEpisodeNumber = localStorage.getItem('selectedEpisode_video_' + {{ $video->id }});

      if (savedEpisodePath && savedEpisodeNumber) {
        initialEpisodePath = savedEpisodePath;
        initialEpisodeNumber = parseInt(savedEpisodeNumber);
      } else {
        const firstEpisodeButton = episodeButtons[0];
        initialEpisodePath = firstEpisodeButton.getAttribute('data-episode-path');
        initialEpisodeNumber = parseInt(firstEpisodeButton.getAttribute('data-episode-index'));
      }

      if (initialEpisodePath) {
        videoPlayer.innerHTML = `<source src="${initialEpisodePath}" type="video/mp4">`;
        videoPlayer.load();

        episodeButtons.forEach(btn => {
          if (parseInt(btn.getAttribute('data-episode-index')) === initialEpisodeNumber) {
            btn.classList.add('active');
          } else {
            btn.classList.remove('active');
          }
        });
      }
    }

    window.changeEpisode = function(episodePath, episodeNumber) {
      if (videoPlayer && episodePath) {
        try {
          videoPlayer.innerHTML = `<source src="${episodePath.replace(/'/g, "\\'")}" type="video/mp4">`;
          videoPlayer.load();
          videoPlayer.play();

          localStorage.setItem('selectedEpisode_video_' + {{ $video->id }}, episodeNumber);
          localStorage.setItem('selectedEpisodePath_video_' + {{ $video->id }}, episodePath);

          episodeButtons.forEach(btn => btn.classList.remove('active'));
          document.querySelector(`.btn-episode[data-episode-index="${episodeNumber}"]`).classList.add('active');

        } catch (e) {
          console.error('Error changing episode:', e);
        }
      } else {
        console.log('Error: Invalid episode path or video player not found.');
      }
    };
  });
</script>
@endsection