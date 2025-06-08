<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-10 px-6 text-center">
    </section>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detail Berita - Desa Kambat Utara</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    </head>

    <body class="bg-gray-100 font-sans">
        <!-- Container -->
        <div class="max-w-5xl mx-auto px-4 py-8 bg-white shadow-md rounded-md mb-10">

            <!-- Tombol Kembali -->
            <a href="/informasi/berita" class="inline-flex items-center text-blue-600 hover:underline mb-4">
                <i class="ti ti-arrow-left mr-2"></i> Kembali ke Berita
            </a>

            <!-- Judul -->
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Pelatihan Pengelolaan Ekonomi Rumah Tangga Tingkatkan
                Kapasitas Keluarga</h1>

            <!-- Info Penulis dan Tanggal -->
            <div class="flex items-center text-sm text-gray-600 mb-4">
                <i class="ti ti-calendar mr-1"></i> 20 Januari 2025
                <span class="mx-2">•</span>
                <i class="ti ti-user mr-1"></i> Ditulis oleh Administrator
            </div>

            <!-- Gambar -->
            <img src="https://cdn1.katadata.co.id/media/images/2025/04/27/Anggota_Komisi_C_DPRD_DKI_Jakarta_Brando_Susanto-2025_04_27-19_03_31_d542ef88cccea8e7c4123dda4d0c9604.png"
                alt="Gambar Berita" class="w-full h-auto rounded-md mb-6">

            <!-- Isi Berita -->
            <div class="text-gray-700 leading-relaxed space-y-4">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut malesuada dignissim nulla, at ullamcorper
                    felis faucibus sit amet. Proin bibendum dictum ipsum. Suspendisse at orci at felis dictum faucibus.
                    Curabitur vel purus sed elit vestibulum accumsan.</p>
                <p>Donec vel lacinia lorem. Cras lacinia fermentum ligula, non pulvinar urna mattis sed. Quisque a mi
                    non leo iaculis sollicitudin. Integer egestas magna eu justo commodo, at tempor enim dignissim.</p>
                <p>Pelatihan ini diharapkan dapat memberikan pemahaman dan keterampilan dasar kepada masyarakat dalam
                    mengelola keuangan rumah tangga secara lebih baik.</p>
            </div>

            <h2 class="text-2xl font-semibold text-gray-900 mt-10 mb-4">Berita Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="/berita/detail-1" class="bg-white rounded-lg shadow p-4 hover:shadow-md transition">
                    <img src="/img/berita.jpg" alt="Berita" class="w-full h-36 object-cover rounded mb-2">
                    <h3 class="font-semibold text-gray-800 text-sm">Pelatihan Digitalisasi UMKM untuk Peningkatan
                        Ekonomi Lokal</h3>
                    <p class="text-xs text-gray-500 mt-1">20 Januari 2025</p>
                </a>
                <a href="/berita/detail-2" class="bg-white rounded-lg shadow p-4 hover:shadow-md transition">
                    <img src="/img/berita.jpg" alt="Berita" class="w-full h-36 object-cover rounded mb-2">
                    <h3 class="font-semibold text-gray-800 text-sm">Sosialisasi Kesehatan Ibu dan Anak di Desa Kambat
                        Utara</h3>
                    <p class="text-xs text-gray-500 mt-1">19 Januari 2025</p>
                </a>
                <a href="/berita/detail-3" class="bg-white rounded-lg shadow p-4 hover:shadow-md transition">
                    <img src="/img/berita.jpg" alt="Berita" class="w-full h-36 object-cover rounded mb-2">
                    <h3 class="font-semibold text-gray-800 text-sm">Program Pengembangan Infrastruktur Desa Berjalan
                        Lancar</h3>
                    <p class="text-xs text-gray-500 mt-1">18 Januari 2025</p>
                </a>
            </div>
        </div>
    </body>
</x-layout>
