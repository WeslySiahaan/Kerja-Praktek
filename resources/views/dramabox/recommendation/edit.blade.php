@extends('layouts.app')

@section('content')
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Edit Recommendation</h1>

    @if (session('success'))
      <div class="alert alert-success mb-4" role="alert">
        {{ session('success') }}
      </div>
    @endif

    <div class="card p-4">
      <h2 class="card-title mb-4">Form Edit Recommendation</h2>
      <form action="{{ route('recommendations.update', $recommendation) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" name="name" id="name" value="{{ old('name', $recommendation->name) }}" class="form-control" required>
          @error('name')
            <div class="text-danger text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea name="description" id="description" class="form-control" required>{{ old('description', $recommendation->description) }}</textarea>
          @error('description')
            <div class="text-danger text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Rating --}}
        <div class="mb-3">
          <label for="rating" class="form-label">Rating (1-5)</label>
          <input type="number" name="rating" id="rating" value="{{ old('rating', $recommendation->rating) }}" min="1" max="5" class="form-control" required>
          @error('rating')
            <div class="text-danger text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Categories --}}
        <div class="mb-3">
          <label for="category" class="form-label">Categories</label>
          <select name="category[]" id="category" multiple class="form-select" required>
            @foreach ($categories as $cat)
              <option value="{{ $cat }}" {{ in_array($cat, old('category', $recommendation->category ?? [])) ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
          </select>
          @error('category')
            <div class="text-danger text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Poster Image --}}
        <div class="mb-3">
          <label for="poster_image" class="form-label">Poster Image</label>
          @if ($recommendation->poster_image)
            <div class="mb-2">
              <img src="{{ asset('storage/' . $recommendation->poster_image) }}" alt="{{ $recommendation->name }} Poster" style="width: 120px; height: auto; object-fit: cover;">
            </div>
          @endif
          <input type="file" name="poster_image" id="poster_image" accept="image/*" class="form-control">
          @error('poster_image')
            <div class="text-danger text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Existing Episodes --}}
        <div class="mb-3">
          <label class="form-label">Episodes</label>
          @if ($recommendation->episodes)
            <div class="mb-2">
              <p class="text-sm fw-medium">Existing Episodes:</p>
              @foreach ($recommendation->episodes as $index => $episode)
                <div class="d-flex align-items-center mb-2">
                  <input type="hidden" name="existing_episodes[]" value="{{ $episode }}">
                  <a href="{{ asset('storage/' . $episode) }}" target="_blank" class="btn btn-outline-secondary btn-sm me-2">Episode {{ $index + 1 }}</a>
                  <button type="button" onclick="removeEpisode(this)" class="btn btn-danger btn-sm">Remove</button>
                </div>
              @endforeach
            </div>
          @endif

          {{-- New Episodes Upload (Dynamic) --}}
          <div id="episodes-container">
            <div class="mb-2">
              <input type="file" name="episodes[]" class="form-control" accept="video/*">
            </div>
          </div>
          <button type="button" onclick="addEpisodeInput()" class="btn btn-secondary mt-2">
            <i class="bi bi-plus-circle me-1"></i> Add Another Episode
          </button>
          @error('episodes.*')
            <div class="text-danger text-sm mt-1">{{ $message }}</div>
          @enderror
        </div>

        {{-- Submit --}}
        <div class="mt-4">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i>Update Recommendation
          </button>
          <a href="{{ route('recommendations.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </div>
      </form>
    </div>
  </div>

  {{-- Script for dynamic episode input and remove --}}
  <script>
    function addEpisodeInput() {
      const container = document.getElementById('episodes-container');
      const div = document.createElement('div');
      div.classList.add('mb-2');
      div.innerHTML = '<input type="file" name="episodes[]" class="form-control" accept="video/*">';
      container.appendChild(div);
    }

    function removeEpisode(button) {
      const parent = button.closest('.d-flex');
      parent.remove();
    }
  </script>
@endsection
