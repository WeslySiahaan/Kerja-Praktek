<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .sidebar {
            width: 300px;
            min-height: 100vh;
            background-color: #212529;
            color: white;
            position: sticky;
            top: 0;
            transition: width 0.3s;
        }

        .sidebar-header {
            border-bottom: 1px solid #444;
        }

        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            background-color: #343a40;
            border-radius: 4px;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .toggle-icon-profile,
        .toggle-icon-settings {
          transition: transform 0.3s;
        }

        /* Rotate icon profile saat expanded */
        a[aria-expanded="true"] .toggle-icon-profile {
          transform: rotate(90deg);
        }

        /* Rotate icon settings saat expanded */
        a[aria-expanded="true"] .toggle-icon-settings {
          transform: rotate(90deg);
        }



        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <div class="sidebar-header p-3 border-bottom border-secondary d-flex align-items-center justify-content-center">
                <a class="navbar-brand fw-bold text-white" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('LogoFix.png') }}" alt="Logo" width="100" height="67" class="d-inline-block align-text-top me-2">
                </a>
            </div>
            <ul class="nav flex-column p-3">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-house-door-fill me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('videos.index') }}" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-camera-video-fill me-2"></i> Video
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('upcomings.index') }}" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-clock-fill me-2"></i> Akan Tayang
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('recommendations.index') }}" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-clock-fill me-2"></i> Akan Tayang
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('populars.index') }}" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-fire me-2"></i> Popular
                    </a>
                </li>
                <li class="nav-item mb-2">
                <a href="#profileCollapse"
                  class="nav-link text-white d-flex align-items-center justify-content-between collapsed"
                  data-bs-toggle="collapse"
                  role="button"
                  aria-expanded="false"
                  aria-controls="profileCollapse">
                  <div>
                    <i class="bi bi-person-fill me-2"></i> Profile
                  </div>
                  <i class="bi bi-chevron-right toggle-icon-profile"></i>
                </a>

                <div class="collapse" id="profileCollapse">
                  <ul class="nav flex-column ms-3">
                    <li class="nav-item mb-2">
                      <a href="{{ route('profile.pertanyaanUmum') }}" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-question-circle me-2"></i> Pertanyaan Umum
                      </a>
                    </li>
                    <li class="nav-item mb-2">
                      <a href="{{ route('profile.layananPelanggan') }}" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-headset me-2"></i> Layanan Pelanggan
                      </a>
                    </li>
                    <li class="nav-item mb-2">
                      <a href="{{ route('profile.pengaturan') }}" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-gear me-2"></i> Pengaturan
                      </a>
                    </li>
                  </ul>
                </div>
                </li>

                <li class="nav-item mb-2">
                <a href="#settingsCollapse"
                    class="nav-link text-white d-flex align-items-center justify-content-between collapsed"
                    data-bs-toggle="collapse"
                    role="button"
                    aria-expanded="false"
                    aria-controls="settingsCollapse">
                    <div>
                    <i class="bi bi-gear me-2"></i> Pengaturan
                    </div>
                    <i class="bi bi-chevron-right toggle-icon-settings"></i>
                </a>

                <div class="collapse" id="settingsCollapse">
                    <ul class="nav flex-column ms-3">
                    <li class="nav-item mb-2">
                        <a href="{{ route('user_agreements.index') }}" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-question-circle me-2"></i> persetujuan Pengguna
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('privacy_policies.index') }}" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-headset me-2"></i> Kebijakan Privasi
                        </a>
                    </li>
                    </ul>
                </div>
                </li>
            </ul>
        </div>
    </div>

    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>