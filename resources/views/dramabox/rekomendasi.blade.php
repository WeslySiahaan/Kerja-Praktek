@extends('layouts.app1')

@section('content')
<section class="container-fluid" style="margin-top: 5px; position: relative; z-index: 10; margin-bottom: 20px;">
  <h2 class="display-6 fw-bold mb-4 px-3">Recommended For You</h2>

  @if (session('error'))
    <div class="alert alert-danger px-3">{{ session('error') }}</div>
  @endif
  @if (session('success'))
    <div class="alert alert-success px-3">{{ session('success') }}</div>
  @endif

  @if ($recommendedVideos->isEmpty())
    <p class="text-center text-muted py-4 px-3">No recommendations available at the moment.</p>
  @else
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3 px-3">
      @foreach ($recommendedVideos as $video)
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
              <p class="card-title text-truncate">Total {{ count($video->episodes ?? []) }} Episode</p>
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
  @endif
</section>
@endsection
