<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Aplikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Google Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-10 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6">Masuk</h1>

        <!-- Notifikasi Status -->
        @if (session('status'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- Notifikasi Error -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <div class="flex items-center border border-gray-300 rounded-md mt-1 px-3 py-2 focus-within:ring-yellow-400 focus-within:border-yellow-400">
                    <span class="material-symbols-outlined text-gray-500 mr-2">mail</span>
                    <input id="email" type="email" name="email" required autofocus
                        class="w-full border-none focus:ring-0 focus:outline-none text-sm" placeholder="Email" />
                </div>
            </div>

            <!-- Password -->
            <div class="mb-6">
                <div class="flex items-center border border-gray-300 rounded-md mt-1 px-3 py-2 focus-within:ring-yellow-400 focus-within:border-yellow-400">
                    <span class="material-symbols-outlined text-gray-500 mr-2">lock</span>
                    <input id="password" type="password" name="password" required
                        class="w-full border-none focus:ring-0 focus:outline-none text-sm" placeholder="Kata Sandi" />
                </div>
            </div>

            <!-- Tombol Masuk -->
            <div class="mb-4">
                <button type="submit"
                    class="w-full h-10 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold rounded-md transition">
                    Masuk
                </button>
            </div>

            <!-- Pemisah -->
            <div class="my-6 flex items-center justify-between">
                <hr class="w-1/3 border-gray-300">
                <span class="text-sm text-gray-500">atau</span>
                <hr class="w-1/3 border-gray-300">
            </div>

            <!-- Login dengan Google -->
            <div class="mb-6">
                <a href="{{ route('google.redirect') }}"
                    class="flex items-center justify-center w-full h-10 border border-gray-300 bg-white hover:bg-gray-50 rounded-md transition text-sm font-medium text-gray-700 shadow-sm">
                    <img src="https://developers.google.com/identity/images/g-logo.png" class="w-5 h-5 mr-3" alt="Google logo">
                    Masuk dengan Google
                </a>
            </div>

            <!-- Link Daftar -->
            <div class="text-center">
                <a href="{{ route('register') }}" class="text-sm text-yellow-500 hover:underline">
                    Daftar Akun Baru
                </a>
            </div>
        </form>
    </div>
</body>
</html>
