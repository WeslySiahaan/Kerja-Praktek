@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">

        @if (session('success'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

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
                    <label for="category" class="form-label">Select Categories (Hold Ctrl to select multiple)</label>
                    <select name="category[]" id="category" class="form-select" multiple size="5">
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ in_array($category, old('category', [])) ? 'selected' : '' }}>{{ $category }}</option>
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
                    <label for="poster_image" class="form-label">Upload Poster Image</label>
                    <input type="file" name="poster_image" id="poster_image" class="form-control" accept="image/*">
                    @error('poster_image')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Episodes (Video Files)</label>
                    <div id="episodes-container">
                        @if(old('episodes'))
                            @foreach(old('episodes') as $index => $episode)
                                <div class="mb-2">
                                    <input type="file" name="episodes[]" class="form-control" accept="video/*">
                                </div>
                            @endforeach
                        @else
                            <div class="mb-2">
                                <input type="file" name="episodes[]" class="form-control" accept="video/*">
                            </div>
                        @endif
                    </div>
                    <button type="button" onclick="addEpisodeInput()" class="btn btn-secondary mt-2">Add Another Episode</button>
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
            input.innerHTML = `
                <div class="input-group">
                    <input type="file" name="episodes[]" class="form-control" accept="video/*">
                    <button type="button" class="btn btn-danger" onclick="this.closest('.input-group').remove()">Remove</button>
                </div>
            `;
            container.appendChild(input);
        }
    </script>
@endsection