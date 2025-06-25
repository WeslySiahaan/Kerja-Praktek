@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="fs-3 fw-bold text-dark mb-3">
            <i class="bi bi-bar-chart-fill me-2"></i> Dashboard Admin
        </h1>
        <p class="text-muted">Selamat datang di halaman statistik video.</p>

        <div class="row mt-4 mb-4">
            <div class="col-md-4 mb-3">
                <div class="card bg-primary text-white shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">
                            <i class="bi bi-people-fill me-2"></i> Jumlah User
                        </h5>
                        <p class="card-text fs-1 fw-bold">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card bg-success text-white shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">
                            <i class="bi bi-play-btn-fill me-2"></i> Total Video
                        </h5>
                        <p class="card-text fs-1 fw-bold">{{ $totalVideos }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card bg-warning text-white shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">
                            <i class="bi bi-hourglass-split me-2"></i> Video Mendatang
                        </h5>
                        <p class="card-text fs-1 fw-bold">{{ $totalUpcoming }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        Statistik Video Terpopuler
                    </div>
                    <div class="card-body">
                        <canvas id="videoChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('videoChart').getContext('2d');
        const videoChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($videoLabels),
                datasets: [
                    {
                        label: 'Likes',
                        data: @json($likeData),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)', // Biru
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Simpan',
                        data: @json($collectionData),
                        backgroundColor: 'rgba(75, 192, 192, 0.7)', // Teal
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Penting untuk mengontrol tinggi grafik
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Statistik Like dan Simpan Video Terpopuler'
                    }
                }
            }
        });
    </script>
@endsection