@extends('layouts.app1')

@section('category_navbar')
    @include('profile.partials.category_navbar')
@endsection

@section('content')
<div class="container mt-4">
   {{-- Optional: Tampilkan query pencarian atau kategori yang aktif --}}
@if(isset($query) && $query)
    <h4 class="text-warning fw-semibold mb-2" style="font-size: 1.25rem;">
        Hasil pencarian untuk: 
        <span class="text-white">"{{ $query }}"</span>
    </h4>
@endif

<section class="px-3 py-4">
    {{-- Nama kategori --}}
    @if(isset($category) && $category && $category !== 'all')
        <h5 class="text-warning fw-semibold mb-2">
            Kategori: <span class="text-light">"{{ $category }}"</span>
        </h5>
    @elseif(isset($category) && $category === 'all')
        <h5 class="text-warning fw-semibold mb-2">Menampilkan Semua Kategori</h5>
    @endif

    {{-- Judul utama --}}
    <h1 class="fw-bold text-white mb-2" style="font-size: 1.8rem;">
        Pilihan Video Sesuai Kategori
    </h1>

    {{-- Subjudul --}}
    <p class="text-secondary" style="font-size: 1rem;">
        Temukan berbagai video menarik yang sesuai dengan kategori favoritmu.
    </p>
</section>





        @if (session('error'))
            <div class="alert alert-danger px-3">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success px-3">{{ session('success') }}</div>
        @endif

        @if ($videos->isEmpty())
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
                                <p class="card-text text-white"><small>Kategori: {{ is_array($video->category) ? implode(', ', $video->category) : $video->category }}</small></p>
                                <p class="card-title text-truncate text-white"><small>Ep {{ count($video->episodes ?? []) }}</small></p>
                                
                                <div class="mt-auto d-flex gap-2">
                                    @if (Auth::check())
                                        <!-- Tombol Like -->
                                        <form action="{{ route('videos.like', $video) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 like-btn" title="{{ $video->likedByUsers->contains(Auth::id()) ? 'Batal Suka' : 'Suka' }}">
                                                <i class="bi {{ $video->likedByUsers->contains(Auth::id()) ? 'bi-heart-fill text-danger' : 'bi-heart text-white' }} fs-5"></i>
                                            </button>
                                        </form>

                                        <!-- Tombol Simpan -->
                                        <form action="{{ route('videos.save', $video) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0" title="{{ $video->collectedByUsers->contains(Auth::id()) ? 'Sudah Disimpan' : 'Simpan' }}"
                                                    {{ $video->collectedByUsers->contains(Auth::id()) ? 'disabled' : '' }}>
                                                <i class="bi {{ $video->collectedByUsers->contains(Auth::id()) ? 'bi-bookmark-fill text-success' : 'bi-bookmark text-white' }} fs-5"></i>
                                            </button>
                                        </form>

                                        <!-- Tombol Menonton -->
                                        <a href="{{ route('dramabox.detail', $video->id) }}" class="btn btn-primary btn-sm bi bi-play-fill">Menonton</a>
                                    @else
                                        <!-- Tombol Like dengan redirect ke login -->
                                        <a href="{{ route('login') }}" class="btn btn-link p-0" title="Login untuk Suka">
                                            <i class="bi bi-heart text-white fs-5"></i>
                                        </a>

                                        <!-- Tombol Simpan dengan redirect ke login -->
                                        <a href="{{ route('login') }}" class="btn btn-link p-0" title="Login untuk Simpan">
                                            <i class="bi bi-bookmark text-white fs-5"></i>
                                        </a>

                                        <!-- Tombol Menonton dengan redirect ke login -->
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm bi bi-play-fill" title="Login untuk Menonton">Menonton</a>
                                    @endif
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
            window.location.href = `{{ route('dramabox.search1') }}?category=${category}`;
        });
    });
</script>
@endpush