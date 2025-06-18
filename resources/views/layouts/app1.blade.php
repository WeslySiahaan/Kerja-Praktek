<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('logo_1.png') }}">
  <title>MoraClips</title>
  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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

    .navbar-brand {
      color: #ff4500 !important;
      font-size: 24px;
      font-weight: bold;
    }

    .navbar-nav .nav-link {
      color: #fff !important;
    }

    .navbar-nav .nav-link:hover {
      color: #DBB941 !important;
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

    .card-img-top,
    .card video {
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
 <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #141414;">
  <div class="container-fluid">
    <img src="{{ asset('logo_1.png') }}" alt="Logo" style="height: 75px;">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dramabox.beranda') }}">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="kategoriToggle" href="#">Kategori</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dramabox.rekomendasi') }}">Rekomendasi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dramabox.koleksi') }}">Koleksi</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="?lang=en">English</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?lang=id">Indonesia</a>
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
      <a href="#" class="btn btn-warning ms-3">Login</a>
    </div>
  </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-dark d-none" id="kategoriNavbar" style="background-color: #141414; border-top: 1px solid #333;">
  <div class="container-fluid">
    <div class="d-flex align-items-center">
      <h5 class="text-white mb-0 me-4">Film</h5>
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          Semua Genre
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li><a class="dropdown-item" href="#">Aksi</a></li>
          <li><a class="dropdown-item" href="#">Komedi</a></li>
          <li><a class="dropdown-item" href="#">Horor</a></li>
          <li><a class="dropdown-item" href="#">Romantis</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Target diubah ke #kategoriToggle dan #kategoriNavbar
    const kategoriToggle = document.getElementById('kategoriToggle');
    const kategoriNavbar = document.getElementById('kategoriNavbar');

    kategoriToggle.addEventListener('click', function (event) {
      event.preventDefault();
      
      // Toggle class 'd-none' pada navbar kategori
      kategoriNavbar.classList.toggle('d-none');
    });
  });
</script>

  <!-- Content placeholder -->
  @yield('content')

  <!-- Footer menggunakan Bootstrap dengan jarak yang lebih pas -->
 <footer class="bg-dark text-light py-4">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-md-2">
                <h5 class="mb-3 text-center">Tentang</h5>
                <ul class="list-unstyled text-center">
                    <li><a href="#" class="text-orange d-block mb-2">Terms of Use</a></li>
                    <li><a href="#" class="text-light d-block mb-2">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-2">
                <h5 class="mb-3 text-center">Lainnya</h5>
                <ul class="list-unstyled text-center">
                    <li><a href="#" class="text-light d-block mb-2">Resources</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-2">
                <h5 class="mb-3 text-center">Kontak Kami</h5>
                <ul class="list-unstyled text-center">
                    <li><a href="mailto:feedback@dramabox.com" class="text-light d-block mb-2">Email:info[at]moratek.id</a></li>
                    
                </ul>
            </div>
            <div class="col-12 col-md-2">
                <h5 class="mb-3 text-center">Bergabung</h5>
                <ul class="list-unstyled text-center">
                    <li><a href="#" class="text-light d-block mb-2">Email:info[at]moratek.id</a></li>
                    <li><a href="#" class="text-light d-block mb-2">Business Collaborations</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-2">
                <h5 class="mb-3 text-center">Komunitas</h5>
                <ul class="list-unstyled text-center">
                    <li><a href="#" class="text-light d-block mb-2">Facebook</a></li>
                    <li><a href="#" class="text-light d-block mb-2">YouTube</a></li>
                    <li><a href="#" class="text-light d-block mb-2">TikTok</a></li>
                </ul>
            </div>
        </div>
      <div class="footer-bottom mt-3 text-center">
        © DramaBox, All Rights Reserved StoryMatrix Pte.Ltd.
      </div>
    </div>
  </footer>

  <!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content px-4 py-4" style="border-radius: 20px; background: #ffffff;">

      <!-- Title & Close -->
      <div class="position-relative mb-3">
        <h5 class="modal-title fw-bold text-center mb-0" style="font-size: 1.6rem; color: #111;">Masuk</h5>
        <button type="button" class="btn-close position-absolute top-0 end-0" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="d-flex align-items-center px-3 py-2 mb-2" style="gap: 8px; border: 1px solid #D0D0D0; border-radius: 10px;">
          <i class="bi bi-envelope-fill text-dark"></i>
          <input type="email" name="email" class="form-control border-0 bg-transparent shadow-none small"
                 placeholder="Email" required autocomplete="email"
                 style="font-size: 0.95rem; padding: 6px 0;">
        </div>

        <!-- Password -->
        <div class="d-flex align-items-center px-3 py-2 mb-3" style="gap: 8px; border: 1px solid #D0D0D0; border-radius: 10px;">
          <i class="bi bi-lock-fill text-dark"></i>
          <input type="password" name="password" class="form-control border-0 bg-transparent shadow-none small"
                 placeholder="Kata Sandi" required autocomplete="current-password"
                 style="font-size: 0.95rem; padding: 6px 0;">
        </div>

        <!-- Tombol Masuk -->
        <button type="submit" class="btn w-100 fw-semibold text-dark mb-3"
                style="background-color: #FDD835; border-radius: 10px; padding: 8px 0; font-size: 0.95rem;">
          Masuk
        </button>
      </form>

      <!-- Garis atau -->
      <div class="d-flex align-items-center justify-content-between mb-3 text-muted" style="font-weight: 500;">
        <hr class="flex-grow-1" style="height: 1px; background-color: #ccc;">
        <span class="px-2 small">atau</span>
        <hr class="flex-grow-1" style="height: 1px; background-color: #ccc;">
      </div>

      <!-- Login dengan Google -->
      <a href="{{ route('google.redirect') }}" class="d-flex align-items-center justify-content-center gap-2 text-dark text-decoration-none px-3 py-2 rounded-3 mb-3"
         style="background-color: #fff; border: 1px solid #D0D0D0;">
        <img src="https://developers.google.com/identity/images/g-logo.png" width="18" height="18" alt="Google logo">
        <span class="fw-medium small">Masuk dengan Google</span>
      </a>

      <!-- Link ke Daftar -->
      <div class="text-center">
        <a href="#" class="fw-bold text-warning text-decoration-none"
           data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">
          Daftar Akun Baru
        </a>
      </div>

    </div>
  </div>
