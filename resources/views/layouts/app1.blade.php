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
            padding-bottom: 20px;
            flex-shrink: 0;
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
        footer .col-md-2:nth-child(3) {
            margin-left: -40px; 
        }
        footer .col-md-2:nth-child(4) {
            padding-left: 40px;
        }
        main {
            flex: 1 0 auto;
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
                        <a class="nav-link {{ Route::is('dramabox.beranda') ? 'active' : '' }}" href="{{ route('dramabox.beranda') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('dramabox.browse') ? 'active' : '' }}" href="{{ route('dramabox.browse') }}">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('dramabox.rekomendasi') ? 'active' : '' }}" href="{{ route('dramabox.rekomendasi') }}">Rekomendasi</a>
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
                <a href="{{ route('login') }}" class="btn btn-warning ms-3">Login</a>
            </div>
        </div>
    </nav>

    {{-- SLOT UNTUK NAVBAR KATEGORI --}}
    @yield('category_navbar')

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
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Logic untuk toggle kategori sudah dihapus karena tidak lagi diperlukan.

            // Logic untuk pencarian
            const searchToggle = document.getElementById('searchToggle');
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');
            const submitSearchButton = document.getElementById('submitSearchButton');

            searchToggle.addEventListener('click', function () {
                searchInput.classList.toggle('d-none');
                if (!searchInput.classList.contains('d-none')) {
                    searchInput.focus();
                }
            });

            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    if (searchInput.value.trim() !== '') {
                        searchForm.submit();
                    }
                }
            });

            document.addEventListener('click', function(event) {
                if (!searchForm.contains(event.target) && !searchInput.classList.contains('d-none')) {
                    if (searchInput.value.trim() !== '') {
                        searchForm.submit();
                    }
                    searchInput.classList.add('d-none');
                }
            });
        });
    </script>
    @stack('scripts') {{-- SLOT UNTUK SCRIPT TAMBAHAN DARI HALAMAN KONTEN --}}
</body>
</html>