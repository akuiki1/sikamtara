<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-10 px-6 text-center">
    </section>

    <section class="bg-gray-50 pt-6 pb-6">
        <div class="bg-white rounded-xl mx-4 p-6">
            <h1 class="text-2xl font-bold">Berita Desa Terbaru</h1>
            <p class="text-gray-600">Info terkini seputar Desa Kambat Utara, update setiap saat untuk kamu!
            </p>
        </div>
    </section>

    <!-- Grid Berita -->
    <section class="bg-gray-50">
        <div class="bg-white mx-4 mb-6 p-6 rounded-xl shadow-lg">
            {{-- header --}}
            <div class="mb-6">
                <form method="GET" action="{{ route('berita.index') }}">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 w-full">
                        <!-- Input Search with Icon -->
                        <div class="relative w-full md:w-72">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari berita..."
                                class="peer border border-gray-200 bg-white text-sm text-gray-700 placeholder-gray-400 rounded-full pl-11 pr-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full transition-all duration-200" />
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none peer-focus:text-blue-500 transition"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35M17 11a6 6 0 10-12 0 6 6 0 0012 0z" />
                            </svg>
                        </div>


                        <!-- Select Dropdown -->
                        <div class="w-full md:w-auto">
                            <div class="relative">
                                <select name="sort"
                                    class="appearance-none bg-white border border-gray-300 text-gray-700 rounded-full px-5 py-2 pr-10 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition w-full"
                                    onchange="this.form.submit()">
                                    <option value="">Urutkan Berdasarkan</option>
                                    <option value="judul_asc" {{ request('sort') == 'judul_asc' ? 'selected' : '' }}>
                                        Judul A-Z</option>
                                    <option value="judul_desc" {{ request('sort') == 'judul_desc' ? 'selected' : '' }}>
                                        Judul Z-A</option>
                                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru
                                        ke Terlama</option>
                                    <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama
                                        ke Terbaru</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- body --}}
            <div class="max-w-6xl">
                @if ($berita->count())
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
                    </div>
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
        </div>
    </section>
</x-layout>
