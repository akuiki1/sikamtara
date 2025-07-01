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
        <section id="beranda" x-data="{
            currentSlide: 0,
            slides: [
                @php $slides = collect($gambarSlides)
                        ->prepend('img/kantordesa.jpg')
                        ->map(fn($path) => asset(Str::startsWith($path, 'img/') ? $path : 'storage/' . $path)); @endphp
        
                @foreach ($slides as $url)
                    { image: '{{ $url }}' }{{ !$loop->last ? ',' : '' }} @endforeach
            ],
            interval: null,
        
            init() {
                this.startAutoSlide();
            },
            startAutoSlide() {
                this.interval = setInterval(() => this.next(), 8000);
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
            }
        }" x-init="init()"
            class="relative w-full h-[400px] md:h-screen overflow-hidden">

            <!-- Slides Container -->
            <div class="absolute inset-0 flex transition-transform duration-700 ease-in-out"
                :style="`transform: translateX(-${currentSlide * 100}%);`">
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="min-w-full h-[400px] md:h-screen bg-cover bg-center"
                        :style="`background-image: url(${slide.image})`"></div>
                </template>
            </div>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/70 z-0"></div>

            <!-- Content (mobile & desktop) -->
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4">
                <h1 class="text-xl sm:text-2xl md:text-6xl font-bold mb-2 md:mb-4 drop-shadow-lg">SELAMAT DATANG!</h1>
                <p class="text-sm sm:text-base md:text-2xl mb-4 md:mb-6 drop-shadow-md">
                    WEBSITE RESMI PEMERINTAH DESA KAMBAT UTARA
                </p>
                <div class="flex gap-2 sm:gap-4 flex-wrap justify-center text-sm sm:text-base">
                    <a href="#jelajahi"
                        class="bg-yellow-300 hover:bg-yellow-400 text-black font-semibold py-2 px-4 sm:py-3 sm:px-6 rounded-full transition">
                        Jelajahi sistem desa
                    </a>
                    <a href="#layanan"
                        class="border border-white hover:bg-white hover:text-black font-semibold py-2 px-4 sm:py-3 sm:px-6 rounded-full transition">
                        Pengajuan layanan online
                    </a>
                </div>
            </div>

            <!-- Arrows (hanya desktop) -->
            <button @click="prev()"
                class="absolute z-20 top-1/2 left-4 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-3 rounded-full transition hidden md:block"
                aria-label="Previous Slide">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button @click="next()"
                class="absolute z-20 top-1/2 right-4 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-3 rounded-full transition hidden md:block"
                aria-label="Next Slide">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Dots (tampilkan juga di mobile) -->
            <div class="absolute bottom-4 sm:bottom-6 left-1/2 transform -translate-x-1/2 flex gap-2 z-20">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="goToSlide(index)"
                        :class="{
                            'bg-white scale-110': currentSlide === index,
                            'bg-white/50': currentSlide !== index
                        }"
                        class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full transition duration-300 transform"></button>
                </template>
            </div>
        </section>


        <!-- Section: Jelajahi Sistem Desa -->
        <section id="jelajahi" class="bg-gray-50 py-16 sm:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    JELAJAHI SISTEM DESA
                </h2>
                <p class="text-sm sm:text-base md:text-lg text-gray-600 mb-10 sm:mb-12 max-w-2xl mx-auto">
                    Melalui website ini Anda dapat menjelajahi segala hal yang terkait dengan Desa: pemerintahan,
                    penduduk, demografi, potensi, hingga berita terkini.
                </p>

                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                    {{-- Profil Desa --}}
                    <a href="{{ route('public.profil.desa') }}"
                        class="group block rounded-xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-1 p-4 sm:p-5 md:p-6 text-center bg-white">
                        <div class="flex items-center justify-center mb-3 sm:mb-4 md:mb-5">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 rounded-full bg-yellow-300 flex items-center justify-center shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 text-gray-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M10 18v-7" />
                                    <path
                                        d="M11.12 2.198a2 2 0 0 1 1.76.006l7.866 3.847c.476.233.31.949-.22.949H3.474c-.53 0-.695-.716-.22-.949z" />
                                    <path d="M14 18v-7" />
                                    <path d="M18 18v-7" />
                                    <path d="M3 22h18" />
                                    <path d="M6 18v-7" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-sm sm:text-base md:text-lg font-semibold text-gray-800 group-hover:text-yellow-300 transition-colors">
                            Profil Desa
                        </h3>
                    </a>

                    {{-- Statistik Penduduk --}}
                    <a href="{{ route('user.kependudukan') }}"
                        class="group block rounded-xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-1 p-4 sm:p-5 md:p-6 text-center bg-white">
                        <div class="flex items-center justify-center mb-3 sm:mb-4 md:mb-5">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 rounded-full bg-yellow-300 flex items-center justify-center shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 text-gray-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 16v5" />
                                    <path d="M16 14v7" />
                                    <path d="M20 10v11" />
                                    <path d="m22 3-8.646 8.646a.5.5 0 0 1-.708 0L9.354 8.354a.5.5 0 0 0-.707 0L2 15" />
                                    <path d="M4 18v3" />
                                    <path d="M8 14v7" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-sm sm:text-base md:text-lg font-semibold text-gray-800 group-hover:text-yellow-300 transition-colors">
                            Statistik Penduduk
                        </h3>
                    </a>

                    {{-- Pengumuman Desa --}}
                    <a href="{{ route('public.pengumuman') }}"
                        class="group block rounded-xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-1 p-4 sm:p-5 md:p-6 text-center bg-white">
                        <div class="flex items-center justify-center mb-3 sm:mb-4 md:mb-5">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 rounded-full bg-yellow-300 flex items-center justify-center shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 text-gray-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M15 18h-5" />
                                    <path d="M18 14h-8" />
                                    <path
                                        d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2" />
                                    <rect width="8" height="4" x="10" y="6" rx="1" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-sm sm:text-base md:text-lg font-semibold text-gray-800 group-hover:text-yellow-300 transition-colors">
                            Pengumuman Desa
                        </h3>
                    </a>

                    {{-- Keuangan Desa --}}
                    <a href="{{ route('user.keuangan') }}"
                        class="group block rounded-xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-1 p-4 sm:p-5 md:p-6 text-center bg-white">
                        <div class="flex items-center justify-center mb-3 sm:mb-4 md:mb-5">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 rounded-full bg-yellow-300 flex items-center justify-center shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 text-gray-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1" />
                                    <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-sm sm:text-base md:text-lg font-semibold text-gray-800 group-hover:text-yellow-300 transition-colors">
                            Keuangan Desa
                        </h3>
                    </a>
                </div>
            </div>
        </section>

        <!-- Section: Layanan Administrasi -->
        <section id="layanan" class="bg-gray-100 py-16 sm:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                {{-- Section Title --}}
                <div class="text-center mb-12 sm:mb-14">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800">LAYANAN ADMINISTRASI DESA</h2>
                    <p class="mt-4 text-sm sm:text-base md:text-lg text-gray-600 max-w-2xl mx-auto">
                        Nikmati kemudahan layanan administrasi dan pengaduan desa langsung dari rumahmu, cepat dan
                        terpercaya.
                    </p>
                </div>

                {{-- Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-10">

                    {{-- Card 1 - LAYANAN ONLINE --}}
                    <div
                        class="bg-gradient-to-tr from-blue-400 to-blue-600 rounded-3xl shadow-lg hover:shadow-xl p-6 sm:p-8 flex flex-col transform transition duration-300 ease-in-out">
                        <div class="flex flex-col items-center text-center">
                            {{-- Icon --}}
                            <div class="bg-white p-3 sm:p-4 rounded-full shadow-md mb-4 sm:mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-10 w-10 sm:h-12 sm:w-12 text-blue-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-3-9v18m8-9H5" />
                                </svg>
                            </div>
                            {{-- Title --}}
                            <h3 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4">LAYANAN ONLINE</h3>
                            {{-- Description --}}
                            <p class="text-sm sm:text-base text-white/90 mb-5 sm:mb-6">
                                Ajukan berbagai surat administrasi seperti surat keterangan, domisili, usaha, dan
                                lainnya
                                dengan praktis tanpa antri.
                            </p>
                            {{-- CTA --}}
                            <a href="{{ route('administrasi') }}"
                                class="inline-block bg-white text-blue-600 font-bold py-2 px-4 text-sm sm:py-3 hover:scale-105 sm:px-6 sm:text-base rounded-full shadow transition-all duration-300">
                                Ajukan Sekarang
                            </a>
                        </div>
                    </div>

                    {{-- Card 2 - PENGADUAN ONLINE --}}
                    <div
                        class="bg-gradient-to-tr from-yellow-300 to-yellow-500 rounded-3xl shadow-lg hover:shadow-xl p-6 sm:p-8 flex flex-col transform transition duration-300 ease-in-out">
                        <div class="flex flex-col items-center text-center">
                            {{-- Icon --}}
                            <div class="bg-white p-3 sm:p-4 rounded-full shadow-md mb-4 sm:mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-10 w-10 sm:h-12 sm:w-12 text-yellow-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 5.636L5.636 18.364M5.636 5.636l12.728 12.728" />
                                </svg>
                            </div>
                            {{-- Title --}}
                            <h3 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4">PENGADUAN ONLINE</h3>
                            {{-- Description --}}
                            <p class="text-sm sm:text-base text-white/90 mb-5 sm:mb-6">
                                Sampaikan keluhan, aspirasi, atau masukan kepada perangkat desa secara cepat,
                                transparan, dan tuntas.
                            </p>
                            {{-- CTA --}}
                            <a href="{{ route('pengaduan') }}"
                                class="inline-block bg-white text-yellow-600 font-bold py-2 px-4 text-sm sm:py-3 hover:scale-105 sm:px-6 sm:text-base rounded-full shadow transition-all duration-300">
                                Kirim Pengaduan
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Section: Keuangan Desa -->
        <section id="apbdes" class="bg-gray-50 py-20">
            <div class="max-w-6xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between mb-10">
                    <h2 class="text-2xl sm:text-4xl font-bold text-center text-gray-800">Ringkasan Dana Desa</h2>

                    {{-- Tahun Selector --}}
                    <form id="tahunForm" class="flex items-center justify-center space-x-4">
                        <label for="tahun" class="text-base font-semibold text-gray-800">Tahun</label>
                        <select name="tahun" id="tahun"
                            class="px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
                            @if ($daftarTahun->isEmpty())
                                <option value="">Tidak ada data tahun</option>
                            @else
                                @foreach ($daftarTahun as $item)
                                    <option value="{{ $item->id_tahun_anggaran }}"
                                        {{ $item->id_tahun_anggaran == $tahun->id_tahun_anggaran ? 'selected' : '' }}>
                                        {{ $item->tahun }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </form>
                </div>
                {{-- Kartu Ringkasan --}}
                @if ($tahun && $daftarTahun->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-8">

                        {{-- Pendapatan --}}
                        <div
                            class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-6 flex flex-col gap-4">
                            <div class="flex items-center justify-between">
                                <div class="rounded-xl bg-emerald-100 p-3 text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 26 26">
                                        <path fill="currentColor"
                                            d="M19.531 1.531L14.25 4.406L5.5 9.188L.219 12.094L2.5 16.219V13A1.5 1.5 0 0 1 4 11.5h.813l.03-.125l11.595-6.344l.875.25c.024.08.05.173.093.25c.344.63 1.12.876 1.75.532c.076-.042.125-.133.188-.188l.906.281l2 3.657l-.25.906c-.079.024-.173.02-.25.062c-.293.16-.49.428-.594.719H25l-2.594-4.719l-2.875-5.25zm-1.093 6.563a1.305 1.305 0 0 0-1.032 1.281c0 .716.565 1.313 1.282 1.313c.716 0 1.312-.597 1.312-1.313s-.596-1.281-1.313-1.281c-.089 0-.165-.018-.25 0zm-4.875.875a4.256 4.256 0 0 0-2.188.531c-.871.476-1.523 1.204-1.875 2h7.25a2.94 2.94 0 0 0-.313-.875c-.566-1.034-1.664-1.62-2.875-1.656zM4 13v13h22V13H4zm4.406 1.594h13.188l.656.656c-.017.083-.063.162-.063.25c0 .717.596 1.313 1.313 1.313c.088 0 .167-.047.25-.063l.656.656v4.188l-.656.656c-.083-.017-.162-.063-.25-.063c-.717 0-1.313.596-1.313 1.313c0 .088.046.167.063.25l-.656.656H8.406l-.656-.656c.017-.083.063-.162.063-.25c0-.717-.596-1.313-1.313-1.313c-.088 0-.167.047-.25.063l-.656-.656v-4.188l.656-.656c.083.017.162.063.25.063c.717 0 1.313-.596 1.313-1.313c0-.088-.046-.167-.063-.25l.656-.656zm6.594 1.5c-2.168 0-3.938 1.52-3.938 3.406c0 1.886 1.77 3.406 3.938 3.406s3.938-1.52 3.938-3.406c0-1.886-1.77-3.406-3.938-3.406zm-6.5 2.093c-.716 0-1.313.597-1.313 1.313s.597 1.313 1.313 1.313s1.313-.597 1.313-1.313s-.597-1.313-1.313-1.313zm13 0c-.717 0-1.313.596-1.313 1.313s.596 1.313 1.313 1.313s1.313-.596 1.313-1.313s-.596-1.313-1.313-1.313z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 text-left">Pendapatan</p>
                                <p class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mt-1 text-left"
                                    id="text-pendapatan">
                                    Rp {{ number_format($pendapatan, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- Belanja --}}
                        <div
                            class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-6 flex flex-col gap-4">
                            <div class="flex items-center justify-between">
                                <div class="rounded-xl bg-rose-100 p-3 text-rose-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5"
                                            d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 text-left">Belanja</p>
                                <p class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mt-1 text-left"
                                    id="text-belanja">
                                    Rp {{ number_format($totalBelanja, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- Surplus / Defisit --}}
                        <div
                            class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-6 flex flex-col gap-4">
                            <div class="flex items-center justify-between">
                                <div class="rounded-xl bg-indigo-100 p-3 text-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 16 16">
                                        <path fill="currentColor"
                                            d="m15.81 10l-2.5-5H14a.5.5 0 0 0 0-1h-.79a6.04 6.04 0 0 0-4.198-1.95L9 2a1 1 0 0 0-2 0v.05a6.168 6.168 0 0 0-4.247 1.947L2 4a.5.5 0 0 0 0 1h.69l-2.5 5H0c0 1.1 1.34 2 3 2s3-.9 3-2h-.19L3.26 4.91a.525.525 0 0 0 .159-.148A4.842 4.842 0 0 1 6.994 3.06L7 14H6v1H4v1h8v-1h-2v-1H9V3.06a4.71 4.71 0 0 1 3.524 1.693a.519.519 0 0 0 .193.186L10.19 10H10c0 1.1 1.34 2 3 2s3-.9 3-2h-.19zM5 10H1l2-3.94zm6 0l2-3.94L15 10h-4z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 text-left">Surplus / Defisit</p>
                                <p class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mt-1 text-left"
                                    id="text-surplus">
                                    Rp {{ number_format($surplusDefisit, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- Pembiayaan Netto --}}
                        <div
                            class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-6 flex flex-col gap-4">
                            <div class="flex items-center justify-between">
                                <div class="rounded-xl bg-violet-100 p-3 text-violet-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5"
                                            d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7a48.678 48.678 0 0 0-7.324 0a4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7a48.656 48.656 0 0 0 7.324 0a4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 text-left">Pembiayaan Netto</p>
                                <p class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mt-1 text-left"
                                    id="text-pembiayaan">
                                    Rp {{ number_format($pembiayaanNetto, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- SILPA --}}
                        <div
                            class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-6 flex flex-col gap-4">
                            <div class="flex items-center justify-between">
                                <div class="rounded-xl bg-amber-100 p-3 text-amber-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M19.5 7H18V6a3.003 3.003 0 0 0-3-3H4.5A2.502 2.502 0 0 0 2 5.5V18a3.003 3.003 0 0 0 3 3h14.5a2.502 2.502 0 0 0 2.5-2.5v-9A2.502 2.502 0 0 0 19.5 7zm-15-3H15a2.003 2.003 0 0 1 2 2v1H4.5a1.5 1.5 0 1 1 0-3zM21 16h-2a2 2 0 0 1 0-4h2v4zm0-5h-2a3 3 0 1 0 0 6h2v1.5a1.5 1.5 0 0 1-1.5 1.5H5a2.003 2.003 0 0 1-2-2V7.499c.432.326.959.502 1.5.501h15A1.5 1.5 0 0 1 21 9.5V11z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 text-left">SILPA {{ $tahun->tahun }}</p>
                                <p class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mt-1 text-left"
                                    id="text-silpa">
                                    Rp {{ number_format($silpa_akhir, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>

                    </div>
                @else
                    <div class="bg-yellow-100 text-yellow-800 text-center py-4 rounded-xl shadow font-medium">
                        Data belum tersedia. Silakan pilih tahun terlebih dahulu.
                    </div>
                @endif

                {{-- Tombol Keuangan --}}
                <div class="mt-14 text-center">
                    <a href="{{ route('user.keuangan') }}"
                        class="inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-3 sm:py-4 
                        bg-blue-600 hover:bg-blue-700 text-white text-base sm:text-lg md:text-xl 
                        font-semibold rounded-lg sm:rounded-xl shadow transition-all duration-200 
                        hover:scale-105 hover:shadow-lg">
                        <span>Lihat Detail Keuangan</span>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- Scripts APBDes --}}
        <script>
            const tahunSelect = document.getElementById('tahun');
            const chartCanvas = document.getElementById('chartRingkasan');
            let chartInstance = null;

            async function fetchRingkasan(idTahun) {
                const response = await fetch(`/ringkasan-tahun?tahun=${idTahun}`);
                return await response.json();
            }

            function formatRupiah(value) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(value);
            }

            function updateText(data) {
                document.getElementById('text-pendapatan').textContent = formatRupiah(data.pendapatan);
                document.getElementById('text-belanja').textContent = formatRupiah(data.belanja);
                document.getElementById('text-surplus').textContent = formatRupiah(data.surplusDefisit);
                document.getElementById('text-pembiayaan').textContent = formatRupiah(data.pembiayaanNetto);
                document.getElementById('text-silpa').textContent = formatRupiah(data.silpa_akhir);
            }

            tahunSelect.addEventListener('change', async () => {
                const data = await fetchRingkasan(tahunSelect.value);
                updateText(data);
                renderChart(data);
            });
        </script>

        <!-- Section: Berita & Pengumuman -->
        <section id="berita" class="py-16 bg-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">BERITA TERBARU DESA</h2>
                    <p class="text-gray-500">Stay tuned sama kabar-kabar gokil dari desa kita!</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    {{-- Card Berita --}}
                    @if ($berita->count())
                        @foreach ($berita as $item)
                            <div
                                class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-md transition border">
                                <img src="{{ asset('storage/' . $item->gambar_cover) }}" alt="Gambar Berita"
                                    class="w-full h-36 object-cover">
                                <div class="p-4 space-y-2">
                                    <h2 class="font-semibold text-sm text-gray-800 leading-tight line-clamp-2">
                                        <a href="/informasi/berita/detail/{{ $item->id_berita }}"
                                            class="hover:underline">
                                            {{ $item->judul_berita }}
                                        </a>
                                    </h2>
                                    <p class="text-xs text-gray-600 line-clamp-3">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($item->isi_berita), 70) }}
                                    </p>
                                    <div class="flex justify-between items-center text-[11px] text-gray-400 pt-2">
                                        <div>
                                            <p>{{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d M Y H:i') }}
                                            </p>
                                            <p>Oleh {{ $item->user->nama }}</p>
                                        </div>
                                        <a href="/informasi/berita/detail/{{ $item->id_berita }}"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-0.5 rounded-full text-[11px] transition">Detail</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Pagination --}}
                        <div class="mt-6 flex">
                            {{ $berita->links() }}
                        </div>
                        {{-- Tombol Lihat Semua Berita --}}
                        <div class="text-center mt-10 sm:mt-14">
                            <a href="{{ route('berita.index') }}"
                                class="inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-3 sm:py-4 
                         bg-blue-600 hover:bg-blue-700 text-white text-base sm:text-lg md:text-xl 
                         font-semibold rounded-lg sm:rounded-xl shadow transition-all duration-200 
                         hover:scale-105 hover:shadow-lg">
                                <span>Lihat Berita Lainnya</span>
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="flex justify-center">
                            <div class="text-center text-gray-500 text-sm py-12">
                                Belum ada berita yang tersedia.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</x-layout>
