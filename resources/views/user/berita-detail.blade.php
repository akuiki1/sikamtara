<x-layout>

    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-9 px-6 text-center">
    </section>

    <section class="bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <a href="{{ route('berita.index') }}"
                    class="inline-flex items-center text-xs md:text-sm lg:text-md text-gray-600 hover:text-blue-600 transition">
                    <!-- Icon panah kiri -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
                <h2 class="text-xl md:text-2xl lg:text-3xl font-semibold text-gray-800 mb-4 mt-8">
                    {{ $berita->judul_berita }}</h2>
                <img src="{{ asset('storage/' . $berita->gambar_cover) }}" alt="Gambar Berita"
                    class="w-full h-64 md:h-80 lg:h-96 object-cover rounded-lg mb-2">
                <p class="text-xs md:sm lg:md text-gray-600 mb-4"> Diterbitkan pada
                    {{ \Carbon\Carbon::parse($berita->tanggal_publish)->translatedFormat('d M Y') }}, Oleh
                    {{ $berita->user->nama }}
                </p>
                <div class="prose prose-lg max-w-none text-gray-800 berita-format">
                    {!! $berita->isi_berita !!}
                </div>
            </div>
        </div>
    </section>
</x-layout>
