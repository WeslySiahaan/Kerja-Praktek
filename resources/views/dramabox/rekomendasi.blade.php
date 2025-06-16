<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('logo_1.png') }}">
  <title>Cinemora</title>

  <!-- Bootstrap & Icons -->
   
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { 
      background-color: #000; 
      color: #fff; 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .navbar { 
      background-color: #1a1a1a; 
      border-bottom: 1px solid #333; 
      padding: 0.5rem 0;
    }
    .navbar-brand { 
      color: #ff4500 !important; 
      font-size: 24px; 
      font-weight: bold; 
      display: flex;
      align-items: center;
    }
    .navbar-nav .nav-link { 
      color: #fff !important; 
      font-weight: 500;
      margin: 0 10px;
    }
    .navbar-nav .nav-link:hover { color: #ff4500 !important; }
    .navbar-nav .nav-link.active { color: #DBB941 !important; }
    .form-control { background-color: #333; border: none; color: #fff; }
    .form-control::placeholder { color: #ccc; }
    
    .main-content {
      padding: 2rem 0;
      min-height: calc(100vh - 200px);
    }
    
    .page-title {
      color: #fff;
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 2rem;
    }

    .movie-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(300px, 1fr)); /* Tetap 2 kolom pada layar standar */
      gap: 1.5rem;
      margin-bottom: 2rem;
    }
    
    .movie-card {
      background-color: #1a1a1a;
      border-radius: 8px;
      overflow: hidden;
      display: flex;
      transition: transform 0.3s ease;
      align-items: flex-start;
    }

    .movie-card:hover {
      transform: translateY(-5px);
    }

    .movie-poster {
      width: 120px;
      height: 160px;
      object-fit: cover;
      flex-shrink: 0;
    }

    .movie-info {
      padding: 0.5rem 1rem; /* Mengurangi padding atas untuk mendekatkan judul ke gambar */
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }

    .movie-title {
      color: #fff;
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      margin-top: -5px; /* Pengaturan tunggal untuk mengangkat semua judul sejajar dengan gambar */
    }

    .movie-genre {
      color: #888;
      font-size: 0.9rem;
      margin-bottom: 0.5rem;
    }

    .movie-description {
      color: #fff;
      font-size: 0.9rem;
      line-height: 1.4;
      margin-bottom: 1rem;
      flex: 1;
    }
    
    .watch-btn {
      background-color: #DBB941;
      color: #fff;
      border: none;
      padding: 0.25rem 0.75rem; /* Reduced padding for single line */
      border-radius: 4px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
      align-self: flex-start;
      white-space: nowrap; /* Prevents text wrapping */
    }
    
    .watch-btn:hover {
      background-color: #DBB941;
    }
    
    .watch-btn i {
      margin-right: 0.25rem; 
    }
    
    footer { 
      background-color: #1a1a1a; 
      color: #fff; 
      border-top: 1px solid #333;
      margin-top: 3rem;
    }
    footer a { color: #ccc; text-decoration: none; }
    footer a:hover { color: #ff4500; }
    .footer-bottom { border-top: 1px solid #333; color: #999; }
    
    @media (max-width: 768px) {
      .movie-grid {
        grid-template-columns: repeat(2, minmax(150px, 1fr)); 
        overflow-x: auto; 
      }
      .movie-card {
        flex-direction: column;
        min-width: 150px; 
      }
      .movie-poster {
        width: 100%;
        height: 200px; /* Sesuaikan tinggi untuk layar kecil */
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('dramabox.beranda') }}">
        <img src="{{ asset('logo_1.png') }}" alt="Logo" style="height: 50px; margin-right: 20px;">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="{{ route('dramabox.beranda') }}">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('dramabox.browse') }}">Kategori</a></li>
          <li class="nav-item"><a class="nav-link active" href="{{ route('dramabox.rekomendasi') }}">Rekomendasi</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('dramabox.koleksi') }}">Koleksi</a></li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="#">Login</a></li>
        </ul>
        <form class="d-flex align-items-center ms-2 position-relative" method="GET" action="{{ route('dramabox.search') }}">
          <button type="button" class="btn btn-outline-secondary" id="searchToggle"><i class="bi bi-search"></i></button>
          <input id="searchInput" class="form-control ms-2 d-none" type="search" name="query" placeholder="Search by name" value="{{ request('query') }}">
        </form>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container main-content">
    <h1 class="page-title">Rekomendasi Teratas untuk Anda</h1>
    
    <div class="movie-grid">
      <!-- Movie 1 -->
      <div class="movie-card">
        <img src="{{ asset('Drama__box.png') }}" alt="Final Shot" class="movie-poster">
        <div class="movie-info">
          <h3 class="movie-title">Final Shot</h3>
          <p class="movie-genre">Aksi / Spionase</p>
          <p class="movie-description">Seorang agen intelijen menentukan sebuah kebenaran fatal dalam sistem pengawasan metropolitan Jakarta yang baru... <strong>Lihat selengkapnya</strong></p>
          <button class="watch-btn">
            <i class="bi bi-play"></i>Tonton Sekarang
          </button>
        </div>
      </div>

      <!-- Movie 2 -->
      <div class="movie-card">
        <img src="{{ asset('Drama__box.png') }}" alt="The Commando" class="movie-poster">
        <div class="movie-info">
          <h3 class="movie-title">The Commando</h3>
          <p class="movie-genre">Aksi / Militer</p>
          <p class="movie-description">Sebuah unit pasukan khusus elit dikirim dalam misi penyusup untuk menyelam ke pulau terpencil yang dikuasai oleh tentara bayaran... <strong>Lihat selengkapnya</strong></p>
          <button class="watch-btn">
            <i class="bi bi-play"></i>Tonton Sekarang
          </button>
        </div>
      </div>

      <!-- Movie 3 -->
      <div class="movie-card">
        <img src="{{ asset('Drama__box.png') }}" alt="Mojave Diamonds" class="movie-poster">
        <div class="movie-info">
          <h3 class="movie-title">Mojave Diamonds</h3>
          <p class="movie-genre">Aksi / Perampokan (Heist)</p>
          <p class="movie-description">Seorang ahli strategi perampok legendaris kembali dari masa pensiunnya untuk satu pekerjaan terakhir... <strong>Lihat selengkapnya</strong></p>
          <button class="watch-btn">
            <i class="bi bi-play"></i>Tonton Sekarang
          </button>
        </div>
      </div>

      <!-- Movie 4 -->
      <div class="movie-card">
        <img src="{{ asset('Drama__box.png') }}" alt="The Comedy" class="movie-poster">
        <div class="movie-info">
          <h3 class="movie-title">The Comedy</h3>
          <p class="movie-genre">Aksi / Komedi</p>
          <p class="movie-description">Di masa depan, seorang prajurit android eksperimental dengan kemampuan tempur superior... <strong>Lihat selengkapnya</strong></p>
          <button class="watch-btn">
            <i class="bi bi-play"></i>Tonton Sekarang
          </button>
        </div>
      </div>

      <!-- Movie 5 -->
      <div class="movie-card">
        <img src="{{ asset('Drama__box.png') }}" alt="Bidak Emas Terakhir" class="movie-poster">
        <div class="movie-info">
          <h3 class="movie-title">Bidak Emas Terakhir</h3>
          <p class="movie-genre">Aksi / Perampokan (Heist)</p>
          <p class="movie-description">Seorang ahli strategi perampok legendaris kembali dari masa pensiunnya untuk satu pekerjaan terakhir... <strong>Lihat selengkapnya</strong></p>
          <button class="watch-btn">
            <i class="bi bi-play"></i>Tonton Sekarang
          </button>
        </div>
      </div>

      <!-- Movie 6 -->
      <div class="movie-card">
        <img src="{{ asset('Drama__box.png') }}" alt="Venom" class="movie-poster">
        <div class="movie-info">
          <h3 class="movie-title">Venom</h3>
          <p class="movie-genre">Aksi / Fiksi Ilmiah</p>
          <p class="movie-description">Di masa depan, seorang prajurit android eksperimental dengan kemampuan tempur superior... <strong>Lihat selengkapnya</strong></p>
          <button class="watch-btn">
            <i class="bi bi-play"></i>Tonton Sekarang
          </button>
        </div>
      </div>

      <!-- Movie 7 -->
      <div class="movie-card">
        <img src="{{ asset('Drama__box.png') }}" alt="Meltdown" class="movie-poster">
        <div class="movie-info">
          <h3 class="movie-title">Meltdown</h3>
          <p class="movie-genre">Aksi / Perampokan (Heist)</p>
          <p class="movie-description">Seorang ahli strategi perampok legendaris kembali dari masa pensiunnya untuk satu pekerjaan terakhir... <strong>Lihat selengkapnya</strong></p>
          <button class="watch-btn">
            <i class="bi bi-play"></i>Tonton Sekarang
          </button>
        </div>
      </div>

      <!-- Movie 8 -->
      <div class="movie-card">
        <img src="{{ asset('Drama__box.png') }}" alt="Taverian Mystery" class="movie-poster">
        <div class="movie-info">
          <h3 class="movie-title">Taverian Mystery</h3>
          <p class="movie-genre">Aksi / Misteri</p>
          <p class="movie-description">Di masa depan, seorang prajurit android eksperimental dengan kemampuan tempur superior... <strong>Lihat selengkapnya</strong></p>
          <button class="watch-btn">
            <i class="bi bi-play"></i>Tonton Sekarang
          </button>
        </div>
      </div>
    </div>
    
  </div>

 <!-- Footer -->
<footer class="py-4" style="background-color: #1a1a1a; color: #fff; border-top: 1px solid #333;">
  <div class="container">
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 text-center text-md-start gy-4">
      <div class="col">
        <h5 class="mb-2" style="color: #fff;">Tentang</h5>
        <ul class="list-unstyled mb-0">
          <li><a href="#" class="text-secondary text-decoration-none">Terms of Use</a></li>
          <li><a href="#" class="text-secondary text-decoration-none">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="col">
        <h5 class="mb-2" style="color: #fff;">Lainnya</h5>
        <ul class="list-unstyled mb-0">
          <li><a href="#" class="text-secondary text-decoration-none">Resources</a></li>
        </ul>
      </div>
      <div class="col">
        <h5 class="mb-2" style="color: #fff;">Kontak Kami</h5>
        <ul class="list-unstyled mb-0">
          <li><a href="mailto:info@moratek.id" class="text-secondary text-decoration-none">Email: info@moratek.id</a></li>
          <li><a href="#" class="text-secondary text-decoration-none">Business Collaborations</a></li>
        </ul>
      </div>
      <div class="col">
        <h5 class="mb-2" style="color: #fff;">Bergabung</h5>
        <ul class="list-unstyled mb-0">
          <li><a href="mailto:info@moratek.id" class="text-secondary text-decoration-none">Email: info@moratek.id</a></li>
        </ul>
      </div>
      <div class="col">
        <h5 class="mb-2" style="color: #fff;">Komunitas</h5>
        <ul class="list-unstyled d-flex justify-content-center justify-content-md-start mb-0">
          <li class="me-3"><a href="#" class="text-secondary text-decoration-none"><i class="bi bi-facebook" style="font-size: 1.5rem;"></i></a></li>
          <li class="me-3"><a href="#" class="text-secondary text-decoration-none"><i class="bi bi-instagram" style="font-size: 1.5rem;"></i></a></li>
          <li class="me-3"><a href="#" class="text-secondary text-decoration-none"><i class="bi bi-twitter" style="font-size: 1.5rem;"></i></a></li>
          <li><a href="#" class="text-secondary text-decoration-none"><i class="bi bi-youtube" style="font-size: 1.5rem;"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom mt-4 pt-3 text-center" style="border-top: 1px solid #333; color: #999;">
      <p class="mb-0">© Cinemora, All Rights Reserved StoryMatrix Pte.Ltd.</p>
    </div>
  </div>
</footer>


  <script>
    const toggleBtn = document.getElementById('searchToggle');
    const searchInput = document.getElementById('searchInput');
    
    if (toggleBtn && searchInput) {
      toggleBtn.addEventListener('click', () => {
        searchInput.classList.toggle('d-none');
        if (!searchInput.classList.contains('d-none')) {
          searchInput.focus();
        }
      });
    }
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>