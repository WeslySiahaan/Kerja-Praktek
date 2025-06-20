<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('CapekLaLogo.png') }}">
  <title>MoraClips</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  @yield('styles')
  <style>
    body {
      background: linear-gradient(180deg, #000000 0%, #4a3c00 100%);
      color: #fff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .navbar {
      background-color: #000;
      border-bottom: 1px solid #333;
    }
    .navbar-nav .nav-link {
      color: #fff !important;
      font-size: 18px;
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
      padding-top: 20px;
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
    .like-btn i.bi-heart-fill {
        animation: heart-pulse 0.3s ease-in-out;
    }
    @keyframes heart-pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #141414;">
    <div class="container-fluid">
      <img src="{{ asset('CapekLaLogo.png') }}" alt="Logo" style="height: 75px;">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('users.dashboard') }}">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="kategoriToggle" href="users.browse">Kategori</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('users.rekomendasi') }}">Rekomendasi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('users.koleksi') }}">Koleksi</a>
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
        <!-- Right Side: Search and Profile -->
<div class="d-flex align-items-center gap-3">
    <!-- Search Form -->
    <form class="d-flex align-items-center ms-2 position-relative" id="searchForm" method="GET" action="{{ route('dramabox.search') }}">
          <button type="button" class="btn btn-outline-secondary" id="searchToggle" aria-label="Toggle Search">
            <i class="bi bi-search"></i>
          </button>
          <input
            id="searchInput"
            class="form-control ms-2 d-none"
            type="search"
            name="query"
            placeholder="Cari berdasarkan nama..."
            aria-label="Search"
            value="{{ request('query') }}">
          <button type="submit" class="d-none" id="submitSearchButton"></button>
        </form>

    <!-- Profile -->
    @auth
        <a href="{{ route('profile.edit') }}" class="nav-link text-white d-flex align-items-center">
            <img
                src="{{ auth()->user()->profile_photo_path ? route('profile.image', ['filename' => basename(auth()->user()->profile_photo_path)]) : asset('user.png') }}"
                alt="Foto Profil"
                class="rounded-circle"
                style="width: 32px; height: 32px; object-fit: cover; border: 2px solid #ffffff;">
        </a>
    @else
        <a class="nav-link text-white" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a>
    @endauth
</div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Logic untuk toggle kategori
      const kategoriToggle = document.getElementById('kategoriToggle');
      const kategoriNavbar = document.getElementById('kategoriNavbar');

      kategoriToggle.addEventListener('click', function (event) {
        event.preventDefault();
        kategoriNavbar.classList.toggle('d-none');
      });

      // Logic untuk pencarian
      const searchToggle = document.getElementById('searchToggle');
      const searchInput = document.getElementById('searchInput');
      const searchForm = document.getElementById('searchForm'); // Tambahkan ID ke form
      const submitSearchButton = document.getElementById('submitSearchButton'); // Tombol submit tersembunyi

      searchToggle.addEventListener('click', function () {
        searchInput.classList.toggle('d-none'); // Toggle visibilitas input
        if (!searchInput.classList.contains('d-none')) {
          searchInput.focus(); // Fokus ke input jika terlihat
        }
      });

      // Opsional: Otomatis submit form saat Enter ditekan di input pencarian
      searchInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
          event.preventDefault(); // Mencegah form submit default dari Enter
          if (searchInput.value.trim() !== '') { // Hanya submit jika ada input
            searchForm.submit(); // Submit form secara manual
          }
        }
      });

      // Opsional: Sembunyikan input dan submit form saat klik di luar input pencarian
      document.addEventListener('click', function(event) {
        if (!searchForm.contains(event.target) && !searchInput.classList.contains('d-none')) {
          // Jika klik di luar form pencarian DAN input pencarian terlihat
          if (searchInput.value.trim() !== '') { // Hanya submit jika ada input
            searchForm.submit();
          }
          searchInput.classList.add('d-none'); // Sembunyikan input kembali
        }
      });
    });

    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const icon = this.querySelector('i');
            if (icon.classList.contains('bi-heart')) {
                icon.classList.remove('bi-heart', 'text-white');
                icon.classList.add('bi-heart-fill', 'text-danger');
            } else {
                icon.classList.remove('bi-heart-fill', 'text-danger');
                icon.classList.add('bi-heart', 'text-white');
            }
        });
    });
  </script>

  <main>
    @yield('content')
  </main>

  <footer class="bg-dark text-white">
    <div class="container">
      <div class="row justify-content-center text-center text-md-start">
        <div class="col-6 col-md-2 mb-3">
          <h5>Tentang</h5>
          <ul class="list-unstyled">
            <li><a href="#">Syarat & Ketentuan</a></li>
            <li><a href="#">Kebijakan Privasi</a></li>
          </ul>
        </div>
        <div class="col-6 col-md-2 mb-3">
          <h5>Lainnya</h5>
          <ul class="list-unstyled">
            <li><a href="#">Resource</a></li>
          </ul>
        </div>
        <div class="col-6 col-md-2 mb-3">
          <h5>Kontak Kami</h5>
          <ul class="list-unstyled">
            <li><a href="mailto:info@moratek.id">Email:info@moratek.id</a></li>
          </ul>
        </div>
        <div class="col-6 col-md-2 mb-3">
          <h5>Bergabung</h5>
          <ul class="list-unstyled">
            <li><a href="#">Kolaborasi Bisnis</a></li>
            <li><a href="#">info@moratek.id</a></li>
          </ul>
        </div>
        <div class="col-6 col-md-2 mb-3 text-center">
          <h5>Komunitas</h5>
          <ul class="list-unstyled d-flex justify-content-center gap-3">
            <li><a href="#"><i class="fab fa-facebook fa-lg text-white"></i></a></li>
            <li><a href="#"><i class="fab fa-youtube fa-lg text-white"></i></a></li>
            <li><a href="#"><i class="fab fa-instagram fa-lg text-white"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter fa-lg text-white"></i></a></li>
          </ul>
        </div>
      </div>
</body>
</html>