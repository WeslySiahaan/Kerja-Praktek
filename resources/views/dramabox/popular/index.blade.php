@extends('layouts.app')

@section('content')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <h1 class="mb-4">Popular Items</h1>
    <a href="{{ route('populars.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle me-2"></i>Add New
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Poster</th>
                <th>Title</th>
                <th>Category</th>
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
                        @if (is_array($popular->category))
                            {{ implode(', ', $popular->category) }}
                        @else
                            {{ $popular->category ?: 'No categories' }}
                        @endif
                    </td>
                    <td>
                        <video width="200" controls>
                            <source src="{{ $popular->trailer_url }}" type="video/mp4">
                        </video>
                    </td>
                    <td>{{ Str::limit($popular->description, 50) }}</td>
                    <td>
                        <a href="{{ route('populars.edit', $popular->id) }}" class="btn btn-warning btn-sm mb-1">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form action="{{ route('populars.destroy', $popular->id) }}" method="POST" class="delete-form d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-name="{{ $popular->title }}">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No popular items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- SweetAlert2 Delete Confirmation -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('form');
                    const itemName = this.dataset.name;

                    Swal.fire({
                        title: `Hapus ${itemName}?`,
                        text: "Data yang dihapus tidak dapat dikembalikan",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
