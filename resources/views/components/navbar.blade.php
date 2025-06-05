<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    @auth
      @if(Auth::user()->role === 'admin')
        <a class="navbar-brand fw-bold text-white" href="{{ route('admin.dashboard') }}">
          <img src="{{ asset('logo_Moratek-.png') }}" alt="Logo" width="90" height="67" class="d-inline-block align-text-top me-2">
        </a>
      @else
        <a class="navbar-brand fw-bold text-white" href="{{ route('users.dashboard') }}">
          <img src="{{ asset('logo_Moratek-.png') }}" alt="Logo" width="90" height="67" class="d-inline-block align-text-top me-2">
        </a>
      @endif
    @else
      <a class="navbar-brand fw-bold text-white" href="#">
        <img src="{{ asset('logo_Moratek-.png') }}" alt="Logo" width="90" height="67" class="d-inline-block align-text-top me-2">
      </a>
    @endauth

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Bagian kiri nav -->
      <ul class="navbar-nav me-auto align-items-center">
        <!-- Kalau mau tambahkan menu kiri di sini -->
      </ul>

      <!-- Bagian kanan nav -->
      <ul class="navbar-nav align-items-center">
        @auth
          <li class="nav-item me-3">
            <span class="nav-link text-white">Halo, {{ Auth::user()->name }}</span>
          </li>

          <li class="nav-item">
            <a href="#" class="btn btn-danger" onclick="event.preventDefault(); confirmLogout();">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        @else
          <li class="nav-item me-2">
            <a href="{{ route('login') }}" class="btn btn-outline-light">
              <i class="fas fa-sign-in-alt"></i> Login
            </a>
          </li>
          @if(Route::has('register'))
            <li class="nav-item">
              <a href="{{ route('register') }}" class="btn btn-light">
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
