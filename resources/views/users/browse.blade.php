@extends('layouts.app2') {{-- Pastikan layout ini benar --}}

@section('category_navbar')
    @include('profile.partials.category_navbar')
@endsection

@section('content')
<div class="container mt-4">
    {{-- Optional: Tampilkan query pencarian atau kategori yang aktif --}}
    @if(isset($query) && $query)
        <h3 class="text-white">Hasil Pencarian untuk: "{{ $query }}"</h3>
    @endif
    @if(isset($category) && $category && $category !== 'all')
        <h3 class="text-white">Filter Kategori: "{{ $category }}"</h3>
    @elseif(isset($category) && $category === 'all')
        <h3 class="text-white">Menampilkan Semua Kategori</h3>
    @endif

    {{-- Tampilkan Video --}}
    <section class="mb-5"> {{-- Tambahkan section untuk struktur yang lebih baik --}}
        <h2 class="display-6 fw-bold mb-4 px-3 text-white">Browse Videos</h2>
        @if($videos->isEmpty())
            <p class="text-center text-muted py-4 px-3">Tidak ada video ditemukan.</p>
        @else
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3">
                @foreach ($videos as $video)
                    <div class="col">
                        <div class="card bg-dark text-white h-100 d-flex flex-column">
                            <a href="{{ route('dramabox.detail', ['id' => $video->id]) }}" class="text-decoration-none text-white">
                                <img src="{{ $video->poster_image ? asset('storage/' . $video->poster_image) : asset('Drama__box.png') }}"
                                     class="card-img-top"
                                     alt="{{ $video->name }} poster"
                                     style="height: 300px; object-fit: cover;">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate">{{ $video->name }}</h5>
                                {{-- Menambahkan deskripsi singkat dari referensi Popular --}}
                                <p class="card-text">{{ Str::limit($video->description, 100) }}</p>

                                {{-- Baris Kategori (tetap ada sesuai permintaan Anda) --}}
                                <p class="card-text text-white"><small>Kategori: {{ is_array($video->category) ? implode(', ', $video->category) : $video->category }}</small></p>

                                {{-- Baris Jumlah Episode (sesuai referensi Popular, berwarna putih) --}}
                                <p class="card-title text-truncate text-white"><small>Ep {{ count($video->episodes ?? []) }}</small></p>
                                
                                <div class="mt-auto d-flex gap-2">
                                    {{-- Tombol Like/Save dari referensi Popular --}}
                                    @if (Auth::check())
                                        <form action="{{ route('videos.like', $video) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 like-btn" title="{{ $video->likedByUsers->contains(Auth::id()) ? 'Batal Suka' : 'Suka' }}">
                                                <i class="bi {{ $video->likedByUsers->contains(Auth::id()) ? 'bi-heart-fill text-danger' : 'bi-heart text-white' }} fs-5"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('videos.save', $video) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0" title="{{ $video->collectedByUsers->contains(Auth::id()) ? 'Sudah Disimpan' : 'Simpan' }}"
                                                    {{ $video->collectedByUsers->contains(Auth::id()) ? 'disabled' : '' }}>
                                                    <i class="bi {{ $video->collectedByUsers->contains(Auth::id()) ? 'bi-bookmark-fill text-success' : 'bi-bookmark text-white' }} fs-5"></i>
                                            </button>
                                        </form>
                                    @endif
                                    {{-- Tombol "Menonton" jika Anda tetap ingin di sini --}}
                                    <a href="{{ route('dramabox.detail', $video->id) }}" class="btn btn-primary btn-sm">Menonton</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
                  <!-- Pagination -->