</div>


<!-- Modal Register -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content px-4 py-4" style="border-radius: 20px; background: #fff;">

      <!-- Title & Close -->
      <div class="position-relative mb-3">
        <h5 class="modal-title text-center fw-bold mb-0" style="font-size: 1.6rem; color: #111;">Daftar Akun</h5>
        <button type="button" class="btn-close position-absolute top-0 end-0" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama -->
        <div class="d-flex align-items-center px-3 py-2 mb-2"
             style="gap: 8px; border: 1px solid #D0D0D0; border-radius: 10px;">
          <i class="bi bi-person-fill text-dark"></i>
          <input type="text" name="name"
                 class="form-control border-0 bg-transparent shadow-none small"
                 placeholder="Nama" required style="font-size: 0.95rem; padding: 6px 0;">
        </div>

        <!-- Email -->
        <div class="d-flex align-items-center px-3 py-2 mb-2"
             style="gap: 8px; border: 1px solid #D0D0D0; border-radius: 10px;">
          <i class="bi bi-envelope-fill text-dark"></i>
          <input type="email" name="email"
                 class="form-control border-0 bg-transparent shadow-none small"
                 placeholder="Email" required style="font-size: 0.95rem; padding: 6px 0;">
        </div>

        <!-- Password -->
        <div class="d-flex align-items-center px-3 py-2 mb-2"
             style="gap: 8px; border: 1px solid #D0D0D0; border-radius: 10px;">
          <i class="bi bi-lock-fill text-dark"></i>
          <input type="password" name="password"
                 class="form-control border-0 bg-transparent shadow-none small"
                 placeholder="Kata Sandi" required style="font-size: 0.95rem; padding: 6px 0;">
        </div>

        <!-- Konfirmasi Password -->
        <div class="d-flex align-items-center px-3 py-2 mb-3"
             style="gap: 8px; border: 1px solid #D0D0D0; border-radius: 10px;">
          <i class="bi bi-lock-fill text-dark"></i>
          <input type="password" name="password_confirmation"
                 class="form-control border-0 bg-transparent shadow-none small"
                 placeholder="Konfirmasi Kata Sandi" required style="font-size: 0.95rem; padding: 6px 0;">
        </div>

        <!-- Tombol Daftar -->
        <button type="submit"
                class="btn w-100 fw-semibold text-dark mb-3"
                style="background-color: #FDD835; border-radius: 10px; padding: 8px 0; font-size: 0.95rem;">
          Daftar
        </button>
      </form>

      <!-- Sudah punya akun -->
      <div class="text-center">
        <small class="text-warning fw-bold">Sudah punya akun?</small><br>
        <a href="#" class="fw-bold text-warning text-decoration-none"
           data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
          Masuk
        </a>
      </div>

    </div>
  </div>
</div>

  <!-- Bootstrap 5 JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>