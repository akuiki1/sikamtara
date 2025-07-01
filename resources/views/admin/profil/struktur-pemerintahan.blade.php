<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="p-6" x-data="{ modalAdd: false, modalView: false, modalEdit: false, modalDelete: false }">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Struktur Pemerintahan Desa Kambat Utara</h2>
            <button 
                @click="modalAdd = true"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Tambah
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-xl shadow">
                <thead>
                    <tr class="bg-gray-100 text-left text-gray-600 text-sm uppercase">
                        <th class="px-6 py-3 border-b">No</th>
                        <th class="px-6 py-3 border-b">Nama</th>
                        <th class="px-6 py-3 border-b">Jabatan</th>
                        <th class="px-6 py-3 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr>
                        <td class="px-6 py-4 border-b">1</td>
                        <td class="px-6 py-4 border-b">Ahmad Syafii</td>
                        <td class="px-6 py-4 border-b">Kepala Desa</td>
                        <td class="px-6 py-4 border-b space-x-2">
                            <button @click="modalView = true" class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded text-sm">Lihat</button>
                            <button @click="modalEdit = true" class="bg-yellow-100 hover:bg-yellow-200 px-3 py-1 rounded text-sm">Edit</button>
                            <button @click="modalDelete = true" class="bg-red-100 hover:bg-red-200 px-3 py-1 rounded text-sm">Hapus</button>
                        </td>
                    </tr>
                    <!-- Tambahkan baris statis lainnya jika perlu -->
                </tbody>
            </table>
        </div>

        <!-- Modals -->
        <!-- Modal Tambah -->
        <div x-show="modalAdd" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-md">
                <h2 class="text-lg font-bold mb-4">Tambah Struktur</h2>
                <p class="text-sm text-gray-600 mb-4">Form tambah akan ditambahkan di sini...</p>
                <button @click="modalAdd = false" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Tutup</button>
            </div>
        </div>

        <!-- Modal Lihat -->
        <div x-show="modalView" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-md">
                <h2 class="text-lg font-bold mb-4">Detail Struktur</h2>
                <p class="text-sm text-gray-600 mb-4">Detail informasi akan ditampilkan di sini...</p>
                <button @click="modalView = false" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Tutup</button>
            </div>
        </div>

        <!-- Modal Edit -->
        <div x-show="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-md">
                <h2 class="text-lg font-bold mb-4">Edit Struktur</h2>
                <p class="text-sm text-gray-600 mb-4">Form edit akan ditambahkan di sini...</p>
                <button @click="modalEdit = false" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Tutup</button>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div x-show="modalDelete" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-md">
                <h2 class="text-lg font-bold mb-4 text-red-600">Hapus Struktur</h2>
                <p class="text-sm text-gray-600 mb-4">Apakah kamu yakin ingin menghapus data ini?</p>
                <div class="flex justify-end space-x-2">
                    <button @click="modalDelete = false" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Batal</button>
                    <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
