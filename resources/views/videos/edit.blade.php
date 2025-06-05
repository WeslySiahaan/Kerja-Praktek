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

          <!-- Video Name -->
          <div class="mb-3">
            <label class="form-label">Video Name</label>
            <input type="text" name="name" value="{{ old('name', $video->name) }}" class="form-control" required>
            @error('name')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <!-- Description -->
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $video->description) }}</textarea>
            @error('description')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <!-- Rating -->
          <div class="mb-3">
            <label class="form-label">Rating (1-5)</label>
            <input type="number" name="rating" value="{{ old('rating', $video->rating) }}" min="1" max="5" class="form-control" required>
            @error('rating')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <!-- Category -->
          <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select" required>
              @foreach($categories as $category)
                <option value="{{ $category }}" {{ old('category', $video->category) == $category ? 'selected' : '' }}>
                  {{ $category }}
                </option>
              @endforeach
            </select>
            @error('category')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <!-- Is Popular -->
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular" {{ old('is_popular', $video->is_popular) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_popular">Mark as Popular</label>
          </div>

          <!-- Upload Main Video -->
          <div class="mb-3">
            <label class="form-label">Upload Video</label>
            <input type="file" name="video_file" class="form-control" accept="video/*">
            @if($video->video_file)
              <div class="form-text">Current Video: {{ $video->video_file }}</div>
            @endif
            @error('video_file')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <!-- Upload Episodes -->
          <div class="mb-3">
            <label class="form-label">Upload Episodes</label>
            <div id="episodes-container">
              @php
                // Decode existing episodes JSON string to array
                $existingEpisodes = is_array($video->episodes)
                  ? $video->episodes
                  : (is_string($video->episodes) ? json_decode($video->episodes, true) : []);
              @endphp

              @foreach(old('episodes', $existingEpisodes) as $index => $episode)
                <div class="mb-2">
                  <input type="file" name="episodes[]" class="form-control" accept="video/*">
                  @if(isset($episode))
                    <div class="form-text">Current Episode: {{ $episode }}</div>
                  @endif
                </div>
              @endforeach

              @if(count($existingEpisodes) == 0)
                {{-- Jika belum ada episode, tampilkan satu input kosong --}}
                <div class="mb-2">
                  <input type="file" name="episodes[]" class="form-control" accept="video/*">
                </div>
              @endif
            </div>
            <button type="button" onclick="addEpisodeInput()" class="btn btn-outline-primary mt-2">Add Episode</button>
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
      const container = document.getElementById('episodes-container');
      const div = document.createElement('div');
      div.className = 'mb-2';
      div.innerHTML = '<input type="file" name="episodes[]" class="form-control" accept="video/*">';
      container.appendChild(div);
    }
  </script>
@endsection
