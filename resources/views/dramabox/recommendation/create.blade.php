@extends('layouts.app')

@section('content')
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Create New Recommendation</h1>

    @if (session('success'))
      <div class="alert alert-success mb-4" role="alert">
        {{ session('success') }}
      </div>
    @endif

    <div class="card p-4">
      <h2 class="card-title mb-4">Form Tambah Recommendation</h2>
      <form action="{{ route('recommendations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Name --}}
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
          @error('name')
            <div class="text-danger text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
          @error('description')
            <div class="text-danger text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Rating --}}
        <div class="mb-3">
          <label for="rating" class="form-label">Rating (1-5)</label>
          <input type="number" name="rating" id="rating" value="{{ old('rating') }}" min="1" max="5" class="form-control" required>
          @error('rating')
            <div class="text-danger text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Category --}}
        <div class="mb-3">
          <label for="category" class="form-label">Categories</label>
          <select name="category[]" id="category" multiple class="form-select" required>
            @foreach ($categories as $cat)
              <option value="{{ $cat }}" {{ in_array($cat, old('category', [])) ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
          </select>
          @error('category')
            <div class="text-danger text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Poster Image --}}
        <div class="mb-3">
          <label for="poster_image" class="form-label">Poster Image</label>
          <input type="file" name="poster_image" id="poster_image" accept="image/*" class="form-control">
          @error('poster_image')
            <div class="text-danger text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Episodes (Dynamic) --}}
        <div class="mb-3">
          <label class="form-label">Upload Episodes (Video Files)</label>
          <div id="episodes-container">
            <div class="input-group mb-2">
              <input type="file" name="episodes[]" class="form-control" accept="video/*">
              <button type="button" class="btn btn-danger" onclick="this.closest('.input-group').remove()">Remove</button>
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
            <i class="bi bi-save me-1"></i>Save Recommendation
          </button>
          <a href="{{ route('recommendations.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </div>

      </form>
    </div>
  </div>

  {{-- JS Add Input --}}
  <script>
    function addEpisodeInput() {
      const container = document.getElementById('episodes-container');
      const div = document.createElement('div');
      div.classList.add('input-group', 'mb-2');
      div.innerHTML = `
        <input type="file" name="episodes[]" class="form-control" accept="video/*">
        <button type="button" class="btn btn-danger" onclick="this.closest('.input-group').remove()">Remove</button>
      `;
      container.appendChild(div);
    }
  </script>
@endsection
