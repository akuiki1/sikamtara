<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sikamtara</title>
    <link rel="icon" type="image/png" href="/img/LogoHST.png">
</head>

<body>
    {{-- untuk cloack herro section wellcome --}}
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* untuk transisi per-section */
        html {
            scroll-behavior: smooth;
        }
    </style>

    <div class="bg-white">
        <x-navbar></x-navbar>
        <main>
            <div> {{ $slot }}
            </div>
        </main>
        <x-footer></x-footer>
    </div>

</body>

</html>
