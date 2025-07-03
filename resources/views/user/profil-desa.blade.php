<x-layout>
    <div class="bg-gray-100">

        <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-9 px-6 text-center">
        </section>

        {{-- Sejarah Desa --}}
        <section class="py-16 px-6 md:px-16 bg-gray-50">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Sejarah Desa</h2>
            <p class="text-gray-700 leading-relaxed max-w-3xl mx-auto text-justify">
                Desa Kambat Utara berdiri sejak tahun 1950 dan telah mengalami berbagai perkembangan. Dulu dikenal
                sebagai perkampungan kecil dengan pertanian sebagai penghidupan utama...
            </p>
        </section>

        {{-- Visi & Misi --}}
        <section class="py-16 px-6 md:px-16">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Visi & Misi</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4 text-green-600">Visi</h3>
                    <p class="text-gray-700">Menjadi desa mandiri, berdaya saing, dan sejahtera melalui pembangunan
                        berbasis partisipasi masyarakat dan potensi lokal.</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4 text-green-600">Misi</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Mengembangkan potensi ekonomi lokal</li>
                        <li>Meningkatkan kualitas pendidikan dan kesehatan</li>
                        <li>Mendorong partisipasi aktif masyarakat</li>
                        <li>Menjaga kelestarian lingkungan dan budaya lokal</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- Data Wilayah --}}
        <section class="py-16 px-6 md:px-16 bg-gray-50">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Data Wilayah</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-5xl mx-auto">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-3xl font-bold text-green-600">2.100 Ha</div>
                    <div class="text-gray-600 mt-2">Luas Wilayah</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-3xl font-bold text-green-600">1.872</div>
                    <div class="text-gray-600 mt-2">Jumlah Penduduk</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-3xl font-bold text-green-600">3</div>
                    <div class="text-gray-600 mt-2">Jumlah Dusun</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-3xl font-bold text-green-600">8</div>
                    <div class="text-gray-600 mt-2">RT/RW</div>
                </div>
            </div>
        </section>

        {{-- Peta Lokasi --}}
        <section class="py-16 px-6 md:px-16">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Peta Lokasi Desa</h2>
            <div class="max-w-5xl mx-auto rounded-lg overflow-hidden shadow">
                <iframe class="w-full h-64 md:h-96"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30310.09139579498!2d115.31917278882365!3d-2.5119143378588986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de56a788be0f17f%3A0x5eb3706f97864e42!2sKambat%20Utara%2C%20Pandawan%2C%20Central%20Hulu%20Sungai%20Regency%2C%20South%20Kalimantan!5e1!3m2!1sen!2sid!4v1745651831702!5m2!1sen!2sid"
                    style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </section>

        {{-- Struktur Pemerintahan --}}
        <section class="py-16 px-6 md:px-16 bg-gray-50">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Struktur Pemerintahan</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @forelse ($strukturPemerintahan as $p)
                    <div x-data="{ open: false }"
                        class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center cursor-pointer hover:shadow-lg transition"
                        @click="open = true">
                        <div class="w-32 h-32 mb-4">
                            <img src="{{ asset('storage/' . $p->user->foto) }}"
                                alt="Foto {{ $p->user->penduduk->nama }}"
                                class="w-full h-full object-cover rounded-full border-2 border-green-500">
                        </div>
                        <h3 class="text-lg font-bold text-green-600 mb-1">{{ $p->user->penduduk->nama }}</h3>
                        <p class="text-gray-600 text-sm">{{ $p->jabatan }}</p>

                        {{-- Modal --}}
                        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                            x-show="open" x-transition @click.away="open = false">
                            <div class="bg-white rounded-xl shadow-lg p-6 w-11/12 max-w-md" @click.stop>
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-xl font-semibold text-green-600">{{ $p->nama }}</h4>
                                    <button @click="open = false"
                                        class="text-gray-400 hover:text-gray-600">&times;</button>
                                </div>
                                <img src="{{ asset('storage/' . $p->user->foto) }}" alt="{{ $p->user->penduduk->nama }}"
                                    class="w-24 h-24 object-cover rounded-full mx-auto mb-4 border-2 border-green-500">
                                <p class="text-gray-700 mb-2 font-semibold">{{ $p->jabatan }}</p>
                                <p class="text-gray-600 text-sm">{{ $p->deskripsi }}</p>
                                <button @click="open = false"
                                    class="mt-4 w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">Tutup</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center">
                        <div class="w-32 h-32 mb-4 flex items-center justify-center bg-gray-200 rounded-full">
                            <span class="text-gray-500">Tidak ada data</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Dasar Hukum --}}
        <section class="py-16 px-6 md:px-16 bg-white">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Dasar Hukum</h2>
            <p class="text-gray-700 leading-relaxed max-w-3xl mx-auto text-justify mb-4">
                Peraturan Desa Kambat Utara berdasarkan keputusan rapat desa dan peraturan daerah yang berlaku.
                Untuk informasi lebih lanjut, Anda dapat mengunduh dokumen peraturan desa di bawah ini.
            </p>
            <div class="flex justify-center">
                <a href="link-ke-peraturan-desa.pdf"
                    class="inline-block bg-green-600 text-white py-2 px-6 rounded-full hover:bg-green-700 transition">Unduh
                    Peraturan Desa</a>
            </div>
        </section>

        {{-- Tujuan Penyusunan Website --}}
        <section class="py-16 px-6 md:px-16">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Tujuan Penyusunan Website</h2>
            <p class="text-gray-700 leading-relaxed max-w-3xl mx-auto text-justify">
                Website ini dibangun untuk memberikan akses informasi yang lebih mudah dan transparan mengenai kegiatan
                dan program pembangunan di Desa Kambat Utara. Tujuan utamanya adalah untuk mempermudah komunikasi antara
                pemerintahan desa dan warga, serta mempromosikan potensi desa ke dunia luar.
            </p>
        </section>

        {{-- Data Kependudukan --}}
        <section class="py-16 px-6 md:px-16 bg-gray-50">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Data Kependudukan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-lg rounded-lg">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="py-3 px-6 text-left">No</th>
                            <th class="py-3 px-6 text-left">Deskripsi</th>
                            <th class="py-3 px-6 text-left">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr>
                            <td class="py-3 px-6">1</td>
                            <td class="py-3 px-6">Jumlah Penduduk</td>
                            <td class="py-3 px-6">1,872</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-6">2</td>
                            <td class="py-3 px-6">Jumlah Kepala Keluarga</td>
                            <td class="py-3 px-6">450</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-6">3</td>
                            <td class="py-3 px-6">Distribusi Gender</td>
                            <td class="py-3 px-6">Laki-laki: 900, Perempuan: 972</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Strategi dan Arah Kebijakan Desa --}}
        <section class="py-16 px-6 md:px-16">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Strategi dan Arah Kebijakan Desa</h2>
            <div class="space-y-6 max-w-3xl mx-auto text-justify">
                <p class="text-gray-700">
                    Strategi kebijakan desa mencakup peningkatan kualitas pendidikan, kesehatan, dan ekonomi lokal
                    melalui
                    penguatan infrastruktur dan pemberdayaan masyarakat. Kami juga berfokus pada pelestarian lingkungan
                    dan
                    budaya lokal.
                </p>
                <p class="text-gray-700">
                    Arah kebijakan ini bertujuan untuk menciptakan desa yang mandiri, berdaya saing, dan mampu
                    menghadapi
                    tantangan global.
                </p>
            </div>
        </section>

        {{-- Program Pembangunan Desa --}}
        <section class="py-16 px-6 md:px-16 bg-gray-50">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Program Pembangunan Desa</h2>
            <div class="space-y-6 max-w-3xl mx-auto text-justify">
                <ul class="list-disc list-inside text-gray-700">
                    <li>Pembangunan jalan desa untuk meningkatkan akses transportasi.</li>
                    <li>Peningkatan fasilitas pendidikan dan kesehatan di desa.</li>
                    <li>Program pemberdayaan ekonomi lokal melalui pelatihan keterampilan.</li>
                    <li>Penanaman pohon dan pemeliharaan lingkungan untuk menjaga kelestarian alam.</li>
                </ul>
            </div>
        </section>


        {{-- CTA Kontak --}}
        {{-- <section class="py-16 px-6 md:px-16 bg-green-600 text-white text-center">
            <h2 class="text-2xl md:text-3xl font-semibold mb-4">Kunjungi atau Hubungi Kami</h2>
            <p class="mb-6">Kantor Desa Kambat Utara - Jl. Raya Pandawan KM. 5, Hulu Sungai Tengah</p>
            <a href="#"
                class="inline-block bg-white text-green-600 font-semibold px-6 py-3 rounded-full shadow hover:bg-gray-100 transition">Hubungi
                Sekarang</a>
        </section> --}}

    </div>
</x-layout>
