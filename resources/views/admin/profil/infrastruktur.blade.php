<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="p-6" x-data="{ modalAdd: false, modalView: false, modalEdit: false, modalDelete: false }">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Infrastruktur Desa Kambat Utara</h2>
            <button 
                @click="modalAdd = true"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Tambah
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-white border rounded-xl shadow p-4 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Jembatan Desa Utara</h3>
                    <p class="text-sm text-gray-600 mt-2">Jembatan penghubung antar dusun, dibangun tahun 2018.</p>
                </div>
                <div class="mt-4 flex space-x-2">
                    <button @click="modalView = true" class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded text-sm">Lihat</button>
                    <button @click="modalEdit = true" class="bg-yellow-100 hover:bg-yellow-200 px-3 py-1 rounded text-sm">Edit</button>
                    <button @click="modalDelete = true" class="bg-red-100 hover:bg-red-200 px-3 py-1 rounded text-sm">Hapus</button>
                </div>
            </div>

            <!-- Card 2 (tambahkan lebih banyak jika perlu) -->
            <div class="bg-white border rounded-xl shadow p-4 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Balai Pertemuan</h3>
                    <p class="text-sm text-gray-600 mt-2">Digunakan untuk rapat dan acara warga desa.</p>
                </div>
                <div class="mt-4 flex space-x-2">
                    <button @click="modalView = true" class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded text-sm">Lihat</button>
                    <button @click="modalEdit = true" class="bg-yellow-100 hover:bg-yellow-200 px-3 py-1 rounded text-sm">Edit</button>
                    <button @click="modalDelete = true" class="bg-red-100 hover:bg-red-200 px-3 py-1 rounded text-sm">Hapus</button>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <!-- Modal Tambah -->
        <div x-show="modalAdd" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-md">
                <h2 class="text-lg font-bold mb-4">Tambah Infrastruktur</h2>
                <p class="text-sm text-gray-600 mb-4">Form tambah akan ditambahkan di sini...</p>
                <button @click="modalAdd = false" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Tutup</button>
            </div>
        </div>

        <!-- Modal Lihat -->
        <div x-show="modalView" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-md">
                <h2 class="text-lg font-bold mb-4">Detail Infrastruktur</h2>
                <p class="text-sm text-gray-600 mb-4">Informasi lengkap akan ditampilkan di sini...</p>
                <button @click="modalView = false" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Tutup</button>
            </div>
        </div>

        <!-- Modal Edit -->
        <div x-show="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-md">
                <h2 class="text-lg font-bold mb-4">Edit Infrastruktur</h2>
                <p class="text-sm text-gray-600 mb-4">Form edit akan ditambahkan di sini...</p>
                <button @click="modalEdit = false" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Tutup</button>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div x-show="modalDelete" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-md">
                <h2 class="text-lg font-bold mb-4 text-red-600">Hapus Infrastruktur</h2>
                <p class="text-sm text-gray-600 mb-4">Apakah kamu yakin ingin menghapus data ini?</p>
                <div class="flex justify-end space-x-2">
                    <button @click="modalDelete = false" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Batal</button>
                    <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
