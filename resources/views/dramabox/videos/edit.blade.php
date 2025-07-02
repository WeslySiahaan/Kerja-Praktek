@extends('layouts.app')

@section('content')
  <div class="container py-4">
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <div class="card">
      <div class="card-header fs-4">Edit Video</div>

      <div class="card-body">
        <form action="{{ route('videos.update', $video) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label">Video Name</label>
            <input type="text" name="name" value="{{ old('name', $video->name) }}" class="form-control" required>
            @error('name')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $video->description) }}</textarea>
            @error('description')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Rating (1-5)</label>
            <input type="number" name="rating" value="{{ old('rating', $video->rating) }}" min="1" max="5" class="form-control" required>
            @error('rating')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Categories (Hold Ctrl to select multiple)</label>
            <select name="category[]" id="category" class="form-select" multiple size="5" required>
              <option value="">Select categories</option>
              @foreach($categories as $category)
                <option value="{{ $category }}" {{ in_array($category, old('category', $video->category ?? [])) ? 'selected' : '' }}>
                  {{ $category }}
                </option>
              @endforeach
            </select>
            @error('category')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular" {{ old('is_popular', $video->is_popular) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_popular">Mark as Popular</label>
          </div>

          <div class="mb-3">
            <label class="form-label">Upload New Poster Image (Optional)</label>
            <input type="file" name="poster_image" class="form-control" accept="image/*">
            @if($video->poster_image)
              <div class="mt-2">
                <p>Current Poster:</p>
                <img src="{{ asset('storage/' . $video->poster_image) }}" alt="Current Poster" style="max-width: 200px; height: auto;">
                <div class="form-text">Path: `{{ $video->poster_image }}`</div>
              </div>
            @else
              <div class="form-text">No poster image uploaded yet.</div>
            @endif
            @error('poster_image')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Upload New Episodes (Optional)</label>
            <div id="episodes-container">
              @if($video->episodes && count($video->episodes ?? []) > 0)
                <p class="mb-2">Existing Episodes:</p>
                @foreach($video->episodes ?? [] as $index => $episodePath)
                  <div class="input-group mb-2" id="episode-{{ $index }}">
                    <span class="input-group-text">Episode {{ $index + 1 }}</span>
                    <input type="text" class="form-control" value="{{ $episodePath }}" readonly>
                    <a href="{{ asset('storage/' . $episodePath) }}" target="_blank" class="btn btn-info"><i class="bi bi-eye"></i> View</a>
                    <input type="hidden" name="existing_episodes[]" value="{{ $episodePath }}"> {{-- Penting untuk mempertahankan episode lama --}}
                    <button type="button" class="btn btn-danger" onclick="removeEpisode('episode-{{ $index }}')"><i class="bi bi-x"></i> Remove</button>
                  </div>
                @endforeach
              @else
                <p class="mb-2 text-muted">No existing episodes.</p>
              @endif

              <p class="mb-2 mt-3">Add New Episode Files:</p>
              <div id="new-episodes-input-container">
                <div class="input-group mb-2">
                  <input type="file" name="episodes[]" class="form-control" accept="video/*">
                  <button type="button" class="btn btn-outline-secondary" onclick="addEpisodeInput()"><i class="bi bi-plus"></i> Add</button>
                </div>
              </div>
            </div>
            @error('episodes.*')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-success">Update Video</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function addEpisodeInput() {
      const container = document.getElementById('new-episodes-input-container');
      const div = document.createElement('div');
      div.className = 'input-group mb-2';
      div.innerHTML = `
        <input type="file" name="episodes[]" class="form-control" accept="video/*">
        <button type="button" class="btn btn-danger" onclick="this.closest('.input-group').remove()"><i class="bi bi-x"></i> Remove</button>
      `;
      container.appendChild(div);
    }

    // Fungsi untuk menghapus episode yang sudah ada (secara visual)
    function removeEpisode(elementId) {
        if (confirm('Are you sure you want to remove this episode? This will delete the file from storage upon saving changes.')) {
            document.getElementById(elementId).remove();
            // Penting: Input hidden untuk episode yang dihapus juga ikut terhapus dari DOM,
            // sehingga controller akan tahu bahwa episode ini tidak lagi dipertahankan.
        }
    }
  </script>
@endsection