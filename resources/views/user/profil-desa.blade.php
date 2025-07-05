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

        <section class="py-20 px-6 md:px-16 bg-gray-50">
            <!-- Judul -->
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">Data Wilayah</h2>

            <!-- Statistik Wilayah -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-6xl mx-auto mb-16">
                <div
                    class="text-center bg-white rounded-xl p-6 shadow transition hover:shadow-lg duration-300">
                    <div class="text-2xl font-bold text-green-600">6.5 <span class="text-sm align-super">Km</span>
                    </div>
                    <div class="text-gray-500 mt-2">Luas Wilayah</div>
                </div>
                <div
                    class="text-center bg-white rounded-xl p-6 shadow transition hover:shadow-lg duration-300">
                    <div class="text-2xl font-bold text-green-600">{{ number_format($penduduk) }}</div>
                    <div class="text-gray-500 mt-2">Jumlah Penduduk</div>
                </div>
                <div
                    class="text-center bg-white rounded-xl p-6 shadow transition hover:shadow-lg duration-300">
                    <div class="text-2xl font-bold text-green-600">3</div>
                    <div class="text-gray-500 mt-2">Jumlah Dusun</div>
                </div>
                <div
                    class="text-center bg-white rounded-xl p-6 shadow transition hover:shadow-lg duration-300">
                    <div class="text-2xl font-bold text-green-600">8</div>
                    <div class="text-gray-500 mt-2">RT/RW</div>
                </div>
            </div>

            <!-- Demografi Desa -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto items-start">
                <!-- Batas Wilayah -->
                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Demografi Desa</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-xl p-5 text-center shadow hover:shadow-md transition">
                            <div class="text-green-700 font-bold text-lg">Utara</div>
                            <div class="text-gray-600 text-sm">Desa Awang</div>
                        </div>
                        <div class="bg-white rounded-xl p-5 text-center shadow hover:shadow-md transition">
                            <div class="text-green-700 font-bold text-lg">Selatan</div>
                            <div class="text-gray-600 text-sm">Desa Kambat Selatan</div>
                        </div>
                        <div class="bg-white rounded-xl p-5 text-center shadow hover:shadow-md transition">
                            <div class="text-green-700 font-bold text-lg">Barat</div>
                            <div class="text-gray-600 text-sm">Desa Setiap</div>
                        </div>
                        <div class="bg-white rounded-xl p-5 text-center shadow hover:shadow-md transition">
                            <div class="text-green-700 font-bold text-lg">Timur</div>
                            <div class="text-gray-600 text-sm">Desa Hilir Banua</div>
                        </div>
                    </div>
                </div>

                <!-- Peta -->
                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 text-center md:text-left">Peta
                        Lokasi Desa</h2>
                    <div class="rounded-xl overflow-hidden shadow">
                        <iframe class="w-full h-64 md:h-80"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30310.09139579498!2d115.31917278882365!3d-2.5119143378588986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de56a788be0f17f%3A0x5eb3706f97864e42!2sKambat%20Utara%2C%20Pandawan%2C%20Central%20Hulu%20Sungai%20Regency%2C%20South%20Kalimantan!5e1!3m2!1sen!2sid!4v1745651831702!5m2!1sen!2sid"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>

        {{-- Struktur Pemerintahan --}}
        <section class="py-16 px-6 md:px-16 bg-gray-50" x-data="{
            showDetailModal: false,
            selectedStruktur: null
        }">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Struktur Pemerintahan</h2>

            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @forelse ($strukturPemerintahan as $p)
                    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center cursor-pointer hover:shadow-lg transition"
                        @click="selectedStruktur = {{ $p }}; showDetailModal = true">
                        <div class="w-32 h-32 mb-4">
                            <img src="{{ optional($p->user)->foto ? asset('storage/' . $p->user->foto) : asset('img/default-avatar.jpg') }}"
                                alt="{{ optional($p->user->penduduk)->nama }}"
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
                            <img :src="selectedStruktur.user.foto ?
                                `/storage/${selectedStruktur.user.foto}` :
                                '/img/default-avatar.jpg'"
                                alt=""
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

        {{-- Program Pembangunan Desa --}}
        <section class="py-16 px-6 md:px-16 bg-gray-50" x-data="{ showDetail: false, selectedProgram: null }">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Program Pembangunan Desa</h2>

            @if ($programs->isEmpty())
                <p class="text-center text-gray-600">Belum ada program pembangunan yang tercatat.</p>
            @else
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($programs as $program)
                            <div @click="selectedProgram = {{ $program->toJson() }}; showDetail = true"
                                class="relative w-full h-96 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 hover:scale-[1.01] cursor-pointer">
                                {{-- Gambar latar --}}

                                @if ($program->foto_dokumentasi)
                                    <img src="{{ asset('storage/' . $program->foto_dokumentasi) }}" alt="Foto Program"
                                        class="absolute inset-0 w-full h-full object-cover" />
                                @endif
                                {{-- Overlay gelap --}}
                                <div class="absolute inset-x-0 bottom-0 h-full bg-gradient-to-b from-black/5 to-black">
                                </div>
                                {{-- Badge Status --}}
                                <div class="absolute top-4 right-4">
                                    <span
                                        class="px-3 py-1 rounded-lg text-xs font-medium
                                        {{ $program->status === 'selesai'
                                            ? 'bg-green-100 text-green-700'
                                            : ($program->status === 'pelaksanaan'
                                                ? 'bg-yellow-100 text-yellow-700'
                                                : ($program->status === 'batal'
                                                    ? 'bg-red-100 text-red-700'
                                                    : 'bg-gray-100 text-gray-700')) }}">
                                        {{ ucfirst($program->status) }}
                                    </span>
                                </div>

                                {{-- Konten teks --}}
                                <div class="absolute bottom-7 left-6 right-6 text-white space-y-1">
                                    <h2 class="text-lg font-bold leading-snug">{{ $program->nama_program }}</h2>
                                    <p class="text-xs font-semibold">
                                        Periode
                                        {{ \Carbon\Carbon::parse($program->tanggal_mulai)->format('d M Y') }} -
                                        {{ \Carbon\Carbon::parse($program->tanggal_selesai)->format('d M Y') }}
                                    </p>
                                    <p class="text-xs leading-normal line-clamp-2">
                                        {{ $program->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Modal Detail Program -->
            <x-modal show="showDetail" title="Detail Program Pembangunan">
                <div class="p-6">
                    <template x-if="selectedProgram">
                        <div class="space-y-4 text-left">
                            <!-- Judul -->
                            <h3 class="text-lg font-bold text-green-700" x-text="selectedProgram.nama_program"></h3>
                            <p class="text-xs text-gray-500 mb-2"
                                x-text="selectedProgram.jenis_program + ' &mdash; ' + selectedProgram.lokasi">
                            </p>
                            <!-- Status -->
                            <span class="text-[10px] px-2 py-1 rounded-full font-medium whitespace-nowrap"
                                :class="{
                                    'bg-green-100 text-green-700': selectedProgram.status === 'selesai',
                                    'bg-yellow-100 text-yellow-700': selectedProgram.status === 'pelaksanaan',
                                    'bg-red-100 text-red-700': selectedProgram.status === 'batal',
                                    'bg-gray-100 text-gray-700': selectedProgram.status === 'lainnya'
                                }"
                                x-text="selectedProgram.status.charAt(0).toUpperCase() + selectedProgram.status.slice(1)">
                            </span>
                            <!-- Periode -->
                            <p class="text-xs text-gray-600">
                                <span class="font-semibold">Periode:</span><br>
                                <span
                                    x-text="new Date(selectedProgram.tanggal_mulai).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })"></span>
                                -
                                <span
                                    x-text="new Date(selectedProgram.tanggal_selesai).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })"></span>
                            </p>
                            <!-- Anggaran -->
                            <p class="text-xs text-gray-600">
                                <span class="font-semibold">Anggaran:</span><br>
                                <span
                                    x-text="'Rp' + new Intl.NumberFormat('id-ID').format(selectedProgram.anggaran)"></span>
                            </p>
                            <!-- Sumber Dana -->
                            <p class="text-xs text-gray-600">
                                <span class="font-semibold">Sumber Dana:</span><br>
                                <span x-text="selectedProgram.sumber_dana"></span>
                            </p>
                            <!-- Penanggung Jawab -->
                            <p class="text-xs text-gray-600">
                                <span class="font-semibold">Penanggung Jawab:</span><br>
                                <span x-text="selectedProgram.penanggung_jawab"></span>
                            </p>
                            <!-- Deskripsi -->
                            <div x-show="selectedProgram.deskripsi" class="text-sm text-gray-700">
                                <span class="font-semibold text-gray-600">Deskripsi:</span>
                                <p class="mt-1 leading-snug line-clamp-3 break-words"
                                    x-text="selectedProgram.deskripsi"></p>
                            </div>
                            <!-- Foto Dokumentasi -->
                            <div x-show="selectedProgram.foto_dokumentasi" class="mt-3">
                                <img :src="`/storage/${selectedProgram.foto_dokumentasi}`" alt="Foto Dokumentasi"
                                    class="rounded-md shadow-sm w-full h-32 object-cover">
                            </div>
                            <!-- Actions -->
                            <div class="mt-6 flex justify-center space-x-2 border-t pt-4">
                                <x-button @click="showDetail = false" variant="secondary">Tutup</x-button>
                            </div>
                        </div>
                    </template>
                </div>
            </x-modal>
        </section>
    </div>
</x-layout>
