@extends('layouts.app')


@section('content')
    <h1>Edit Popular Item</h1>
    <form action="{{ route('populars.update', $popular->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $popular->title) }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="categories" class="form-label">Categories</label>
            <select name="categories[]" id="categories" class="form-select @error('categories') is-invalid @enderror" multiple required>
                @foreach (['Action', 'Drama', 'Comedy', 'Horror', 'Sci-Fi'] as $category)
                    <option value="{{ $category }}"
                        {{ in_array($category, old('categories', is_array($popular->categories) ? $popular->categories : json_decode($popular->categories, true) ?? [])) ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
            @error('categories')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="poster" class="form-label">Poster</label>
            <input type="file" name="poster" id="poster" class="form-control @error('poster') is-invalid @enderror" accept="image/*">
            <small>Current: <img src="{{ $popular->poster_url }}" alt="Poster" width="50"></small>
            @error('poster')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="trailer" class="form-label">Trailer</label>
            <input type="file" name="trailer" id="trailer" class="form-control @error('trailer') is-invalid @enderror" accept="video/mp4">
            <small>Current: <video width="100" controls><source src="{{ $popular->trailer_url }}" type="video/mp4"></video></small>
            @error('trailer')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $popular->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Update</button>
        <a href="{{ route('populars.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-2"></i>Cancel</a>
    </form>
@endsection