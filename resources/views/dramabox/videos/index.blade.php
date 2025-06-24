@extends('layouts.app')

@section('content')
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Video Management (CRUD)</h1>

    <a href="{{ route('videos.create') }}" class="btn btn-primary mb-4">+ Tambah Video Baru</a>

    @if (session('success'))
      <div class="alert alert-success mb-4" role="alert">
        {{ session('success') }}
      </div>
    @endif

    <div class="card p-4">
      <h2 class="card-title mb-4">Daftar Video</h2>

      @if ($videos->isEmpty())
        <p class="text-center text-muted py-2">Belum ada video yang diunggah.</p>
      @else
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Rating</th>
                <th>Populer</th>
                <th>Jumlah Episode</th>
                <th>Jumlah Like</th>
                <th>Jumlah Simpan</th>
                <th>Poster</th>
                <th>Tautan Episode</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($videos as $video)
                <tr class="table-hover">
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $video->name }}</td>
                  <td>{{ Str::limit($video->description, 50) }}</td>
                  <td>{{ $video->category }}</td>
                  <td>{{ $video->rating }}</td>
                  <td>{{ $video->is_popular ? 'Ya' : 'Tidak' }}</td>
                  <td>{{ count($video->episodes ?? []) }}</td>
                  <td>{{ $video->liked_by_users_count }}</td> <!-- Menggunakan withCount -->
                  <td>{{ $video->collected_by_users_count }}</td> <!-- Menggunakan withCount -->
                  <td>
                    @if ($video->poster_image)
                      <img src="{{ asset('storage/' . $video->poster_image) }}" alt="{{ $video->name }} Poster" style="width: 100px; height: auto; object-fit: cover;">
                    @else
                      <small class="text-muted">Tidak ada poster</small>
                    @endif
                  </td>
                  <td>
                    @forelse ($video->episodes ?? [] as $index => $episodePath)
                      <a href="{{ asset('storage/' . $episodePath) }}" target="_blank" class="btn btn-outline-secondary btn-sm mb-1">
                        Episode {{ $index + 1 }}
                      </a><br>
                    @empty
                      <small class="text-muted">Tidak ada episode</small>
                    @endforelse
                  </td>
                  <td>
                    <a href="{{ route('videos.edit', $video->id) }}" class="btn btn-warning btn-sm mb-1"><i class="bi bi-pencil me-1"></i>Edit</a>
                    <form action="{{ route('videos.destroy', $video->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus video ini?')"><i class="bi bi-trash me-1"></i>Hapus</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        {{ $videos->links() }} <!-- Tambahkan ini untuk paginasi -->
      @endif
    </div>
  </div>
@endsection