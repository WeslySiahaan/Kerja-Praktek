@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Upcoming Releases CRUD</h1>
        <a href="{{ route('upcomings.create') }}" class="btn btn-primary mb-4">+ Tambah Upcoming</a>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Upcoming List -->
        <div class="card p-4">
            <h2 class="card-title mb-4">Upcoming List</h2>
            @if($upcomings->isEmpty())
                <p class="text-center text-muted py-2">No upcoming releases added yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Release Date</th>
                                <th>Category</th>
                                <th>Poster</th>
                                <th>Trailer</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomings as $upcoming)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $upcoming->title }}</td>
                                    <td>{{ $upcoming->release_date->format('d M Y') }}</td>
                                    <td>{{ implode(', ', $upcoming->category) }}</td> <!-- Perbaikan di sini -->
                                    <td>
                                        @if($upcoming->poster)
                                            <img src="{{ asset('storage/' . $upcoming->poster) }}" alt="Poster" width="100">
                                        @else
                                            No Poster
                                        @endif
                                    </td>
                                    <td>
                                        @if($upcoming->trailer)
                                            <a href="{{ asset('storage/' . $upcoming->trailer) }}" target="_blank">View Trailer</a>
                                        @else
                                            No Trailer
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('upcomings.edit', $upcoming->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil me-1"></i>Edit</a>
                                        <form action="{{ route('upcomings.destroy', $upcoming->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="bi bi-trash me-1"></i>Delete</button>
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