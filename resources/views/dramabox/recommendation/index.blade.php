@extends('layouts.app')

@section('content')
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Recommendation Management (CRUD)</h1>

    <a href="{{ route('recommendations.create') }}" class="btn btn-primary mb-4">+ Tambah Recommendation Baru</a>

    @if (session('success'))
      <div class="alert alert-success mb-4" role="alert">
        {{ session('success') }}
      </div>
    @endif

    <div class="card p-4">
      <h2 class="card-title mb-4">Daftar Recommendation</h2>

      <!-- Search Form -->
      <form action="{{ route('recommendations.search') }}" method="GET" class="mb-4">
        <div class="input-group">
          <input type="text" name="query" value="{{ request('query') }}" placeholder="Search by name..." class="form-control">
          <select name="category" class="form-select">
            @foreach ($categories as $cat)
              <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
          </select>
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
      </form>

      @if ($recommendations->isEmpty())
        <p class="text-center text-muted py-2">Belum ada recommendation yang diunggah.</p>
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
                <th>Jumlah Episode</th>
                <th>Poster</th>
                <th>Tautan Episode</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($recommendations as $recommendation)
                <tr class="table-hover">
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $recommendation->name }}</td>
                  <td>{{ Str::limit($recommendation->description, 50) }}</td>
                  <td>{{ implode(', ', $recommendation->category ?? []) }}</td>
                  <td>{{ $recommendation->rating }}</td>
                  <td>{{ count($recommendation->episodes ?? []) }}</td>
                  <td>
                    @if ($recommendation->poster_image)
                      <img src="{{ asset('storage/' . $recommendation->poster_image) }}" alt="{{ $recommendation->name }} Poster" style="width: 100px; height: auto; object-fit: cover;">
                    @else
                      <small class="text-muted">Tidak ada poster</small>
                    @endif
                  </td>
                  <td>
                    @forelse ($recommendation->episodes ?? [] as $index => $episodePath)
                      <a href="{{ asset('storage/' . $episodePath) }}" target="_blank" class="btn btn-outline-secondary btn-sm mb-1">
                        Episode {{ $index + 1 }}
                      </a><br>
                    @empty
                      <small class="text-muted">Tidak ada episode</small>
                    @endforelse
                  </td>
                  <td>
                    <a href="{{ route('recommendations.edit', $recommendation->id) }}" class="btn btn-warning btn-sm mb-1"><i class="bi bi-pencil me-1"></i>Edit</a>
                    <form action="{{ route('recommendations.destroy', $recommendation->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus recommendation ini?')"><i class="bi bi-trash me-1"></i>Hapus</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        {{ $recommendations->links() }}
      @endif
    </div>
  </div>
@endsection