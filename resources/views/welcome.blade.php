<x-layout>
    <div>
        @if (session('warn'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="max-w-md mx-auto mt-6 px-4 py-3 rounded-2xl shadow-lg bg-red-50 border border-orange-300 flex items-start justify-between gap-3 animate-fade-in-down">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-orange-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M12 17h0a9 9 0 100-18 9 9 0 000 18z" />
                    </svg>
                    <div class="text-sm text-orange-800 font-medium">
                        {{ session('warn') }}
                    </div>
                </div>
                <button @click="show = false"
                    class="text-orange-600 hover:text-orange-800 text-xl font-bold leading-none focus:outline-none">
                    &times;
                </button>
            </div>
        @endif
        {{-- section hero --}}
        <section x-data="heroSlider()" x-init="init()" class="relative h-screen overflow-hidden">
            <!-- Slides Background -->
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="currentSlide === index" x-transition:enter="transition-opacity duration-700"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-700" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="absolute inset-0 bg-cover bg-center will-change-transform"
                    :style="`background-image: url(${slide.image}); transform: translateY(${parallaxOffset}px)`">
                </div>
            </template>

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/50"></div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">SELAMAT DATANG!</h1>
                <p class="text-lg md:text-2xl mb-6 drop-shadow-md">WEBSITE RESMI PEMERINTAH DESA KAMBAT UTARA</p>
                <div class="flex gap-4">
                    <a href="/informasi/berita"
                        class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-3 px-6 rounded-full transition">Informasi
                        Terbaru</a>
                    <a href="/layanan/administrasi"
                        class="border border-white hover:bg-white hover:text-black font-semibold py-3 px-6 rounded-full transition">Akses
                        Layanan →</a>
                </div>
            </div>

            <!-- Navigation Arrows -->
            <button @click="prev()"
                class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-black/30 hover:bg-black/60 text-white p-3 rounded-full transition hidden md:block">
                ←
            </button>

            <button @click="next()"
                class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-black/30 hover:bg-black/60 text-white p-3 rounded-full transition hidden md:block">
                →
            </button>

            <!-- Dots Indicator -->
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex gap-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="goToSlide(index)"
                        :class="{ 'bg-white': currentSlide === index, 'bg-white/50': currentSlide !== index }"
                        class="w-3 h-3 rounded-full transition">
                    </button>
                </template>
            </div>
        </section>

        <!-- Alpine.js Logic -->
        <script>
            function heroSlider() {
                return {
                    currentSlide: 0,
                    slides: [{
                            image: 'img/KantorDesa.png'
                        },
                        {
                            image: 'https://up2date.id/wp-content/uploads/2024/11/noemalisasi.jpg'
                        },
                        {
                            image: 'https://totabuan.news/wp-content/uploads/2021/11/182-1822070_pemandangan-alam-indonesia-hd.jpg'
                        }
                    ],
                    interval: null,
                    parallaxOffset: 0,

                    init() {
                        this.startAutoSlide();
                        window.addEventListener('scroll', this.handleScroll.bind(this));
                    },
                    startAutoSlide() {
                        this.interval = setInterval(() => {
                            this.next();
                        }, 5000);
                    },
                    resetAutoSlide() {
                        clearInterval(this.interval);
                        this.startAutoSlide();
                    },
                    next() {
                        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                        this.resetAutoSlide();
                    },
                    prev() {
                        this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                        this.resetAutoSlide();
                    },
                    goToSlide(index) {
                        this.currentSlide = index;
                        this.resetAutoSlide();
                    },
                    handleScroll() {
                        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                        this.parallaxOffset = scrollTop * 0.3;
                    }
                }
            }
        </script>

        <!-- Section: Jelajahi Sistem Desa -->
        <section class="bg-yellow-400 py-16">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">JELAJAHI SISTEM DESA</h2>
                <p class="text-base md:text-lg text-gray-800 mb-12 max-w-3xl mx-auto">
                    Melalui website ini Anda dapat menjelajahi segala hal yang terkait dengan Desa.
                    Aspek pemerintahan, penduduk, demografi, potensi Desa, dan juga berita tentang Desa.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1 -->
                    <a href="#" class="block bg-white rounded-lg shadow-md hover:shadow-lg transition p-8">
                        <div class="flex items-center justify-center mb-4">
                            {{-- Icon Placeholder --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-yellow-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5 0a4 4 0 01-8 0 4 4 0 018 0zM9 5a3 3 0 100 6 3 3 0 000-6zM15 11a3 3 0 100-6 3 3 0 000 6z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">PROFIL DESA</h3>
                    </a>

                    <!-- Card 2 -->
                    <a href="#" class="block bg-white rounded-lg shadow-md hover:shadow-lg transition p-8">
                        <div class="flex items-center justify-center mb-4">
                            {{-- Icon Placeholder --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-yellow-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3v18h18M9 17V9m4 8V5m4 12v-4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">INFOGRAFIS</h3>
                    </a>

                    <!-- Card 3 -->
                    <a href="#" class="block bg-white rounded-lg shadow-md hover:shadow-lg transition p-8">
                        <div class="flex items-center justify-center mb-4">
                            {{-- Icon Placeholder --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-yellow-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7h1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h11.5M7 14h6m-6 3h6m0-10h.5m-.5 3h.5M7 7h3v3H7V7Z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Informasi Penting</h3>
                    </a>

                    <!-- Card 4 -->
                    <a href="#" class="block bg-white rounded-lg shadow-md hover:shadow-lg transition p-8">
                        <div class="flex items-center justify-center mb-4">
                            {{-- Icon Placeholder --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-yellow-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H9a2 2 0 00-2 2v2M5 10h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2zm7 4h.01" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">APBDes</h3>
                    </a>
                </div>
            </div>
        </section>

        <!-- Section: Layanan Administrasi -->
        <section class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-6">
                {{-- Section Title --}}
                <div class="text-center mb-14">
                    <h2 class="text-4xl font-bold text-gray-900">LAYANAN ADMINISTRASI DESA</h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                        Nikmati kemudahan layanan administrasi dan pengaduan desa langsung dari rumahmu, cepat dan
                        terpercaya.
                    </p>
                </div>

                {{-- Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                    {{-- Card 1 - LAYANAN ONLINE --}}
                    <div
                        class="bg-gradient-to-tr from-blue-400 to-blue-600 rounded-3xl shadow-xl p-8 flex flex-col hover:scale-105 transform transition duration-300 ease-in-out">
                        <div class="flex flex-col items-center text-center">
                            {{-- Icon --}}
                            <div class="bg-white p-4 rounded-full shadow-md mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-3-9v18m8-9H5" />
                                </svg>
                            </div>
                            {{-- Title --}}
                            <h3 class="text-2xl font-bold text-white mb-4">LAYANAN ONLINE</h3>
                            {{-- Description --}}
                            <p class="text-white/90 mb-6">
                                Ajukan berbagai surat administrasi seperti surat keterangan, domisili, usaha, dan
                                lainnya
                                dengan praktis tanpa antri.
                            </p>
                            {{-- CTA --}}
                            <a href="/layanan/administrasi"
                                class="inline-block bg-white text-blue-600 font-bold py-3 px-6 rounded-full shadow hover:bg-blue-100 transition-all duration-300">
                                Ajukan Sekarang
                            </a>
                        </div>
                    </div>

                    {{-- Card 2 - PENGADUAN ONLINE --}}
                    <div
                        class="bg-gradient-to-tr from-yellow-300 to-yellow-500 rounded-3xl shadow-xl p-8 flex flex-col hover:scale-105 transform transition duration-300 ease-in-out">
                        <div class="flex flex-col items-center text-center">
                            {{-- Icon --}}
                            <div class="bg-white p-4 rounded-full shadow-md mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 5.636L5.636 18.364M5.636 5.636l12.728 12.728" />
                                </svg>
                            </div>
                            {{-- Title --}}
                            <h3 class="text-2xl font-bold text-white mb-4">PENGADUAN ONLINE</h3>
                            {{-- Description --}}
                            <p class="text-white/90 mb-6">
                                Sampaikan keluhan, aspirasi, atau masukan kepada perangkat desa secara cepat,
                                transparan,
                                dan tuntas.
                            </p>
                            {{-- CTA --}}
                            <a href="/layanan/pengaduan"
                                class="inline-block bg-white text-yellow-600 font-bold py-3 px-6 rounded-full shadow hover:bg-yellow-100 transition-all duration-300">
                                Kirim Pengaduan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Keuangan Desa -->
        <section class="bg-gray-100 py-20">
            @php
                $anggaran = 120000000; // Rp 120.000.000
                $realisasi = 95000000; // Rp 95.000.000
                $selisih = $anggaran - $realisasi;
            @endphp

            <div class="max-w-7xl mx-auto px-6">
                {{-- Section Title --}}
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-extrabold text-gray-800">Ringkasan Keuangan Desa</h2>
                    <p class="mt-4 text-gray-500 text-lg max-w-2xl mx-auto">
                        Update keuangan desa secara real-time, transparan, dan terpercaya.
                    </p>
                </div>

                {{-- Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                    {{-- Card 1 - Anggaran --}}
                    <div x-data="{ angka: 0 }" x-init="let interval = setInterval(() => {
                        if (angka < {{ $anggaran }}) angka += Math.ceil({{ $anggaran }} / 100);
                        else {
                            angka = {{ $anggaran }};
                            clearInterval(interval);
                        }
                    }, 20)"
                        class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition duration-500 relative overflow-hidden">
                        {{-- Badge --}}
                        <div
                            class="w-32 text-center mb-4 top-6 right-6 bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                            Anggaran
                        </div>
                        {{-- Number --}}
                        <h3 class="text-4xl font-extrabold text-gray-800 mb-4"
                            x-text="'Rp ' + angka.toLocaleString('id-ID')"></h3>
                        {{-- Description --}}
                        <p class="text-gray-500 text-sm mb-6">
                            Total anggaran desa untuk pembangunan dan pemberdayaan.
                        </p>
                        {{-- Mini Chart --}}
                        <div class="h-16">
                            <svg viewBox="0 0 100 30" class="w-full h-full text-blue-400">
                                <polyline fill="none" stroke="currentColor" stroke-width="4"
                                    points="0,20 20,10 40,15 60,5 80,10 100,0" />
                            </svg>
                        </div>
                    </div>

                    {{-- Card 2 - Realisasi --}}
                    <div x-data="{ angka: 0 }" x-init="let interval = setInterval(() => {
                        if (angka < {{ $realisasi }}) angka += Math.ceil({{ $realisasi }} / 100);
                        else {
                            angka = {{ $realisasi }};
                            clearInterval(interval);
                        }
                    }, 20)"
                        class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition duration-500 relative overflow-hidden">
                        {{-- Badge --}}
                        <div
                            class="w-32 text-center mb-4 top-6 right-6 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                            Realisasi
                        </div>
                        {{-- Number --}}
                        <h3 class="text-4xl font-extrabold text-gray-800 mb-4"
                            x-text="'Rp ' + angka.toLocaleString('id-ID')"></h3>
                        {{-- Description --}}
                        <p class="text-gray-500 text-sm mb-6">
                            Dana yang telah terealisasi untuk kegiatan desa.
                        </p>
                        {{-- Mini Chart --}}
                        <div class="h-16">
                            <svg viewBox="0 0 100 30" class="w-full h-full text-green-400">
                                <polyline fill="none" stroke="currentColor" stroke-width="4"
                                    points="0,25 20,15 40,20 60,10 80,5 100,8" />
                            </svg>
                        </div>
                    </div>

                    {{-- Card 3 - Selisih --}}
                    <div x-data="{ angka: 0 }" x-init="let interval = setInterval(() => {
                        if (angka < {{ $selisih }}) angka += Math.ceil({{ $selisih }} / 100);
                        else {
                            angka = {{ $selisih }};
                            clearInterval(interval);
                        }
                    }, 20)"
                        class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition duration-500 relative overflow-hidden">
                        {{-- Badge --}}
                        <div
                            class="w-32 top-6 right-6 bg-rose-500 text-white text-xs text-center font-bold px-3 py-1 rounded-full uppercase tracking-wide mb-4">
                            Selisih
                        </div>
                        {{-- Number --}}
                        <h3 class="text-4xl font-extrabold text-gray-800 mb-4"
                            x-text="'Rp ' + angka.toLocaleString('id-ID')"></h3>
                        {{-- Description --}}
                        <p class="text-gray-500 text-sm mb-6">
                            Selisih antara anggaran dengan realisasi.
                        </p>
                        {{-- Mini Chart --}}
                        <div class="h-16">
                            <svg viewBox="0 0 100 30" class="w-full h-full text-rose-400">
                                <polyline fill="none" stroke="currentColor" stroke-width="4"
                                    points="0,10 20,20 40,10 60,15 80,20 100,25" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Button --}}
                <div class="text-center">
                    <a href="#"
                        class="inline-flex items-center gap-3 px-10 py-4 bg-gradient-to-r from-gray-800 to-gray-900 text-white text-lg font-semibold rounded-full hover:scale-105 transform transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                        Lihat Semua Laporan
                    </a>
                </div>
            </div>
        </section>

        <!-- Section: Berita & Pengumuman -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Berita Terbaru Desa</h2>
                    <p class="text-gray-500">Stay tuned sama kabar-kabar gokil dari desa kita! 🌾🔥</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Card Berita --}}
                    @foreach (range(1, 3) as $item)
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                            <img class="h-36 w-full object-cover" src="https://via.placeholder.com/400x250"
                                alt="Foto Berita">
                            <div class="p-4 flex flex-col justify-between flex-grow">
                                <div>
                                    <p class="text-[11px] text-gray-400 mb-1">Diterbitkan pada 25 April 2025</p>
                                    <h3 class="text-base font-semibold text-gray-800 mb-1 line-clamp-2">Judul Berita
                                        Desa
                                        Singkat & Gacor</h3>
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-3">
                                        Deskripsi singkat berita terbaru yang membuat warga makin cinta desa sendiri.
                                    </p>
                                </div>
                                <div class="mt-auto flex flex-col space-y-2">
                                    <a href="#"
                                        class="text-primary-600 text-sm font-medium hover:underline">Baca
                                        Selengkapnya →</a>
                                    <p class="text-[11px] text-gray-400 text-right">Oleh Admin Desa</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Tombol Lihat Semua Berita --}}
                <div class="mt-10 text-center">
                    <div class="text-center">
                        <a href="#"
                            class="inline-flex items-center gap-3 px-10 py-4 bg-gradient-to-r from-gray-800 to-gray-900 text-white text-lg font-semibold rounded-full hover:scale-105 transform transition duration-300">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg> --}}
                            Lihat Berita Lainnya
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-layout>
