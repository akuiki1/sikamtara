<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-10 px-6 text-center">
    </section>
    <header class="bg-white p-8 shadow-md">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Pengumuman Desa Terbaru</h1>
            <p class="text-gray-500 text-lg">Informasi penting untuk warga Desa Kambat Utara, update setiap saat untuk
                kamu!</p>
        </div>
    </header>

    <section class="bg-gray-50 py-6">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row md:justify-between items-center gap-4">
            <div class="flex gap-2">
                <button
                    class="bg-blue-600 text-white px-5 py-2 rounded-full hover:bg-blue-700 transition">Filter</button>
                <button class="text-gray-600 hover:text-blue-600 transition">Clear All</button>
            </div>
            <div class="flex flex-col md:flex-row md:items-center gap-2 w-full md:w-auto">
                <input type="text" placeholder="Cari berita..."
                    class="border border-gray-300 rounded-full px-5 py-2 w-full md:w-80 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <select
                    class="border border-gray-300 rounded-full px-5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option>Urutkan Berdasarkan</option>
                    <option>Terbaru</option>
                    <option>Terpopuler</option>
                </select>
            </div>
        </div>
    </section>


</x-layout>
