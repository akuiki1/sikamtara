<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- script untuk chart keuangan di dashboard admin --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sikamtara</title>
    <link rel="icon" type="image/png" href="/img/LogoHST.png">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        {{-- Sidebar --}}
        <div class="bg-white text-white">
            <x-admin-sidebar />
        </div>
        
        {{-- Konten utama --}}
        <div class="flex-1 flex flex-col">
            {{-- Header --}}
            <x-admin-header>{{ $title }}</x-admin-header>
            {{-- <x-admin-nav-link>{{ $title }}</x-admin-nav-link> --}}

            {{-- Body Konten --}}
            <main class="flex-1 p-6 overflow-y-auto">
                {{ $slot }} {{-- Konten halaman yang di-passing --}}
            </main>

            {{-- Footer --}}
            <x-admin-footer />
        </div>
    </div>

</body>
</html>
