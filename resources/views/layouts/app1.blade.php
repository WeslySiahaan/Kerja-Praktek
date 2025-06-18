<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('logo_1.png') }}">
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

/* Tambahan khusus untuk geser kolom "Kontak Kami" */
footer .col-md-2:nth-child(3) {
  margin-left: -40px; /* Atur sesuai kebutuhan */
}
footer .col-md-2:nth-child(4) {
  padding-left: 40px;
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
      <a href="{{ route('login') }}" class="btn btn-warning ms-3">Login</a>
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

  @yield('content')

  <!-- Footer -->
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
          <li><a href="mailto:support@moraclips.com">Email:info@moratek.id</a></li>
          
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
    </div>
    <div class="footer-bottom text-center mt-3">
      © MoraClips 2025 - All rights reserved.
    </div>
  </div>
</footer>