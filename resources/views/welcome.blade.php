<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MoraClips</title>
  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
  <style>
  .modal-content.bg-dark {
    background-color: #141414;
  }
  .modal-body {
    padding: 1.5rem;
  }
  .text-muted {
    color: #a3a3a3 !important;
  }
  .modal-title {
    font-size: 1.5rem;
    font-weight: bold;
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

<!-- Up Coming Fullscreen Slider -->
<section class="position-relative">
  <div class="swiper netflixSwiper">
    <div class="swiper-wrapper">
      @foreach ($upcomings as $upcoming)
        <div class="swiper-slide position-relative" style="height: 90vh;">
          <!-- Overlay -->
          <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.5); z-index: 1;"></div>

                  <!-- Background Video -->
          <div class="w-100" style="height: 90vh; overflow: hidden; position: relative; padding-bottom: 0;">
            @if($upcoming->trailer)
              <video class="w-100 h-100" style="object-fit: cover; object-position: center; height: 100%;" autoplay muted loop>
                <source src="{{ $upcoming->trailer_url }}" type="video/mp4">
                Browser Anda tidak mendukung tag video.
              </video>
            @else
              <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark text-white">
                <p class="text-center">Trailer tidak tersedia.</p>
              </div>
            @endif
          </div>
          <!-- Poster dan Text -->
          <div class="position-absolute text-white" style="top: 13%; left: 3%; z-index: 2; max-width: 30%;">
          @if($upcoming->poster)
          <img src="{{ $upcoming->poster_url }}" alt="{{ $upcoming->title }}"
              style="width: 200px; height: 250px; margin-bottom: 2rem; border-radius: 8px; box-shadow: 0 0 10px #000; object-fit: cover;">
          @endif
            <h1 class="fw-bold mb-2">{{ $upcoming->title }}</h1>

            <div class="upcoming-meta" style="transition: margin-top 0.6s ease;">
              <p class="text-white-50 mb-3">{{ $upcoming->category ? implode(', ', $upcoming->category) : 'Kategori belum tersedia.' }}</p>
              <div class="d-flex gap-3">
                  <a href="{{ route('dramabox.detail', $upcoming->id) }}" 
                    class="btn btn-light text-dark fw-semibold px-4 py-2 d-flex align-items-center gap-2 fs-5">
                    <i class="bi bi-play-fill"></i> Putar
                  </a>
                  <button type="button" class="btn btn-secondary fw-semibold px-4 py-2 d-flex align-items-center gap-2 fs-5" 
                    data-bs-toggle="modal" data-bs-target="#detailModal{{ $upcoming->id }}">
                    <i class="bi bi-info-circle"></i> Selengkapnya
                  </button>
                </div>
              <!-- Modal -->
              <div class="modal fade" id="detailModal{{ $upcoming->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $upcoming->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content bg-dark text-white">
                    <div class="modal-header border-0">
                      <h5 class="modal-title" id="detailModalLabel{{ $upcoming->id }}">{{ $upcoming->title }}</h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row g-4">
                        <div class="col-md-4">
                          <img src="{{ $upcoming->poster_url }}" alt="{{ $upcoming->title }}" 
                            class="img-fluid rounded" style="width: 100%; height: 300px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                          <p class="text-muted mb-2">{{ $upcoming->year ?? 'Tahun tidak tersedia' }} | {{ $upcoming->duration ?? 'Durasi tidak tersedia' }} | {{ $upcoming->rating ?? 'Rating tidak tersedia' }}</p>
                          <p>{{ $upcoming->synopsis ?? 'Sinopsis tidak tersedia.' }}</p>
                          <p><small class="text-muted">Pemeran: {{ $upcoming->cast ?? 'Pemeran tidak tersedia.' }}</small></p>
                          <p><small class="text-muted">Genre: {{ $upcoming->genre ?? 'Genre tidak tersedia.' }}</small></p>
                          <p><small class="text-muted">Kategori: {{ $upcoming->category ? implode(', ', $upcoming->category) : 'Kategori belum tersedia.' }}</small></p>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer border-0">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="container my-4">
  <h1 class="display-5 fw-bold mb-4">Film Populer</h1>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if ($populars->isEmpty())
    <p class="text-center text-muted py-4">Tidak ada film populer yang diunggah.</p>
  @else
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
      @foreach ($populars as $popular)
        <div class="col">
          <div class="card bg-dark text-white h-100 d-flex flex-column">
            @if ($popular->poster_url)
              <img 
                src="{{ $popular->poster_url }}" 
                class="card-img-top w-100" 
                alt="{{ $popular->title }}" 
                style="height: 300px; object-fit: cover;">
            @else
              <img 
                src="{{ asset('Drama__box.png') }}" 
                class="card-img-top w-100" 
                alt="{{ $popular->title }}" 
                style="height: 300px; object-fit: cover;">
            @endif
            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-truncate">{{ $popular->title }}</h5>
              <p class="card-text mb-2">
                <small>★ {{ $popular->rating ?? rand(5, 7) . '.' . rand(0, 9) }}</small> |
                <small>{{ $popular->duration ?? '01:30' }} HD</small>
              </p>
              <p class="card-text">{{ Str::limit($popular->description, 100) }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</section>


<section class="container my-4">
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
          $episodes = is_string($video->episodes) 
            ? (json_decode($video->episodes, true) ?? [$video->episodes]) 
            : ($video->episodes ?? []);
        @endphp

        <div class="col">
          <a href="{{ route('dramabox.detail', $video->id) }}" class="text-decoration-none text-white">
            <div class="card h-100">
              @if ($video->video_file)
                <video controls class="card-img-top" preload="metadata">
                  <source src="{{ asset('videos/' . $video->video_file) }}" type="video/mp4">
                  Your browser does not support the video tag.
                </video>
              @else
                <img src="{{ asset('Drama__box.png') }}" class="card-img-top" alt="{{ $video->name }}">
              @endif

              <div class="card-body">
                <h5 class="card-title">{{ $video->name }}</h5>
                <p class="card-text">{{ $video->description }}</p>

                <p class="card-text text-muted mb-2">
                  <strong>Category:</strong> {{ $video->category }}<br>
                  <strong>Rating:</strong> {{ $video->rating }}<br>
                  <strong>Popular:</strong> {{ $video->is_popular ? 'Yes' : 'No' }}<br>
                  <strong>Episodes:</strong> {{ count($episodes) }}
                </p>

                <div>
                  @if (!empty($episodes))
                    @foreach ($episodes as $index => $episodePath)
                      <a href="{{ asset('episodes/' . $episodePath) }}" target="_blank" class="btn btn-sm btn-primary me-1 mb-1">
                        Episode {{ $index + 1 }}
                      </a>
                    @endforeach
                  @else
                    <small class="text-muted">No episodes</small>
                  @endif
                </div>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  @endif
</section>


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
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  new Swiper('.netflixSwiper', {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    autoplay: {
      delay: 6000,
      disableOnInteraction: false,
    },
    effect: 'slide',
    grabCursor: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
</script>



</html>

