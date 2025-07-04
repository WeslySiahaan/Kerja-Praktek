@extends('layouts.app')

@section('content')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                                    <td>{{ is_array($upcoming->category) ? implode(', ', $upcoming->category) : $upcoming->category }}</td>
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
                                        <a href="{{ route('upcomings.edit', $upcoming->id) }}" class="btn btn-warning btn-sm mb-1">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </a>
                                        <form action="{{ route('upcomings.destroy', $upcoming->id) }}" method="POST" class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-name="{{ $upcoming->title }}">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
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

    <!-- SweetAlert2 Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('form');
                    const title = this.dataset.name;

                    Swal.fire({
                        title: `Hapus ${title}?`,
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
