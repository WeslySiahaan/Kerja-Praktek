@extends('layouts.app')

@section('title', 'Add Popular Item')

@section('content')
    <h1>Add New Popular Item</h1>
    <form action="{{ route('populars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">category</label>
            <select name="category[]" id="category" class="form-select @error('category') is-invalid @enderror" multiple required>
                <option value="Action" {{ in_array('Action', old('category', [])) ? 'selected' : '' }}>Action</option>
                <option value="Drama" {{ in_array('Drama', old('category', [])) ? 'selected' : '' }}>Drama</option>
                <option value="Comedy" {{ in_array('Comedy', old('category', [])) ? 'selected' : '' }}>Comedy</option>
                <option value="Horror" {{ in_array('Horror', old('category', [])) ? 'selected' : '' }}>Horror</option>
                <option value="Sci-Fi" {{ in_array('Sci-Fi', old('category', [])) ? 'selected' : '' }}>Sci-Fi</option>
            </select>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="poster" class="form-label">Poster</label>
            <input type="file" name="poster" id="poster" class="form-control @error('poster') is-invalid @enderror" accept="image/*" required>
            @error('poster')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="trailer" class="form-label">Trailer</label>
            <input type="file" name="trailer" id="trailer" class="form-control @error('trailer') is-invalid @enderror" accept="video/mp4" required>
            @error('trailer')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Save</button>
        <a href="{{ route('populars.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-2"></i>Cancel</a>
    </form>
@endsection
