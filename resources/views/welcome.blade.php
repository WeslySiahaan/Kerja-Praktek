<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MoraClips</title>
  <!-- Bootstrap 5 CSS CDN -->
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
    .card-img-top, .card video {
      width: 100%;
      height: auto;
    }
    .card-title {
      color: #fff;
    }
    .card-text {
      color: #ccc;
    }
    .text-muted {
      color: #999 !important;
    }
    .btn-episode {
      background-color: #333;
      color: #fff;
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
  </style>
</head>
<body>
  <!-- Header menggunakan Bootstrap Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">MoraClips</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dramabox.beranda') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dramabox.browse') }}">Browse</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dramabox.app') }}">App</a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#">English</a>
          </li>
        </ul>
        <form class="d-flex ms-2" method="GET" action="{{ route('dramabox.search') }}">
  <input
    class="form-control me-2"
    type="search"
    name="query"
    placeholder="Search by name"
    aria-label="Search"
    value="{{ request('query') }}"
  >
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

  <div class="container my-4">
  <h1 class="display-5 fw-bold mb-4 text-white">Up Coming</h1>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if ($upcomings->isEmpty())
    <p class="text-center text-muted py-4">No upcoming releases yet.</p>
  @else
    <div class="d-flex overflow-auto gap-3 pb-3">
      @foreach ($upcomings as $upcoming)
        <a href="{{ route('dramabox.detail', $upcoming->id) }}" class="text-decoration-none text-white">
          <div class="card bg-dark text-white" style="min-width: 220px; max-width: 180px;">
            @if ($upcoming->poster)
              <img src="{{ asset('storage/' . $upcoming->poster) }}" class="card-img-top" style="height: 240px; object-fit: cover;" alt="{{ $upcoming->title }}">
            @else
              <img src="https://via.placeholder.com/180x240?text=No+Poster" class="card-img-top" style="height: 240px; object-fit: cover;" alt="No Poster">
            @endif
            <div class="card-body p-2">
              <h6 class="card-title mb-1">{{ \Illuminate\Support\Str::limit($upcoming->title, 30) }}</h6>
              <small class="d-block text-muted">{{ $upcoming->category }}</small>
              <small class="d-block text-muted">
                {{ $upcoming->release_date instanceof \Illuminate\Support\Carbon ? $upcoming->release_date->format('d M Y') : $upcoming->release_date }}
              </small>
            </div>
          </div>
        </a>
      @endforeach
    </div>
  @endif
</div>


  <!-- Content menggunakan Bootstrap Container dan Grid -->
  <div class="container my-4">
    <h1 class="display-5 fw-bold mb-4">Video Terbaru</h1>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($videos->isEmpty())
      <p class="text-center text-muted py-4">No videos uploaded yet.</p>
    @else
      <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($videos as $video)
          @php
            $episodes = is_string($video->episodes) ? json_decode($video->episodes, true) ?? [$video->episodes] : ($video->episodes ?? []);
          @endphp
          <div class="col">
  <a href="{{ route('dramabox.detail', $video->id) }}" class="text-decoration-none text-white">
    <div class="card h-100">
      @if ($video->video_file)
        <video controls class="card-img-top">
          <source src="{{ asset('videos/' . $video->video_file) }}" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      @else
        <img src="{{ asset('Drama__box.png') }}" class="card-img-top" alt="{{ $video->name }}">
      @endif
      <div class="card-body">
        <h5 class="card-title">{{ $video->name }}</h5>
        <p class="card-text">{{ $video->description }}</p>
        <p class="card-text text-muted">
          <strong>Category:</strong> {{ $video->category }}<br>
          <strong>Rating:</strong> {{ $video->rating }}<br>
          <strong>Popular:</strong> {{ $video->is_popular ? 'Yes' : 'No' }}<br>
          <strong>Episodes:</strong> {{ count($episodes) }}
          <div>
                  @if (!empty($episodes))
                    @foreach ($episodes as $index => $episodePath)
                      <a href="{{ asset('episodes/' . $episodePath) }}" target="_blank" class="btn btn-episode btn-sm me-1 mb-1">Episode {{ $index + 1 }}</a>
                    @endforeach
                  @else
                    <small class="text-muted">No episodes</small>
                  @endif
                </div>
        </p>
      </div>
    </div>
  </a>
</div>

        @endforeach
      </div>
    @endif
  </div>

  <!-- Footer menggunakan Bootstrap dengan jarak yang lebih pas -->
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
          <ul class="list-unstyled">
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

  <!-- Bootstrap 5 JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>