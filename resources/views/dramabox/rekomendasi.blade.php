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
            <a href="{{ route('recommendations.detail', ['id' => $video->id]) }}" class="text-decoration-none text-white">
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
                            
                                      <!-- Tombol Menonton -->
                                        <a href="{{ route('recommendations.detail', $video->id) }}" class="btn btn-warning btn-sm bi bi-play-fill">Menonton</a>
                                    @else

                                        <!-- Tombol Menonton dengan redirect ke login -->
                                        <a href="{{ route('login') }}" class="btn btn-warning btn-sm bi bi-play-fill" title="Login untuk Menonton">Menonton</a>
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
