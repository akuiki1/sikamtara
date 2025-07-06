<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register Page</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/img/LogoHST.png">
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-80 max-w-md bg-white rounded-xl shadow-md px-8 py-10">

            <!-- Tombol kembali -->
            <div class="mb-4">
                <a href="{{ route('login') }}" class="text-blue-600 text-sm hover:underline">
                    ← Kembali ke Login
                </a>
            </div>

            <!-- Logo -->
            <div class="flex justify-center gap-4">
                <img src="{{ asset('img/LogoHST.png') }}" alt="Logo Desa" class="h-10">
                <img src="{{ asset('img/LogoProv.png') }}" alt="Logo Kabupaten" class="h-10">
                <img src="{{ asset('img/LogoKemdagri.png') }}" alt="Logo Lain" class="h-12">
            </div>

            <!-- Judul -->
            <h2 class="text-2xl font-bold text-center text-blue-700 mb-12">Lupa Password</h2>

            <!-- Status -->
            @if (session('status'))
                <div class="mb-4 text-center text-green-600 text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium mb-1">Email</label>
                    <input id="email" type="email" name="email"
                        class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan email terdaftar" required>
                    @error('email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-center gap-4">
                    <a href="{{ route('login') }}" class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out hover:scale-105 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm px-3 py-1.5 sm:px-4 sm:py-2 md:px-5 md:py-2.5">
                        Batal
                    </a>
                    <x-button type="submit">
                        Kirim Kode Reset
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
