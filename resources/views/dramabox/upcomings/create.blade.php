@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Upcoming Releases CRUD</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form -->
        <div class="card p-4">
            <h2 class="card-title mb-4">Add New Upcoming Release</h2>
            <form action="{{ route('upcomings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control" required>
                    @error('title')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description (Optional)</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="release_date" class="form-label">Release Date</label>
                    <input type="date" name="release_date" id="release_date" value="{{ old('release_date') }}" class="form-control" required>
                    @error('release_date')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category (Hold Ctrl to select multiple)</label>
                    <select name="category[]" id="category" class="form-select" multiple required>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ in_array($category, old('category', [])) ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    @error('category.*')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="poster" class="form-label">Upload Poster (Image, Optional)</label>
                    <input type="file" name="poster" id="poster" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif">
                    @error('poster')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="trailer" class="form-label">Upload Trailer (Video, Optional)</label>
                    <input type="file" name="trailer" id="trailer" class="form-control" accept="video/mp4,video/mov,video/avi">
                    @error('trailer')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Add Upcoming Release</button>
            </form>
        </div>
    </div>
@endsection