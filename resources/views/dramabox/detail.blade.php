<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MoraClips</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #000;
      color: #fff;
    }
    .navbar {
      background-color: #000;
      border-bottom: 1px solid #333;
    }
    .navbar-brand {
      color: #ff4500 !important;
      font-size: 24px;
      font-weight: bold;
    }
    .navbar-nav .nav-link {
      color: #fff !important;
    }
    .navbar-nav .nav-link:hover {
      color: #ff4500 !important;
    }
    .form-control {
      background-color: #333;
      border: none;
      color: #fff;
    }
    .form-control::placeholder {
      color: #ccc;
    }
    .card {
      background-color: #1a1a1a;
      border: none;
    }
    .card-body {
      color: #ccc;
    }
    .card-title {
      color: #fff;
    }
    .text-muted {
      color: #999 !important;
    }
    .btn-episode {
      background-color: #333;
      color: #fff;
      font-size: 13px;
      padding: 4px 8px;
    }
    .btn-episode:hover {
      background-color: #ff4500;
      color: #fff;
    }
    .alert-success {
      background-color: #28a745;
    }
    footer {
      background-color: #1a1a1a;
      color: #fff;
    }
    footer a {
      color: #ccc;
      text-decoration: none;
    }
    footer a:hover {
      color: #ff4500;
    }
    .footer-bottom {
      border-top: 1px solid #333;
      color: #999;
    }
    .video-highlight {
      box-shadow: 0 0 15px white;
      border-radius: 10px;
    }
    .btn-episode.active {
      background-color: #ff4500;
      color: #fff;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">MoraClips</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="{{ route('dramabox.beranda') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('dramabox.browse') }}">Browse</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('dramabox.app') }}">App</a></li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="#">English</a></li>
        </ul>
        <form class="d-flex ms-2" method="GET" action="{{ route('dramabox.search') }}">
          <input class="form-control me-2" type="search" name="query" placeholder="Search by name" value="{{ request('query') }}">
        </form>
        @if (Route::has('login'))
        <div class="d-flex ms-2">
          <a href="{{ route('login') }}" class="btn btn-primary me-2">Log in</a>
          @if (Route::has('register'))
          <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
          @endif
        </div>
        @endif
      </div>
    </div>
  </nav>

  <section class="container my-4">
    <h5 class="display-5 fw-bold mb-4">Menonton</h5>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (!$video) <!-- Jika video tidak ditemukan (meskipun findOrFail seharusnya melempar exception) -->
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

  <footer class="mt-3 py-3">
    <div class="container">
      <div class="row g-3">
        <div class="col-6 col-md-3">
          <h5 class="mb-2">About</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="d-block mb-1">Terms of Use</a></li>
            <li><a href="#" class="d-block mb-1">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-6 col-md-3">
          <h5 class="mb-2">More</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="d-block mb-1">Resources</a></li>
          </ul>
        </div>
        <div class="col-6 col-md-3">
          <h5 class="mb-2">Contact Us</h5>
          <ul class="list-unstyled">
            <li><a href="mailto:feedback@dramabox.com" class="d-block mb-1">Email: feedback@dramabox.com</a></li>
            <li><a href="#" class="d-block mb-1">Business Collaborations</a></li>
          </ul>
        </div>
        <div class="col-6 col-md-3">
          <h5 class="mb-2">Community</h5>
          <ul>
            <li><a href="#" class="d-block mb-1">Facebook</a></li>
            <li><a href="#" class="d-block mb-1">YouTube</a></li>
            <li><a href="#" class="d-block mb-1">TikTok</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom mt-3 text-center">
        © DramaBox, All Rights Reserved StoryMatrix Pte.Ltd.
      </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>