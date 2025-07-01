<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ asset('LogoFix.png') }}">
  <title>CineMora</title>

  <!-- Bootstrap & Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Summernote -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

  <!-- Custom & Trix -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.umd.min.js"></script>

  @stack('styles')
  @yield('styles')
</head>

<body class="bg-light">
  <div class="app-wrapper min-vh-100 d-flex flex-column">
    <div class="d-flex flex-grow-1">
      {{-- Sidebar --}}
      @auth
      @if (auth()->user()->role === 'admin')
      @include('sidebar.sidebarAdmin')
      @elseif (auth()->user()->role === 'users')
      @include('sidebar.sidebarUsers')
      @else
      <div class="w-100 text-center text-danger p-3">Role tidak dikenali.</div>
      @endif
      @else
      <div class="w-100 text-center text-danger p-3">Anda belum login.</div>
      @endauth

      {{-- Main content --}}
      <main class="flex-grow-1">
        <x-navbar />
        <div class="content p-4">
          @yield('content')
        </div>
      </main>
    </div>

    {{-- Footer --}}
    <footer class="text-center py-3 bg-dark text-white border-top">
      <p class="mb-0">© {{ date('Y') }} Kuli Magang</p>
    </footer>
  </div>

  {{-- JS Libraries --}}
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- Tambahan script dari halaman --}}
  @stack('scripts')
  @yield('scripts')
</body>

</html>