@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form -->
        <div class="card p-4">
            <h4 class="card-title mb-4">Add New Video</h4>
            <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Video Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                    @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating (1-5)</label>
                    <input type="number" name="rating" id="rating" value="{{ old('rating') }}" min="1" max="5" class="form-control" required>
                    @error('rating')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select">
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_popular" id="is_popular" {{ old('is_popular') ? 'checked' : '' }} class="form-check-input">
                    <label for="is_popular" class="form-check-label">Mark as Popular</label>
                </div>
                <div class="mb-3">
                    <label for="video_file" class="form-label">Upload Video</label>
                    <input type="file" name="video_file" id="video_file" class="form-control" accept="video/*" required>
                    @error('video_file')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload Episodes</label>
                    <div id="episodes-container">
                        @foreach(old('episodes', []) as $episode)
                            <div class="mb-2">
                                <input type="file" name="episodes[]" class="form-control" accept="video/*">
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addEpisodeInput()" class="btn btn-primary mt-2">Add Episode</button>
                </div>
                <button type="submit" class="btn btn-success">
                    Add Video
                </button>
            </form>
        </div>
    </div>

    <script>
        function addEpisodeInput() {
            const container = document.getElementById('episodes-container');
            const input = document.createElement('div');
            input.className = 'mb-2';
            input.innerHTML = '<input type="file" name="episodes[]" class="form-control" accept="video/*">';
            container.appendChild(input);
        }
    </script>
@endsection