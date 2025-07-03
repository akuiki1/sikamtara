<x-layout>
    <div class="bg-gray-100">

        <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-9 px-6 text-center">
        </section>

        {{-- Sejarah Desa --}}
        <section class="py-16 px-6 md:px-16 bg-gray-50">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Sejarah Desa</h2>
            <p class="text-gray-700 leading-relaxed max-w-3xl mx-auto text-justify">
                {{ $sejarah ? $sejarah->sejarah : 'Sejarah desa belum tersedia.' }}
            </p>
        </section>

        {{-- Visi & Misi --}}
        <section class="py-16 px-6 md:px-16">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Visi & Misi</h2>

            @if ($visimisi)
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Visi -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-bold mb-4 text-green-600">Visi</h3>
                        <p class="text-gray-700">
                            {{ $visimisi->visi }}
                        </p>
                    </div>

                    <!-- Misi -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-bold mb-4 text-green-600">Misi</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-2">
                            @foreach (explode("\n", $visimisi->misi) as $misiItem)
                                <li>{{ $misiItem }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <div class="text-center text-gray-600">
                    <p>Visi dan misi belum tersedia.</p>
                </div>
            @endif
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
        <section class="py-16 px-6 md:px-16 bg-gray-50" x-data="{
            showDetailModal: false,
            selectedStruktur: null
        }">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Struktur Pemerintahan</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @forelse ($strukturPemerintahan as $p)
                    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center cursor-pointer hover:shadow-lg transition"
                        @click="selectedStruktur = {{ $p }}; showDetailModal = true">
                        <div class="w-32 h-32 mb-4">
                            <img src="{{ asset('storage/' . $p->user->foto) }}" alt="{{ $p->user->penduduk->nama }}"
                                class="w-full h-full object-cover rounded-full border-2 border-green-500">
                        </div>
                        <h3 class="text-lg font-bold text-green-600 mb-1">{{ $p->user->penduduk->nama }}</h3>
                        <p class="text-gray-600 text-sm">{{ $p->jabatan }}</p>
                    </div>
                @empty
                    <div class="col-span-full p-4 text-center">
                        <p class="text-gray-500 mb-4">Belum ada struktur pemerintahan.</p>
                    </div>
                @endforelse
            </div>
            <x-modal show="showDetailModal">
                <div class="p-6 text-center">
                    <template x-if="selectedStruktur">
                        <div>
                            <img :src="`/storage/${selectedStruktur.user.foto}`" alt=""
                                class="w-52 h-52 object-cover rounded-xl mx-auto mb-4 border-2 border-green-500">
                            <h3 class="text-lg font-bold text-green-600" x-text="selectedStruktur.user.penduduk.nama">
                            </h3>
                            <p class="text-gray-700 font-semibold mt-2" x-text="selectedStruktur.jabatan"></p>
                            <p class="text-gray-600 mt-2 text-sm justify-items-start"
                                x-text="selectedStruktur.deskripsi">
                            </p>

                            <div class="mt-6 flex justify-center space-x-2 border-t pt-4">
                                <x-button @click="showDetailModal = false" variant="secondary">Tutup</x-button>
                            </div>
                        </div>
                    </template>
                </div>
            </x-modal>
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
