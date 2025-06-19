@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Koleksi Video Saya</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($videos->isEmpty())
        <p>Belum ada video di koleksi Anda.</p>
    @else
        <div class="row">
            @foreach ($videos as $video)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if ($video->poster_image)
                            <img src="{{ asset('storage/' . $video->poster_image) }}" class="card-img-top" alt="{{ $video->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $video->name }}</h5>
                            <p class="card-text">{{ Str::limit($video->description, 100) }}</p>
                            <a href="{{ route('videos.detail', $video->id) }}" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection