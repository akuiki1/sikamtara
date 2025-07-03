<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-9 px-6 text-center">
    </section>

    <div class="bg-gray-50 py-8 px-4">
        <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg px-6 py-8">
            <!-- Judul Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-gray-800">Pengumuman Desa Terbaru</h1>
                <p class="text-gray-600 text-base mt-1">Informasi penting untuk warga Desa Kambat Utara.</p>
            </div>

            <!-- Daftar Pengumuman -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($pengumuman as $item)
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $item->judul_pengumuman }}</h2>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($item->isi_pengumuman, 20) }}</p>
                        <x-button>Detail</x-button>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-8">
                        Tidak ada pengumuman terbaru saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>
