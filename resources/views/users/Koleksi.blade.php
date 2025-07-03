@extends('layouts.app2')

@section('styles')
<style>
    /* Efek menonjol untuk kartu */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        border: 1px solid transparent;
        border-radius: 12px;
        overflow: hidden;
        background: #2c2c2c;
    }

    .card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2), 0 0 10px rgba(0, 123, 255, 0.5);
        border: 1px solid #007bff;
    }

    /* Efek zoom pada gambar poster saat hover */
    .card-img-top {
        transition: transform 0.3s ease;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    /* Gaya tombol */
    .btn-primary, .btn-secondary, .btn-danger {
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-primary:hover, .btn-secondary:hover, .btn-danger:hover {
        transform: scale(1.1);
    }

    /* Responsivitas */
    @media (max-width: 768px) {
        .card {
            margin-bottom: 15px;
        }
        .card-img-top {
            height: 200px !important;
        }
        .card-title {
            font-size: 1rem;
        }
        .card-text {
            font-size: 0.85rem;
        }
        .btn-sm {
            font-size: 0.8rem;
            padding: 6px 12px;
        }
    }

    @media (max-width: 576px) {
        .card-title {
            font-size: 0.9rem;
        }
        .card-text {
            font-size: 0.8rem;
        }
        .btn-sm {
            font-size: 0.75rem;
            padding: 5px 10px;
        }
    }
</style>
@endsection

@section('content')
<section class="container-fluid" style="margin-top: 20px; position: relative; z-index: 10; margin-bottom: 20px;">
  <div class="d-flex justify-content-between align-items-center mb-4 px-3">
    <h5 class="display-6 fw-bold m-0 text-white">Daftar Koleksi</h5>
    @auth
    <div class="edit-buttons d-flex gap-2">
      @if (request()->has('edit') && request()->get('edit') === 'true')
      <a href="{{ route('users.koleksi') }}" class="btn btn-secondary fw-semibold px-3 py-1 d-flex align-items-center gap-2">
        <i class="bi bi-x-lg"></i> Batal
      </a>
      @else
      <a href="{{ route('users.koleksi') }}?edit=true" class="btn btn-secondary fw-semibold px-3 py-1 d-flex align-items-center gap-2">
        <i class="bi bi-pencil"></i> Edit
      </a>
      @endif
    </div>
    @endauth
  </div>

  {{-- =================== Videos =================== --}}
  <h4 class="text-white px-3 mt-4">Koleksi Video</h4>
  @if ($videos->isEmpty())
  <p class="text-center text-muted py-4 px-3">Belum ada video dalam koleksi Anda.</p>
  @else
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 px-3">
    @foreach ($videos as $video)
    <div class="col">
      <div class="card bg-dark text-white h-100 d-flex flex-column movie-card" data-video-id="{{ $video->id }}">
        @auth
        @if (request()->has('edit') && request()->get('edit') === 'true')
        <form action="{{ route('collections.destroy_multiple') }}" method="POST" style="display: inline;">
          @csrf
          @method('DELETE')
          <input type="hidden" name="video_ids[]" value="{{ $video->id }}">
          <button type="submit" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
            onclick="return confirm('Apakah Anda yakin ingin menghapus {{ $video->name }} dari koleksi Anda?');">
            <i class="bi bi-trash"></i>
          </button>
        </form>
        @endif
        @endauth
        <a href="{{ route('video.detail', $video) }}" class="text-decoration-none text-white">
          <img src="{{ $video->poster_image ? asset('storage/' . $video->poster_image) : asset('Drama__box.png') }}"
            class="card-img-top movie-poster" alt="{{ $video->name }} poster"
            style="height: 300px; object-fit: cover;">
        </a>
        <div class="card-body d-flex flex-column movie-info">
          <h5 class="card-title text-truncate">{{ $video->name }}</h5>
          <p class="card-text text-white"><small>Kategori: {{ is_array($video->category) ? implode(', ', $video->category) : $video->category }}</small></p>
          <p class="card-title text-truncate text-white"><small>Total {{ count($video->episodes ?? []) }} episode</small></p>
          <div class="mt-auto">
            <a href="{{ route('video.detail', $video) }}" class="btn btn-primary btn-sm bi bi-play-fill">Menonton</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @if ($videos->hasPages())
  <div class="d-flex justify-content-center mt-4">
    {{ $videos->links() }}
  </div>
  @endif
  @endif

  {{-- =================== Recommendations =================== --}}
  <h4 class="text-white px-3 mt-5">Koleksi Rekomendasi</h4>
  @if ($recommendations->isEmpty())
  <p class="text-center text-muted py-4 px-3">Belum ada rekomendasi dalam koleksi Anda.</p>
  @else
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 px-3">
    @foreach ($recommendations as $recommendation)
    <div class="col">
      <div class="card bg-dark text-white h-100 d-flex flex-column">
        <a href="{{ route('recommendations.detail', ['id' => $recommendation->id]) }}" class="text-decoration-none text-white">
          <img src="{{ $recommendation->poster_image ? asset('storage/' . $recommendation->poster_image) : asset('Drama__box.png') }}"
            class="card-img-top" alt="{{ $recommendation->name }} poster" style="height: 300px; object-fit: cover;">
        </a>
        <div class="card-body d-flex flex-column">
          <h5 class="card-title text-truncate">{{ $recommendation->name }}</h5>
          <p class="card-text text-white"><small>Kategori: {{ is_array($recommendation->category) ? implode(', ', $recommendation->category) : $recommendation->category }}</small></p>
          <div class="mt-auto">
            <a href="{{ route('recommendations.detail', ['id' => $recommendation->id]) }}" class="btn btn-primary btn-sm bi bi-play-fill">Menonton</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @if ($recommendations->hasPages())
  <div class="d-flex justify-content-center mt-4">
    {{ $recommendations->links() }}
  </div>
  @endif
  @endif
</section>
@endsection