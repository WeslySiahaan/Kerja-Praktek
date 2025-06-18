<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('logo_1.png') }}">
  <title>MoraClips</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(180deg, #000000 0%, #4a3c00 100%);
      color: #fff;
      min-height: 100vh;
    }
    .navbar {
      background-color: #000;
      border-bottom: 1px solid #333;
    }
    .navbar-nav .nav-link {
      color: #fff !important;
    }
    .navbar-nav .nav-link:hover {
      color: #DBB941 !important;
    }
    .nav-link.active {
      color: #ffc107 !important;
      font-weight: bold;
    }
    .form-control {
      background-color: #333;
      border: none;
      color: #fff;
    }
    .form-control::placeholder {
      color: #ccc;
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
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <img src="{{ asset('logo_1.png') }}" alt="Logo" style="height: 75px;">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dramabox.beranda') ? 'active' : '' }}" href="{{ route('dramabox.beranda') }}">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dramabox.browse') ? 'active' : '' }}" href="{{ route('dramabox.browse') }}">Kategori</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dramabox.rekomendasi') ? 'active' : '' }}" href="{{ route('dramabox.rekomendasi') }}">Rekomendasi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dramabox.koleksi') ? 'active' : '' }}" href="{{ route('dramabox.koleksi') }}">Koleksi</a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link {{ request()->get('lang') === 'en' ? 'active' : '' }}" href="?lang=en">English</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->get('lang') === 'id' ? 'active' : '' }}" href="?lang=id">Indonesia</a>
          </li>
        </ul>
        <form class="d-flex align-items-center ms-2 position-relative" method="GET" action="{{ route('dramabox.search') }}">
          <button type="button" class="btn btn-outline-secondary" id="searchToggle" aria-label="Toggle Search">
            <i class="bi bi-search"></i>
          </button>
          <input
            id="searchInput"
            class="form-control ms-2 d-none"
            type="search"
            name="query"
            placeholder="Search by name"
            aria-label="Search"
            value="{{ request('query') }}">
        </form>
        @if (Route::has('login'))
        <div class="d-flex ms-2">
          <a href="{{ route('login') }}" class="btn btn-primary me-2">Log in</a>
        </div>
        @endif
      </div>
    </div>
  </nav>

  @yield('content')

  <footer class="bg-dark text-light py-4">
    <div class="container">
      <div class="row g-4 justify-content-center">
        <div class="col-12 col-md-2">
          <h5 class="mb-3 text-center">Tentang</h5>
          <ul class="list-unstyled text-center">
            <li><a href="#" class="d-block mb-2">Terms of Use</a></li>
            <li><a href="#" class="d-block mb-2">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-12 col-md-2">
          <h5 class="mb-3 text-center">Kontak Kami</h5>
          <ul class="list-unstyled text-center">
            <li><a href="mailto:feedback@dramabox.com" class="d-block mb-2">Email: info[at]moratek.id</a></li>
          </ul>
        </div>
        <div class="col-12 col-md-2">
          <h5 class="mb-3 text-center">Komunitas</h5>
          <ul class="list-unstyled text-center">
            <li><a href="#" class="d-block mb-2">Facebook</a></li>
            <li><a href="#" class="d-block mb-2">YouTube</a></li>
            <li><a href="#" class="d-block mb-2">TikTok</a></li>
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
    const toggleBtn = document.getElementById('searchToggle');
    const searchInput = document.getElementById('searchInput');
    toggleBtn.addEventListener('click', () => {
      searchInput.classList.toggle('d-none');
      if (!searchInput.classList.contains('d-none')) {
        searchInput.focus();
      }
    });
  </script>
</body>
</html>