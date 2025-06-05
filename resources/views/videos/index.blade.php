@extends('layouts.app')

@section('content')
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Video Upload CRUD</h1>

    <a href="{{ route('videos.create') }}" class="btn btn-primary mb-4">+ Tambah Video</a>

    @if (session('success'))
      <div class="alert alert-success mb-4" role="alert">
        {{ session('success') }}
      </div>
    @endif

    <div class="card p-4">
      <h2 class="card-title mb-4">Video List</h2>

      @if ($videos->isEmpty())
        <p class="text-center text-muted py-2">No videos uploaded yet.</p>
      @else
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Rating</th>
                <th>Popular</th>
                <th>Episodes</th>
                <th>Preview</th>
                <th>Episode Links</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($videos as $video)
                @php
                  $episodes = $video->episodes ? json_decode($video->episodes, true) : [];
                @endphp

                <tr class="table-hover">
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $video->name }}</td>
                  <td>{{ $video->description }}</td>
                  <td>{{ $video->category }}</td>
                  <td>{{ $video->rating }}</td>
                  <td>{{ $video->is_popular ? 'Yes' : 'No' }}</td>
                  <td>{{ count($episodes) }}</td>

                  <td>
                    @if ($video->video_file)
                      <video width="160" height="90" controls>
                        <source src="{{ asset('videos/' . $video->video_file) }}" type="video/mp4">
                        Your browser does not support the video tag.
                      </video>
                    @else
                      <small class="text-muted">No video</small>
                    @endif
                  </td>

                  <td>
                    @forelse ($episodes as $index => $episodePath)
                      <a href="{{ asset('episodes/' . $episodePath) }}" target="_blank" class="btn btn-outline-secondary btn-sm mb-1">
                        Episode {{ $index + 1 }}
                      </a><br>
                    @empty
                      <small class="text-muted">No episodes</small>
                    @endforelse
                  </td>

                  <td>
                    <a href="{{ route('videos.edit', $video) }}" class="btn btn-warning btn-sm mb-1">Edit</a>
                    <form action="{{ route('videos.destroy', $video) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
@endsection