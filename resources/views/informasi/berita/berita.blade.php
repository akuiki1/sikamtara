<x-layout>
    <header class="bg-white p-8 shadow-md">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Berita Desa Terbaru</h1>
            <p class="text-gray-500 text-lg">Info terkini seputar Desa Kambat Utara, update setiap saat untuk kamu!</p>
        </div>
    </header>

    <!-- Filter & Search -->
    <section class="bg-gray-50 py-6">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row md:justify-between items-center gap-4">
            <div class="flex gap-2">
                <button class="bg-blue-600 text-white px-5 py-2 rounded-full hover:bg-blue-700 transition">Filter</button>
                <button class="text-gray-600 hover:text-blue-600 transition">Clear All</button>
            </div>
            <div class="flex flex-col md:flex-row md:items-center gap-2 w-full md:w-auto">
                <input type="text" placeholder="Cari berita..." class="border border-gray-300 rounded-full px-5 py-2 w-full md:w-80 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <select class="border border-gray-300 rounded-full px-5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option>Urutkan Berdasarkan</option>
                    <option>Terbaru</option>
                    <option>Terpopuler</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Grid Berita -->
    <section class="py-10">
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
            @foreach ($berita as $item)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ $item->gambar_cover }}" alt="Gambar Berita" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="font-semibold text-lg text-gray-800 leading-tight line-clamp-2">
                        {{ $item->judul_berita }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-3 line-clamp-3">
                        {{ \Illuminate\Support\Str::limit(strip_tags($item->isi_berita), 100) }}
                    </p>
                    <div class="flex justify-between items-center mt-6 text-xs text-gray-400">
                        <div>
                            <p>{{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d F Y') }}</p>
                            <p>Oleh {{ $item->penulis }}</p>
                        </div>
                        <a href="/informasi/berita/detail/{{ $item->id_berita }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded-full text-sm transition">Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    

    <!-- Pagination -->
    <section class="py-8">
        <div class="flex justify-center items-center gap-2">
            <button class="w-10 h-10 flex items-center justify-center border rounded-full hover:bg-gray-100 transition">&lt;</button>
            <button class="w-10 h-10 flex items-center justify-center border rounded-full bg-green-500 text-white hover:bg-green-600 transition">1</button>
            <button class="w-10 h-10 flex items-center justify-center border rounded-full hover:bg-gray-100 transition">2</button>
            <button class="w-10 h-10 flex items-center justify-center border rounded-full hover:bg-gray-100 transition">3</button>
            <button class="w-10 h-10 flex items-center justify-center border rounded-full hover:bg-gray-100 transition">4</button>
            <button class="w-10 h-10 flex items-center justify-center border rounded-full hover:bg-gray-100 transition">&gt;</button>
        </div>
    </section>
</x-layout>
