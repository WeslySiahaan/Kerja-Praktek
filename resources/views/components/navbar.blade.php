{{-- 
  File ini berisi kode navbar yang sudah diperbaiki.
  Struktur @auth, @else, dan @endif sudah dirapikan untuk menghilangkan syntax error.
--}}

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    {{-- Bagian Logo Navbar (Logika Admin/User Anda tetap utuh) --}}
    @auth
      @if(Auth::user()->role === 'admin')
      @else
        <a class="navbar-brand fw-bold text-white" href="{{ route('users.dashboard') }}">
          
        </a>
      @endif
    @else
      <a class="navbar-brand fw-bold text-white" href="/">
        <img src="{{ asset('LogoFix.png') }}" alt="Logo" width="90" height="67" class="d-inline-block align-text-top me-2">
      </a>
    @endauth

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      {{-- Bagian kiri nav (kosong, sesuai kode Anda) --}}
      <ul class="navbar-nav me-auto">
      </ul>

      <!-- Bagian kanan nav -->
      <ul class="navbar-nav align-items-center">
        @auth
          {{-- TAMPILAN JIKA PENGGUNA (ADMIN ATAU USER) SUDAH LOGIN --}}
          
          {{-- 1. Tampilkan nama --}}
          <li class="nav-item me-3">
            <span class="nav-link text-white">Halo, {{ Auth::user()->name }}</span>
          </li>
          
          {{-- 2. Tampilkan foto profil --}}
          <li class="nav-item">
            @if (Route::has('profile.edit'))
              <a href="{{ route('profile.edit') }}" class="nav-link text-white d-flex align-items-center">
                <img 
                  src="{{ auth()->user()->profile_photo_path ? route('profile.image', ['filename' => basename(auth()->user()->profile_photo_path)]) : asset('user.png') }}" 
                  alt="Foto Profil" 
                  class="rounded-circle" 
                  style="width: 32px; height: 32px; object-fit: cover;">
              </a>
            @endif
          </li>
          
          {{-- 3. Tampilkan tombol logout --}}
          <li class="nav-item ms-3">
            <a href="#" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirmLogout();">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>

        @else
          {{-- TAMPILAN JIKA PENGGUNA BELUM LOGIN (GUEST) --}}

          {{-- 1. Tombol Login --}}
          <li class="nav-item me-2">
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
              <i class="fas fa-sign-in-alt"></i> Login
            </a>
          </li>
          
          {{-- 2. Tombol Register --}}
          @if(Route::has('register'))
            <li class="nav-item">
              <a href="{{ route('register') }}" class="btn btn-light btn-sm">
                <i class="fas fa-user-plus"></i> Register
              </a>
            </li>
          @endif
        @endauth
      </ul>
    </div>
  </div>
</nav>

<!-- SweetAlert2 Confirm Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmLogout() {
    Swal.fire({
      title: 'Yakin ingin logout?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Logout',
      cancelButtonText: 'Batal',
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('logout-form').submit();
      }
    });
  }
</script>
