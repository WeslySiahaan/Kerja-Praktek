@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Popular Items</h1>
    <a href="{{ route('populars.create') }}" class="btn btn-primary mb-3"><i class="bi bi-plus-circle me-2"></i>Add New</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Poster</th>
                <th>Title</th>
                <th>Categories</th>
                <th>Trailer</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($populars as $popular)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><img src="{{ $popular->poster_url }}" alt="{{ $popular->title }}" width="100"></td>
                    <td>{{ $popular->title }}</td>
                    <td>
                        @if (is_array($popular->categories))
                            {{ implode(', ', $popular->categories) }}
                        @else
                            {{ $popular->categories ?: 'No categories' }}
                        @endif
                    </td>
                    <td>
                        <video width="200" controls>
                            <source src="{{ $popular->trailer_url }}" type="video/mp4">
                        </video>
                    </td>
                    <td>{{ Str::limit($popular->description, 50) }}</td>
                    <td>
                        <a href="{{ route('populars.edit', $popular->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil me-1"></i>Edit</a>
                        <form action="{{ route('populars.destroy', $popular->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="bi bi-trash me-1"></i>Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No popular items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection