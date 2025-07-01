<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/png" href="/img/LogoHST.png">
</head>

<body class="bg-gray-100">
    <div class="flex relative">
        {{-- Sidebar --}}
        <div id="sidebar" :class="collapsed ? 'w-20' : 'w-64'"
            class="min-h-screen bg-white border-r flex-none transition-all duration-300">
            <x-admin-sidebar />
        </div>

        {{-- Konten + Footer --}}
        <div class="flex-1 flex flex-col relative">
            {{-- Header --}}
            <x-admin-header>{{ $title }}</x-admin-header>

            {{-- Main content --}}
            <main class="flex-1 p-6">
                {{ $slot }}

                <x-modalstatus></x-modalstatus>
            </main>

            {{-- Footer --}}
            <footer class="bg-gray-800 text-white text-sm font-semibold text-center p-2">
                <p>&copy; 2025 Website Desa - All Rights Reserved</p>
            </footer>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Periksa apakah ada hash di URL
            const hash = window.location.hash;
            if (hash) {
                const target = document.querySelector(hash);
                if (target) {
                    setTimeout(() => {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                        // Optional: highlight target sebentar
                        target.classList.add('ring', 'ring-indigo-300', 'transition');
                        setTimeout(() => target.classList.remove('ring', 'ring-indigo-300'), 2000);
                    }, 300); // Delay agar DOM siap
                }
            }
        });
    </script>
</body>


</html>
