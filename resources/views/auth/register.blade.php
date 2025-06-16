<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar | Aplikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />

    <!-- Google Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
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
        <h1 class="text-2xl font-bold text-center mb-6">Daftar Akun</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <div class="flex items-center border border-gray-300 rounded-md mt-1 px-3 py-2 focus-within:ring-yellow-400 focus-within:border-yellow-400">
                    <span class="material-symbols-outlined text-gray-500 mr-2">person</span>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        required
                        autofocus
                        class="w-full border-none focus:ring-0 focus:outline-none text-sm"
                        placeholder="Nama"
                    />
                </div>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <div class="flex items-center border border-gray-300 rounded-md mt-1 px-3 py-2 focus-within:ring-yellow-400 focus-within:border-yellow-400">
                    <span class="material-symbols-outlined text-gray-500 mr-2">mail</span>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        required
                        class="w-full border-none focus:ring-0 focus:outline-none text-sm"
                        placeholder="Email"
                    />
                </div>
            </div>

            <!-- Password -->
            <div class="mb-6">
                <div class="flex items-center border border-gray-300 rounded-md mt-1 px-3 py-2 focus-within:ring-yellow-400 focus-within:border-yellow-400">
                    <span class="material-symbols-outlined text-gray-500 mr-2">lock</span>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="w-full border-none focus:ring-0 focus:outline-none text-sm"
                        placeholder="Kata Sandi"
                    />
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <div class="flex items-center border border-gray-300 rounded-md mt-1 px-3 py-2 focus-within:ring-yellow-400 focus-within:border-yellow-400">
                    <span class="material-symbols-outlined text-gray-500 mr-2">lock</span>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full border-none focus:ring-0 focus:outline-none text-sm"
                        placeholder="Konfirmasi Kata Sandi"
                    />
                </div>
            </div>

            <!-- Tombol Daftar -->
            <div class="mb-4">
                <button
                    type="submit"
                    class="w-full h-10 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold rounded-md transition"
                >
                    Daftar
                </button>
            </div>

            <!-- Link ke Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-yellow-500 hover:underline">
                    Sudah punya akun? Masuk
                </a>
            </div>
        </form>
    </div>

</body>
</html>
