<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="p-6" x-data="{ modalEdit: false }">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Sejarah Desa Kambat Utara</h2>
            <button 
                @click="modalEdit = true"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow">
                Edit
            </button>
        </div>

        <div class="bg-white border rounded-xl shadow p-6 text-gray-800 leading-relaxed">
            <p>
                Desa Kambat Utara didirikan pada awal abad ke-20 oleh para pendatang dari wilayah pegunungan yang mencari lahan pertanian subur di dataran rendah. Sejak saat itu, desa berkembang menjadi pusat kegiatan sosial dan ekonomi bagi warga sekitarnya.
            </p>
            <p class="mt-4">
                Seiring waktu, Kambat Utara mengalami banyak perubahan, termasuk pembangunan jalan, sekolah, dan fasilitas umum lainnya. Namun, nilai-nilai gotong royong dan kebersamaan tetap menjadi pondasi utama kehidupan masyarakat desa.
            </p>
        </div>

        <!-- Modal Edit -->
        <div 
            x-show="modalEdit"
            x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div class="bg-white p-6 rounded-xl w-full max-w-2xl">
                <h2 class="text-lg font-bold mb-4">Edit Sejarah Desa</h2>
                <textarea
                    class="w-full h-60 border rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan sejarah desa di sini..."
                >Desa Kambat Utara didirikan pada awal abad ke-20 oleh para pendatang...</textarea>
                <div class="flex justify-end mt-4 space-x-2">
                    <button @click="modalEdit = false" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Batal</button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
