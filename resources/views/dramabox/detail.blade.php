@extends('layouts.app1')

@section('content')
<section class="container my-4">
  <h5 class="display-5 fw-bold mb-4">Menonton</h5>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if (!$video)
    <p class="text-center text-muted py-4">Video not found.</p>
  @else
    @php
      $episodes = is_string($video->episodes) 
        ? (json_decode($video->episodes, true) ?? [$video->episodes]) 
        : ($video->episodes ?? []);
    @endphp

    <div class="row mb-5">
      <!-- Kolom kiri: video -->
      <div class="col-md-8">
        @if ($video->video_file)
          <div class="ratio ratio-16x9 mb-3">
            <video controls width="800" height="450" class="w-100 video-highlight" id="videoPlayer">
              <source src="{{ asset('videos/' . $video->video_file) }}" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>
        @else
          <img src="{{ asset('Drama__box.png') }}" class="img-fluid mb-3" alt="{{ $video->name }}">
        @endif
      </div>

      <!-- Kolom kanan: episode -->
      <div class="col-md-4">
        <div class="bg-dark p-3 rounded">
          <h6 class="text-white mb-3">Episodes</h6>
          @if (!empty($episodes))
            <div class="row row-cols-3 g-2">
              @foreach ($episodes as $index => $episodePath)
                <div class="col">
                  <button class="btn btn-sm btn-episode w-100" 
                    onclick="changeEpisode('{{ $episodePath ? asset('episodes/' . rawurlencode($episodePath)) : '#' }}', {{ $index + 1 }})" 
                    data-episode-path="{{ $episodePath ? asset('episodes/' . rawurlencode($episodePath)) : '#' }}" 
                    data-episode-index="{{ $index + 1 }}">
                    Ep {{ $index + 1 }}
                  </button>
                </div>
              @endforeach
            </div>
          @else
            <small class="text-muted">No episodes</small>
          @endif
        </div>
      </div>

      <!-- Keterangan video di bawah -->
      <div class="col-12 mt-4">
        <div class="card bg-dark text-white">
          <div class="card-body">
            <h5 class="card-title fw-bold">{{ $video->name }}</h5>
            <p class="card-text text-break">{{ $video->description }}</p>
            <p class="card-text mb-0 small text-muted">
              <span class="me-3"><strong>Category:</strong> {{ $video->category }}</span>
              <span class="me-3"><strong>Rating:</strong> ★ {{ $video->rating ?? rand(5, 7) . '.' . rand(0, 9) }}</span>
              <span><strong>Popular:</strong> {{ $video->is_popular ? 'Yes' : 'No' }}</span>
            </p>
          </div>
        </div>
      </div>
    </div>
  @endif
</section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const videoPlayer = document.getElementById('videoPlayer');
    const savedEpisodePath = localStorage.getItem('selectedEpisodePath');
    const savedEpisode = localStorage.getItem('selectedEpisode');

    if (savedEpisodePath && videoPlayer) {
      videoPlayer.innerHTML = `<source src="${savedEpisodePath}" type="video/mp4">`;
      videoPlayer.load();
      if (savedEpisode) {
        document.querySelectorAll('.btn-episode').forEach(btn => {
          if (btn.getAttribute('data-episode-index') == savedEpisode) {
            btn.classList.add('active');
          }
        });
      }
    }

    window.changeEpisode = function(episodePath, episodeNumber) {
      const videoPlayer = document.getElementById('videoPlayer');
      if (videoPlayer && episodePath !== '#') {
        try {
          videoPlayer.innerHTML = `<source src="${episodePath.replace(/'/g, "\\'")}" type="video/mp4">`;
          videoPlayer.load();
          videoPlayer.play();
          localStorage.setItem('selectedEpisode', episodeNumber);
          localStorage.setItem('selectedEpisodePath', episodePath);
          document.querySelectorAll('.btn-episode').forEach(btn => btn.classList.remove('active'));
          event.target.classList.add('active');
        } catch (e) {
          console.error('Error changing episode:', e);
        }
      } else {
        console.log('Error: Invalid episode path or video player not found');
      }
    };
  });
</script>
@endsection
