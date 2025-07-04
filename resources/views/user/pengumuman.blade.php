<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-9 px-6 text-center">
    </section>

    <div class="bg-gray-50 py-8" x-data="{
        show: false,
        detail: {
            id: null,
            judul: '',
            isi: '',
            file_lampiran: '',
            tanggal: '',
            penulis: ''
        },
        pengumuman: @js($dataPengumuman),
        openDetail(id) {
            this.detail = this.pengumuman.find(p => p.id === id) || {};
            this.show = true;
        }
    }">

        <div class="bg-white rounded-xl shadow-lg mx-4 px-6 py-6">
            <!-- Judul Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-gray-800">Pengumuman Desa Terbaru</h1>
                <p class="text-gray-600 text-base mt-1">Informasi penting untuk warga Desa Kambat Utara.</p>
            </div>

            <!-- Daftar Pengumuman -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($pengumuman as $item)
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $item->judul_pengumuman }}</h2>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($item->isi_pengumuman, 25) }}</p>
                        <div class="flex text-gray-500 text-xs mb-2">
                            <p>
                                <span>Ditulis pada
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengumuman)->format('d M Y') }},</span>
                                <span> Oleh {{ $item->user->penduduk->nama }}</span>
                            </p>
                        </div>
                        <x-button @click="openDetail({{ $item->id_pengumuman }})">Detail</x-button>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-8">
                        Tidak ada pengumuman terbaru saat ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Modal Detail -->
        <x-modal show="show">
            <div x-show="detail.judul">
                <div class="mb-4">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-4" x-text="detail.judul"></h1>
                    <img :src="detail.file_lampiran" alt="Lampiran" class="w-full h-auto">
                </div>
                <div class="flex text-gray-600 text-xs">
                    <p>
                        <span>Ditulis pada <span x-text="detail.tanggal"></span>,</span>
                        <span> Oleh <span x-text="detail.penulis"></span></span>
                    </p>
                </div>
                <p class="text-sm text-gray-700 mt-4" x-text="detail.isi"></p>
                <div class="mt-6 border-t pt-4 text-right">
                    <x-button @click="show = false">Tutup</x-button>
                </div>
            </div>
        </x-modal>
    </div>
</x-layout>