<div style="margin-top: 20px;" class="d-flex justify-content-center">
  {{ $videos->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>
        @endif
    </section>

    {{-- Bagian Tampilkan Upcomings (jika ingin ditampilkan, aktifkan dan samakan strukturnya) --}}
    {{-- Hapus komentar jika ingin digunakan --}}
    {{--
    <section class="mb-5">
        <h2 class="display-6 fw-bold mb-4 px-3 text-white">Upcoming Shows</h2>
        @if($upcomings->isEmpty())
            <p class="text-center text-muted py-4 px-3">Tidak ada acara mendatang ditemukan.</p>
        @else
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3">
                @foreach($upcomings as $upcoming)
                    <div class="col">
                        <div class="card bg-dark text-white h-100 d-flex flex-column">
                            <a href="#" class="text-decoration-none text-white">
                                <img src="{{ $upcoming->poster ? asset('storage/' . $upcoming->poster) : asset('Drama__box.png') }}"
                                    class="card-img-top"
                                    alt="{{ $upcoming->title }} poster"
                                    style="height: 300px; object-fit: cover;">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate">{{ $upcoming->title }}</h5>
                                <p class="card-text">{{ Str::limit($upcoming->description, 100) ?? 'No description available.' }}</p> {{-- Tambahkan deskripsi 
                                <p class="card-text text-white"><small>Kategori: {{ is_array($upcoming->category) ? implode(', ', $upcoming->category) : $upcoming->category }}</small></p>
                                <p class="card-title text-truncate text-white"><small>Rilis: {{ $upcoming->release_date->format('d M Y') }}</small></p>
                                <div class="mt-auto d-flex gap-2">
                                    {{-- Placeholder untuk menjaga tinggi yang sama dengan ikon Like/Save di Popular 
                                    <div class="d-flex gap-2 invisible">
                                        <button type="button" class="btn btn-link p-0"><i class="bi bi-heart fs-5"></i></button>
                                        <button type="button" class="btn btn-link p-0"><i class="bi bi-bookmark fs-5"></i></button>
                                    </div>
                                    {{-- Jika ada tombol Menonton untuk Upcoming, tambahkan di sini 
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
    --}}

    {{-- Bagian Tampilkan Populars (jika ingin ditampilkan, aktifkan dan samakan strukturnya) --}}
    {{-- Hapus komentar jika ingin digunakan --}}
    {{--
    <section class="mb-5">
        <h2 class="display-6 fw-bold mb-4 px-3 text-white">Popular Shows</h2>
        @if($populars->isEmpty())
            <p class="text-center text-muted py-4 px-3">Tidak ada acara populer ditemukan.</p>
        @else
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3">
                @foreach($populars as $popular)
                    <div class="col">
                        <div class="card bg-dark text-white h-100 d-flex flex-column">
                            <a href="#" class="text-decoration-none text-white">
                                <img src="{{ $popular->poster ? asset('storage/' . $popular->poster) : asset('Drama__box.png') }}"
                                    class="card-img-top"
                                    alt="{{ $popular->title }} poster"
                                    style="height: 300px; object-fit: cover;">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate">{{ $popular->title }}</h5>
                                <p class="card-text">{{ Str::limit($popular->description, 100) ?? 'No description available.' }}</p> {{-- Tambahkan deskripsi 
                                <p class="card-text text-white"><small>Kategori: {{ is_array($popular->category) ? implode(', ', $popular->category) : $popular->category }}</small></p>
                                <p class="card-title text-truncate invisible"><small>Placeholder</small></p> {{-- Placeholder
                                <div class="mt-auto d-flex gap-2">
                                    @if (Auth::check())
                                        <form action="{{-- route('populars.like', $popular) " method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 like-btn" title="{{-- $popular->likedByUsers->contains(Auth::id()) ? 'Batal Suka' : 'Suka' ">
                                                <i class="bi bi-heart text-white fs-5"></i>
                                            </button>
                                        </form>
                                        <form action="{{-- route('populars.save', $popular) " method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0" title="{{-- $popular->collectedByUsers->contains(Auth::id()) ? 'Sudah Disimpan' : 'Simpan'">
                                                <i class="bi bi-bookmark text-white fs-5"></i>
                                            </button>
                                        </form>
                                    @endif
                                    {{-- Jika ada tombol Menonton untuk Popular, tambahkan di sini 
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
    --}}
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swipers = document.querySelectorAll('.swiper');
    swipers.forEach(s => {
        new Swiper(s, {
            slidesPerView: 6,
            spaceBetween: 15,
            freeMode: true,
        });
    });

    // Add click event for category buttons
    document.querySelectorAll('.category-buttons button').forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            // PERBAIKAN: Menggunakan route dramabox.search1
            window.location.href = `{{ route('users.search') }}?category=${category}`;
        });
    });

    // Optional: Add active class to the current category button
    const urlParams = new URLSearchParams(window.location.search);
    const activeCategory = urlParams.get('category') || 'all';
    document.querySelectorAll('.category-buttons button').forEach(button => {
        if (button.getAttribute('data-category') === activeCategory) {
            button.classList.add('active');
            button.classList.remove('btn-outline-secondary');
            button.classList.add('btn-secondary');
        } else {
             button.classList.remove('active', 'btn-secondary');
             button.classList.add('btn-outline-secondary');
        }
    });
</script>
@endpush