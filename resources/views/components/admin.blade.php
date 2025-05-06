<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Website Desa</title>
    @vite('resources/css/app.css') {{-- Pastikan menggunakan Tailwind --}}
    @livewireStyles {{-- Jika menggunakan Livewire --}}
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        {{-- Sidebar --}}
        <div class="w-64 bg-gray-800 text-white">
            <x-admin.components.admin-sidebar />
        </div>

        {{-- Konten utama --}}
        <div class="flex-1 flex flex-col">
            {{-- Header --}}
            <x-admin.components.admin-header />

            {{-- Body Konten --}}
            <main class="flex-1 p-6 overflow-y-auto">
                {{ $slot }} {{-- Konten halaman yang di-passing --}}
            </main>

            {{-- Footer --}}
            <x-admin.components.admin-footer />
        </div>
    </div>

    @livewireScripts {{-- Jika menggunakan Livewire --}}
    @vite('resources/js/app.js') {{-- Pastikan menggunakan JS --}}
</body>
</html>
