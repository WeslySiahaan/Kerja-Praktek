@extends('layouts.app1')

@section('category_navbar')
    @include('profile.partials.category_navbar')
@endsection

@section('content')
<div class="container mt-4">
<h2 class="mt-4 text-white">Browse Videos</h2>
    {{-- Optional: Tampilkan query pencarian atau kategori yang aktif --}}
    @if(isset($query) && $query)
        <h3 class="text-white">Hasil Pencarian untuk: "{{ $query }}"</h3>
    @endif
    @if(isset($category) && $category && $category !== 'all')
        <h3 class="text-white">Filter Kategori: "{{ $category }}"</h3>
    @elseif(isset($category) && $category === 'all')
        <h3 class="text-white">Menampilkan Semua Kategori</h3>
    @endif

    {{-- Mengubah judul menjadi "Browse Videos" --}}
    @if($videos->isEmpty())
        <p class="text-white">Tidak ada video ditemukan.</p>
    @else
        <div class="row">
            @foreach($videos as $video)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card bg-dark text-white h-100 d-flex flex-column"> {{-- Tambahkan d-flex flex-column di sini juga --}}
                        <img src="{{ asset('storage/' . $video->poster_image) }}" class="card-img-top" alt="{{ $video->name }}" style="object-fit: cover; height: 250px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $video->name }}</h5>
                            <p class="card-text text-white flex-grow-1"><small>Kategori: {{ is_array($video->category) ? implode(', ', $video->category) : $video->category }}</small></p>
                            <div class="mt-auto">
                                <a href="{{ route('dramabox.detail', $video->id) }}" class="btn btn-primary btn-sm">Menonton</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Bagian Tampilkan Upcomings 
    <h2 class="mt-4 text-white">Upcoming Shows</h2>
    @if($upcomings->isEmpty())
        <p class="text-white">Tidak ada acara mendatang ditemukan.</p>
    @else
        <div class="row">
            @foreach($upcomings as $upcoming)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card bg-dark text-white h-100 d-flex flex-column">
                        <img src="{{ asset('storage/' . $upcoming->poster) }}" class="card-img-top" alt="{{ $upcoming->title }}" style="object-fit: cover; height: 250px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $upcoming->title }}</h5>
                            <p class="card-text flex-grow-1"><small class="text-muted">Kategori: {{ is_array($upcoming->category) ? implode(', ', $upcoming->category) : $upcoming->category }}</small></p>
                            <p class="card-text"><small class="text-muted">Rilis: {{ $upcoming->release_date->format('d M Y') }}</small></p>
                            <div class="mt-auto">
                                {{-- Jika ada route untuk detail upcoming --}}
                                {{-- <a href="{{ route('dramabox.upcoming_detail', $upcoming->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a> 
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    --}}

   

    {{-- Bagian Tampilkan Populars 
    <h2 class="mt-4 text-white">Popular Shows</h2>
    @if($populars->isEmpty())
        <p class="text-white">Tidak ada acara populer ditemukan.</p>
    @else
        <div class="row">
            @foreach($populars as $popular)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card bg-dark text-white h-100 d-flex flex-column"> {{-- Tambahkan d-flex flex-column di sini juga
                        <img src="{{ asset('storage/' . $popular->poster) }}" class="card-img-top" alt="{{ $popular->title }}" style="object-fit: cover; height: 250px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $popular->title }}</h5>
                            <p class="card-text flex-grow-1"><small class="text-muted">Kategori: {{ is_array($popular->category) ? implode(', ', $popular->category) : $popular->category }}</small></p>
                            {{-- Placeholder untuk tinggi yang sama dengan "Rilis" di Upcoming 
                            <p class="card-text invisible"><small class="text-muted">Placeholder</small></p> 
                            <div class="mt-auto">
                                {{-- <a href="{{ route('dramabox.popular_detail', $popular->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
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
            window.location.href = `{{ route('dramabox.search1') }}?category=${category}`;
        });
    });
</script>
@endpush