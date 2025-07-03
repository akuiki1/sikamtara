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
                    <div class="text-3xl font-bold text-green-600">{{ $penduduk }}</div>
                    <div class="text-gray-600 mt-2">Jumlah Penduduk</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $jumlahRt }}</div>
                    <div class="text-gray-600 mt-2">Jumlah RT</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $jumlahRw }}</div>
                    <div class="text-gray-600 mt-2">Jumlah RW</div>
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

        {{-- Program Pembangunan Desa --}}
        <section class="py-16 px-6 md:px-16 bg-gray-50">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Program Pembangunan Desa</h2>

            @if ($programs->isEmpty())
                <p class="text-center text-gray-600">Belum ada program pembangunan yang tercatat.</p>
            @else
                <div class="space-y-6 max-w-4xl mx-auto text-justify">
                    @foreach ($programs as $program)
                        <div class="bg-white shadow-md rounded-lg p-6 space-y-2">
                            <h3 class="text-xl font-bold text-green-700">{{ $program->nama_program }}</h3>
                            <p class="text-sm text-gray-500">{{ $program->jenis_program }} — {{ $program->lokasi }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <strong>Periode:</strong>
                                {{ \Carbon\Carbon::parse($program->tanggal_mulai)->format('d M Y') }} -
                                {{ \Carbon\Carbon::parse($program->tanggal_selesai)->format('d M Y') }}
                            </p>
                            <p class="text-sm text-gray-600"><strong>Anggaran:</strong>
                                Rp{{ number_format($program->anggaran, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-600"><strong>Sumber Dana:</strong> {{ $program->sumber_dana }}
                            </p>
                            <p class="text-sm text-gray-600"><strong>Penanggung Jawab:</strong>
                                {{ $program->penanggung_jawab }}</p>
                            <p class="text-sm text-gray-600"><strong>Status:</strong> {{ $program->status }}</p>
                            <p class="text-gray-700 mt-2">{{ $program->deskripsi }}</p>
                            @if ($program->foto_dokumentasi)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $program->foto_dokumentasi) }}"
                                        alt="Foto Program" class="rounded shadow max-w-full h-auto">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-layout>
