<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('tanpaBG.png') }}">
    <title>CineMora</title>
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    @yield('styles') {{-- Ini adalah slot untuk CSS kustom dari halaman anak --}}

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
        /* Perbaiki agar .navbar di layout ini menggunakan warna yang sama dengan navbar di partial */
        .navbar-top { /* Menambahkan kelas untuk membedakan navbar atas */
            background-color: #141414 !important; /* Sesuaikan dengan navbar atas Anda */
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
            margin-top: auto; /* Penting: Dorong footer ke bawah */
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
        /* Styling untuk tombol kategori aktif */
        .category-buttons .btn.active {
            color: #fff !important; /* Warna teks putih saat aktif */
            background-color: #DBB941 !important; /* Warna latar belakang saat aktif */
            border-color: #DBB941 !important; /* Warna border saat aktif */
        }
        .category-buttons .btn.active:hover {
            background-color: #c09d35 !important; /* Sedikit lebih gelap saat hover */
            border-color: #c09d35 !important;
        }

    </style>
</head>
<body>
    {{-- Navbar Utama Aplikasi --}}
    <nav class="navbar navbar-expand-lg navbar-dark navbar-top"> {{-- Tambahkan kelas navbar-top untuk styling lebih spesifik --}}
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
                        <a class="nav-link" href="{{ route('users.browse') }}">Kategori</a>
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
                <div class="d-flex align-items-center gap-3">
                    <form class="d-flex align-items-center ms-2 position-relative" id="searchForm" method="GET" action="{{ route('users.search') }}">
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

    {{-- SLOT UNTUK CATEGORY NAVBAR --}}
    {{-- Ini adalah tempat di mana @section('category_navbar') dari halaman anak akan di-render --}}
    @yield('category_navbar')

    {{-- Tag <main> harus ada di dalam <body> --}}
    <main>
        @yield('content') {{-- SLOT UNTUK KONTEN UTAMA DARI HALAMAN ANAK --}}
    </main>

    <footer class="bg-dark text-white py-4 mt-auto"> {{-- Menambah py-4 dan mt-auto --}}
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
            <div class="footer-bottom text-center pt-3 mt-3">
                <p>&copy; {{ date('Y') }} CineMora. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS dimuat HANYA SEKALI di sini, di akhir body --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    {{-- Skrip khusus layout ini --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Logic untuk pencarian
            const searchToggle = document.getElementById('searchToggle');
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');

            if (searchToggle && searchInput && searchForm) { // Tambahkan pengecekan null untuk keamanan
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
            }

            // Logic untuk like button (jika ada di layout utama ini)
            // Hati-hati: jika like button hanya ada di halaman konten, ini mungkin tidak diperlukan di layout
            document.querySelectorAll('.like-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    // Jika Anda menggunakan AJAX untuk like/unlike, event.preventDefault() perlu ditambahkan
                    // e.preventDefault(); // Uncomment jika Anda menangani like via AJAX

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
        });
    </script>
    
    {{-- SLOT PENTING: Untuk script tambahan dari halaman konten seperti koleksi.blade.php --}}
    @stack('scripts') 
</body>
</html>
