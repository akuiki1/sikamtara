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
                { image: 'img/kantordesa.jpg' },
                { image: 'https://up2date.id/wp-content/uploads/2024/11/noemalisasi.jpg' },
                { image: 'https://totabuan.news/wp-content/uploads/2021/11/182-1822070_pemandangan-alam-indonesia-hd.jpg' }
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
            class="relative w-full h-20 md:h-screen overflow-hidden">
            <!-- Slides Container -->
            <div class="absolute inset-0 flex transition-transform duration-700 ease-in-out"
                :style="`transform: translateX(-${currentSlide * 100}%);`">
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="min-w-full h-40 md:h-screen bg-cover bg-center"
                        :style="`background-image: url(${slide.image})`"></div>
                </template>
            </div>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/70 z-0"></div>

            <!-- Content -->
            <div
                class="relative z-10 hidden md:flex flex-col items-center justify-center h-full text-center text-white px-4">
                <h1 class="text-3xl md:text-6xl font-bold mb-4 drop-shadow-lg">SELAMAT DATANG!</h1>
                <p class="text-base md:text-2xl mb-6 drop-shadow-md">WEBSITE RESMI PEMERINTAH DESA KAMBAT UTARA</p>
                <div class="flex gap-4 flex-wrap justify-center">
                    <a href="#jelajahi"
                        class="bg-yellow-300 hover:bg-yellow-400 text-black font-semibold py-3 px-6 rounded-full transition">
                        Jelajahi sistem desa
                    </a>
                    <a href="#layanan"
                        class="border border-white hover:bg-white hover:text-black font-semibold py-3 px-6 rounded-full transition">
                        Pengajuan layanan online
                    </a>
                </div>
            </div>


            <!-- Arrows -->
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

            <!-- Dots -->
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 hidden md:flex gap-2 z-20">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="goToSlide(index)"
                        :class="{
                            'bg-white scale-110': currentSlide === index,
                            'bg-white/50': currentSlide !== index
                        }"
                        class="w-3 h-3 rounded-full transition duration-300 transform"></button>
                </template>
            </div>
        </section>

        <!-- Section: Jelajahi Sistem Desa -->
        <section id="jelajahi" class="bg-gray-50 py-20 hidden sm:block">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">JELAJAHI SISTEM DESA</h2>
                <p class="text-base md:text-lg text-gray-600 mb-12 max-w-2xl mx-auto">
                    Melalui website ini Anda dapat menjelajahi segala hal yang terkait dengan Desa: pemerintahan,
                    penduduk, demografi, potensi, hingga berita terkini.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @php
                        $items = [
                            [
                                'title' => 'Profil Desa',
                                'url' => '/profil-desa',
                                'icon' =>
                                    '<path d="M10 18v-7"/><path d="M11.12 2.198a2 2 0 0 1 1.76.006l7.866 3.847c.476.233.31.949-.22.949H3.474c-.53 0-.695-.716-.22-.949z"/><path d="M14 18v-7"/><path d="M18 18v-7"/><path d="M3 22h18"/><path d="M6 18v-7"/>',
                            ],
                            [
                                'title' => 'Statistik Penduduk',
                                'url' => '/informasi/kependudukan',
                                'icon' =>
                                    '<path d="M12 16v5"/><path d="M16 14v7"/><path d="M20 10v11"/><path d="m22 3-8.646 8.646a.5.5 0 0 1-.708 0L9.354 8.354a.5.5 0 0 0-.707 0L2 15"/><path d="M4 18v3"/><path d="M8 14v7"/>',
                            ],
                            [
                                'title' => 'Pengumuman Desa',
                                'url' => '/informasi/pengumuman',
                                'icon' =>
                                    '<path d="M15 18h-5"/><path d="M18 14h-8"/><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="10" y="6" rx="1"/>',
                            ],
                            [
                                'title' => 'Keuangan Desa',
                                'url' => '/informasi/apbdes',
                                'icon' =>
                                    '<path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/>',
                            ],
                        ];
                    @endphp

                    @foreach ($items as $item)
                        <a href="{{ $item['url'] }}"
                            class="group block rounded-xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-1 
               p-4 sm:p-5 md:p-6 text-center bg-white">
                            <div class="flex items-center justify-center mb-3 sm:mb-4 md:mb-5">
                                <div
                                    class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-yellow-300 flex items-center justify-center shadow-inner">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-7 sm:h-7 text-gray-800"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        {!! $item['icon'] !!}
                                    </svg>
                                </div>
                            </div>
                            <h3
                                class="text-sm sm:text-base md:text-lg font-semibold text-gray-800 group-hover:text-yellow-300 transition-colors">
                                {{ $item['title'] }}
                            </h3>
                        </a>
                    @endforeach

                </div>
            </div>
        </section>

        <!-- Section: Layanan Administrasi -->
        <section id="layanan" class="bg-gray-100 py-20">
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
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6 sm:gap-10">


                    {{-- Card 1 - LAYANAN ONLINE --}}
                    <div
                        class="bg-gradient-to-tr from-blue-400 to-blue-600 rounded-3xl shadow-xl p-8 flex flex-col hover:scale-105 transform transition duration-300 ease-in-out">
                        <div class="flex flex-col items-center text-center">
                            {{-- Icon --}}
                            <div class="bg-white p-4 rounded-full shadow-md mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-3-9v18m8-9H5" />
                                </svg>
                            </div>
                            {{-- Title --}}
                            <h3 class="text-2xl font-bold text-white mb-4">LAYANAN ONLINE</h3>
                            {{-- Description --}}
                            <p class="hidden sm:block text-white/90 mb-6">
                                Ajukan berbagai surat administrasi seperti surat keterangan, domisili, usaha, dan
                                lainnya
                                dengan praktis tanpa antri.
                            </p>
                            {{-- CTA --}}
                            <a href="{{ route('administrasi') }}"
                                class="inline-block bg-white text-blue-600 font-bold py-2 px-4 text-sm sm:py-3 sm:px-6 sm:text-base rounded-full shadow hover:bg-blue-100 transition-all duration-300">
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 5.636L5.636 18.364M5.636 5.636l12.728 12.728" />
                                </svg>
                            </div>
                            {{-- Title --}}
                            <h3 class="text-2xl font-bold text-white mb-4">PENGADUAN ONLINE</h3>
                            {{-- Description --}}
                            <p class="hidden sm:block text-white/90 mb-6">
                                Sampaikan keluhan, aspirasi, atau masukan kepada perangkat desa secara cepat,
                                transparan,
                                dan tuntas.
                            </p>
                            {{-- CTA --}}
                            <a href="{{ route('pengaduan') }}"
                                class="inline-block bg-white text-yellow-600 font-bold py-2 px-4 text-sm sm:py-3 sm:px-6 sm:text-base rounded-full shadow hover:bg-yellow-100 transition-all duration-300">
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
                            @foreach ($daftarTahun as $item)
                                <option value="{{ $item->id_tahun_anggaran }}"
                                    {{ $item->id_tahun_anggaran == $tahun->id_tahun_anggaran ? 'selected' : '' }}>
                                    {{ $item->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                {{-- Kartu Ringkasan --}}
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    {{-- Pendapatan --}}
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-6 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div class="rounded-xl bg-emerald-100 p-3 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 1.567-3 3.5S10.343 15 12 15s3-1.567 3-3.5S13.657 8 12 8z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v2m0 14v2m7-7h2M3 12H5" />
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
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-6 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div class="rounded-xl bg-rose-100 p-3 text-rose-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 14l2-2 4 4M7 10h10M5 6h14M7 18h10" />
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
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-6 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div class="rounded-xl bg-indigo-100 p-3 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h11M9 21V3m7 8h5M17 3v18" />
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
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-6 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div class="rounded-xl bg-violet-100 p-3 text-violet-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
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
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-6 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div class="rounded-xl bg-amber-100 p-3 text-amber-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 1.567-3 3.5S10.343 15 12 15s3-1.567 3-3.5S13.657 8 12 8z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v2m0 14v2m7-7h2M3 12H5" />
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


                {{-- Tombol Keuangan --}}
                <div class="mt-8">
                    <a href="{{ route('user.keuangan') }}"
                        class="inline-flex justify-center items-center px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white text-xl font-semibold rounded-xl shadow transition-all duration-200 hover:scale-105 hover:shadow-lg">
                        Lihat Detail Keuangan
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
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
                    @else
                        <div class="text-center text-gray-500 text-sm py-12">
                            Belum ada berita yang tersedia.
                        </div>
                    @endif

                    {{-- Pagination --}}
                    <div class="mt-6 flex">
                        {{ $berita->links() }}
                    </div>
                </div>

                {{-- Tombol Lihat Semua Berita --}}
                <div class="text-center mt-8">
                    <a href="{{ route('berita.index') }}"
                        class="inline-flex justify-center items-center px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white text-xl font-semibold rounded-xl shadow transition-all duration-200 hover:scale-105 hover:shadow-lg">
                        Lihat Berita Lainnya
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-layout>
