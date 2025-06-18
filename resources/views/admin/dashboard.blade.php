@extends('layouts.app')

@section('content')
  <div class="container">
    <h1 class="text-3xl fw-bold text-dark mb-3">📊 Dashboard Admin</h1>
    <p class="text-muted">Selamat datang di halaman statistik video.</p>

    <div class="row mt-4">
      <div class="col-md-12">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            Statistik Video Terpopuler
          </div>
          <div class="card-body">
            <canvas id="videoChart" height="100"></canvas>
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
        labels: ['Video A', 'Video B', 'Video C', 'Video D', 'Video E'],
        datasets: [
          {
            label: 'Likes',
            data: [120, 90, 150, 80, 60],
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          },
          {
            label: 'Views',
            data: [1000, 850, 1200, 780, 620],
            backgroundColor: 'rgba(255, 206, 86, 0.7)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 100
            }
          }
        }
      }
    });
  </script>
@endsection
