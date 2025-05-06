<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    {{-- main background --}}
    <section class="text-center">
        <div class="absolute inset-x-0 -top-20 -z-10 overflow-hidden opacity-30 sm:-top-28" aria-hidden="true">
            <div class="relative top-28 w-full h-[857px] clip-path-t sm:h-[600px] md:h-[700px] lg:h-[857px]">
                <img src="img/KantorDesa.jpg" alt="Foto Kantor Desa Kambat Utara" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black opacity-30"></div>
            </div>
        </div>

        <style>
            .clip-path-t {
                clip-path: inset(0 0 10% 0);
                /* Potong 10% dari bawah */
            }
        </style>

        {{-- main hero --}}
        <div class="mx-auto max-w-2xl py-32 sm:py-20 lg:py-20">
            <div class="flex flex-col items-center justify-center h-[500px] text-center mb-14">
                <h1 class="text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl">SELAMAT DATANG!
                </h1>
                <p class="mt-0 text-lg font-medium text-pretty text-gray-900 sm:text-xl/8">WEBSITE RESMI PEMERINTAH DESA
                    KAMBAT UTARA
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="#"
                        class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Informasi
                        Terbaru</a>
                    <a href="#" class="text-sm/6 font-semibold text-gray-900">Akses Layanan <span
                            aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
    </section>

    {{-- bagian Laporan Dana Desa --}}
    <div class="text-center">
        <section class="relative bg-blue-600 text-white py-16 px-6 lg:px-12">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center">

                <!-- Bagian Kiri: Teks dan Info Dana Desa -->
                <div class="w-full md:w-1/2 space-y-6">
                    <h1 class="text-4xl font-bold">Laporan Dana Desa</h1>
                    <p class="text-lg">
                        Transparansi dana desa untuk pembangunan dan kesejahteraan masyarakat. Lihat laporan lengkap dan
                        rincian penggunaan anggaran.
                    </p>

                    <!-- Total Anggaran & Realisasi -->
                    <div class="bg-white text-gray-800 p-4 rounded-lg shadow-md">
                        <p class="text-lg font-semibold">Total Anggaran: <span class="text-blue-600">Rp
                                1,200,000,000</span>
                        </p>
                        <p>Realisasi: <span class="font-semibold">80%</span></p>
                        <div class="w-full bg-gray-200 h-3 rounded-full mt-2">
                            <div class="bg-green-500 h-3 rounded-full" style="width: 80%;"></div>
                        </div>
                    </div>

                    <!-- Kategori Penggunaan Dana -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div class="bg-white p-3 rounded-lg shadow-md text-gray-800">
                            <p class="text-sm font-semibold">Infrastruktur</p>
                            <p class="text-blue-600 text-lg font-bold">40%</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg shadow-md text-gray-800">
                            <p class="text-sm font-semibold">Pendidikan</p>
                            <p class="text-blue-600 text-lg font-bold">20%</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg shadow-md text-gray-800">
                            <p class="text-sm font-semibold">Kesehatan</p>
                            <p class="text-blue-600 text-lg font-bold">15%</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg shadow-md text-gray-800">
                            <p class="text-sm font-semibold">Bantuan Sosial</p>
                            <p class="text-blue-600 text-lg font-bold">25%</p>
                        </div>
                    </div>

                    <!-- Tombol CTA -->
                    <div class="space-x-4">
                        <a href="#"
                            class="bg-green-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-green-600">Lihat
                            Laporan</a>
                        <a href="#"
                            class="bg-gray-200 text-gray-800 py-2 px-4 rounded-lg shadow-md hover:bg-gray-300">Unduh
                            Laporan</a>
                    </div>
                </div>

                <!-- Bagian Kanan: Ilustrasi -->
                <div class="w-full md:w-1/2 mt-10 md:mt-0">
                    <img src="img/berita1.jpg" alt="Dana Desa"
                        class="rounded-lg shadow-lg">
                </div>

            </div>
        </section>
    </div>

    {{-- bagian berita terkini --}}
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">BERITA TERKINI</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card Berita 1 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md">
                    <img src="img/berita1.jpg" alt="Berita 1" class="w-full h-60 object-cover">
                    <div class="p-4">
                        <div class="flex justify-between text-gray-500 text-sm mb-2">
                            <span class="font-semibold">DITERBITKAN</span>
                            <span>20 Januari 2025</span>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Dolor sit amet, consectetur adipiscing elyt sed do elusmod..</h3>
                        <p class="text-gray-600 text-sm">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium...</p>
                        <button class="mt-4 w-full py-2 bg-gray-300 text-gray-500 font-semibold rounded-md cursor-not-allowed" disabled>Read More</button>
                    </div>
                </div>
                <!-- Card Berita 2 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md">
                    <img src="img/berita2.jpg" alt="Berita 2" class="w-full h-60 object-cover">
                    <div class="p-4">
                        <div class="flex justify-between text-gray-500 text-sm mb-2">
                            <span class="font-semibold">DITERBITKAN</span>
                            <span>20 Januari 2025</span>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Dolor sit amet, consectetur adipiscing elyt sed do elusmod..</h3>
                        <p class="text-gray-600 text-sm">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium...</p>
                        <button class="mt-4 w-full py-2 bg-gray-300 text-gray-500 font-semibold rounded-md cursor-not-allowed" disabled>Read More</button>
                    </div>
                </div>
                <!-- Card Berita 3 -->
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md">
                    <img src="img/berita3.jpg" alt="Berita 3" class="w-full h-60 object-cover">
                    <div class="p-4">
                        <div class="flex justify-between text-gray-500 text-sm mb-2">
                            <span class="font-semibold">DITERBITKAN</span>
                            <span>20 Januari 2025</span>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Dolor sit amet, consectetur adipiscing elyt sed do elusmod..</h3>
                        <p class="text-gray-600 text-sm">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium...</p>
                        <button class="mt-4 w-full py-2 bg-gray-300 text-gray-500 font-semibold rounded-md cursor-not-allowed" disabled>Read More</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

</x-layout>
