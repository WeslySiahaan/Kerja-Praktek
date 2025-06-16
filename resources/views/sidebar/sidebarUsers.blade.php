<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f4f4f9;
        }

        /* Wrapper utama untuk layout */
        .layout-wrapper {
            display: flex;
            min-height: 100vh;
            /* Tinggi minimum viewport */
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #212529;
            color: #ffffff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            /* Sidebar mengikuti tinggi viewport */
            transition: width 0.3s ease;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 0;
            border-bottom: 1px solid #444;
            margin-bottom: 20px;
        }

        .sidebar-header h4 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .sidebar-header i {
            font-size: 24px;
            margin-right: 10px;
        }

        /* Navigasi sidebar */
        .nav {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }

        .nav-link:hover {
            background-color: #343a40;
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 18px;
        }

        /* Konten kanan */
        .main-content {
            flex: 1;
            padding: 30px;
            background-color: #f4f4f9;
            min-height: 100vh;
            /* Konten kanan minimal setinggi viewport */
        }

        /* Responsivitas */
        @media (max-width: 768px) {
            .layout-wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="layout-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <i class="bi bi-person-fill"></i>
                <h4>Users</h4>
            </div>
            <ul class="nav flex-column">
                <ul class="nav flex-column">
                    <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="bi bi-person-circle"></i> Update Profile
                            </a>
                    </li>
                    <li class="nav-item">
                        @if(Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}" class="nav-link">
                            <i class="bi bi-person-fill"></i> Profile
                        </a>
                        @else
                        <span class="nav-link">Profile route tidak tersedia</span>
                        @endif
                        <a href="#" class="nav-link">
                            <i class="bi bi-clock-history"></i> Riwayat Tontonan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.pertanyaanUmum') }}" class="nav-link">
                            <i class="bi bi-question-circle"></i> Pertanyaan Umum
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.layananPelanggan') }}" class="nav-link">
                            <i class="bi bi-headset"></i> Layanan Pelanggan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bi bi-chat-left-text"></i> Hubungi / Saran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bi bi-gear"></i> Pengaturan
                        </a>
                    </li>
                </ul>
        </div>

    </div>
</body>