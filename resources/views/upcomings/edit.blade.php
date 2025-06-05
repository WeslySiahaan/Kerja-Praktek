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
            <h2 class="card-title mb-4">Edit Upcoming Release</h2>
            <form action="{{ route('upcomings.update', $upcoming) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $upcoming->title) }}" class="form-control" required>
                    @error('title')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description', $upcoming->description) }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="release_date" class="form-label">Release Date</label>
                    <input type="date" name="release_date" id="release_date" value="{{ old('release_date', $upcoming->release_date->format('Y-m-d')) }}" class="form-control" required>
                    @error('release_date')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ old('category', $upcoming->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="poster" class="form-label">Upload Poster (Image)</label>
                    <input type="file" name="poster" id="poster" class="form-control" accept="image/*">
                    @if($upcoming->poster)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $upcoming->poster) }}" alt="Poster" width="100">
                            <p class="text-muted">Current Poster</p>
                        </div>
                    @endif
                    @error('poster')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="trailer" class="form-label">Upload Trailer (Image)</label>
                    <input type="file" name="trailer" id="trailer" class="form-control" accept="image/*">
                    @if($upcoming->trailer)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $upcoming->trailer) }}" alt="Trailer" width="100">
                            <p class="text-muted">Current Trailer</p>
                        </div>
                    @endif
                    @error('trailer')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Update Upcoming Release</button>
            </form>
        </div>
    </div>
@endsection