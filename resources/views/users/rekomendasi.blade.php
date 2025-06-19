@extends('layouts.app2')

@section('content')
<style>
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
    grid-template-columns: repeat(2, minmax(300px, 1fr));
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
    padding: 0.5rem 1rem;
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
    margin-top: -5px;
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
    padding: 0.25rem 0.75rem;
    border-radius: 4px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
    align-self: flex-start;
    white-space: nowrap;
  }
  
  .watch-btn:hover {
    background-color: #DBB941;
  }
  
  .watch-btn i {
    margin-right: 0.25rem;
  }
  
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
      height: 200px;
    }
  }
</style>

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
    <!-- Movie 9-->
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
     <!-- Movie 10 -->
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
@endsection