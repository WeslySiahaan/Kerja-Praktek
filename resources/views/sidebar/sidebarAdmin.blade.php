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
            width: 250px;
            min-height: 100vh; /* Minimal tinggi penuh viewport */
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
                <i class="bi bi-shield-lock-fill me-2" style="font-size: 1.5rem;"></i>
                <h4 class="mb-0">Admin</h4>
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
                    @if(Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}" class="nav-link text-white d-flex align-items-center">
                            <i class="bi bi-person-fill me-2"></i> Profile
                        </a>
                    @else
                        <span class="nav-link text-white">Profile route tidak tersedia</span>
                    @endif
                </li>
            </ul>
        </div>

    
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>