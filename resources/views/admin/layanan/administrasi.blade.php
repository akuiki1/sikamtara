<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div x-data="{ 
        modalTambah: false, 
        modalEdit: false, 
        modalHapus: false, 
        modalDetail: false, 
        modalLihat: false, 
        modalTtd: false 
    }" class="p-6 space-y-10">

        <!-- Header dan Tombol Tambah -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-800">Layanan Administrasi</h1>
            <button @click="modalTambah = true" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-2xl shadow">
                + Tambah
            </button>
        </div>

        <!-- Card: Daftar Layanan -->
        <div class="bg-white shadow-md rounded-2xl p-6 space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Daftar Layanan</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="py-3 px-4">#</th>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Deskripsi</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Surat Domisili</td>
                            <td class="py-3 px-4">Untuk kebutuhan alamat domisili</td>
                            <td class="py-3 px-4 space-x-2">
                                <button @click="modalLihat = true" class="text-blue-600 hover:underline">Lihat</button>
                                <button @click="modalEdit = true" class="text-yellow-500 hover:underline">Edit</button>
                                <button @click="modalHapus = true" class="text-red-500 hover:underline">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card: Pengajuan Masuk -->
        <div class="bg-white shadow-md rounded-2xl p-6 space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Pengajuan Masuk</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Layanan</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="py-3 px-4">Budi</td>
                            <td class="py-3 px-4">Surat Domisili</td>
                            <td class="py-3 px-4">2025-05-08</td>
                            <td class="py-3 px-4">
                                <button @click="modalDetail = true" class="text-blue-600 hover:underline">Detail</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card: Siap Ditandatangani -->
        <div class="bg-white shadow-md rounded-2xl p-6 space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Siap Ditandatangani</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Layanan</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="py-3 px-4">Siti</td>
                            <td class="py-3 px-4">Surat Usaha</td>
                            <td class="py-3 px-4">2025-05-07</td>
                            <td class="py-3 px-4">
                                <button @click="modalTtd = true" class="text-green-600 hover:underline">Tandatangani</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card: Riwayat -->
        <div class="bg-white shadow-md rounded-2xl p-6 space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Riwayat</h2>
            <div class="flex flex-wrap gap-4">
                <input type="text" placeholder="Cari nama..." class="w-full md:w-1/3 border rounded-xl p-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300" />
                <select class="w-full md:w-1/4 border rounded-xl p-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option>Status</option>
                    <option>Selesai</option>
                    <option>Ditolak</option>
                </select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700 mt-4">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Layanan</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="py-3 px-4">Andi</td>
                            <td class="py-3 px-4">Surat Domisili</td>
                            <td class="py-3 px-4 text-green-600">Selesai</td>
                            <td class="py-3 px-4">2025-05-01</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah (Contoh satu saja dulu) -->
        <div x-show="modalTambah" x-cloak class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl w-full max-w-xl p-6 shadow-lg">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Tambah Layanan Baru</h3>
                <input type="text" placeholder="Nama Layanan" class="w-full border p-2 rounded-xl mb-4 focus:ring-2 focus:ring-blue-300" />
                <textarea placeholder="Deskripsi" class="w-full border p-2 rounded-xl mb-4 focus:ring-2 focus:ring-blue-300"></textarea>
                <div class="flex justify-end space-x-3">
                    <button @click="modalTambah = false" class="px-4 py-2 bg-gray-100 rounded-xl hover:bg-gray-200">Batal</button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div x-show="modalDetail" x-cloak class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-lg">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Detail Layanan</h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <p><strong>Nama Layanan:</strong> Surat Keterangan Domisili</p>
                    <p><strong>Deskripsi:</strong> Surat untuk keperluan domisili warga secara administratif.</p>
                    <p><strong>Dibuat oleh:</strong> Admin Desa</p>
                    <p><strong>Tanggal dibuat:</strong> 8 Mei 2025</p>
                </div>
                <div class="flex justify-end mt-6">
                    <button @click="modalDetail = false" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Tutup</button>
                </div>
            </div>
        </div>
        
        <!-- Modal Lihat -->
        <div x-show="modalLihat" x-cloak class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-lg">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Detail Layanan</h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <p><strong>Nama Layanan:</strong> Surat Keterangan Domisili</p>
                    <p><strong>Deskripsi:</strong> Surat untuk keperluan domisili warga secara administratif.</p>
                    <p><strong>Dibuat oleh:</strong> Admin Desa</p>
                    <p><strong>Tanggal dibuat:</strong> 8 Mei 2025</p>
                </div>
                <div class="flex justify-end mt-6">
                    <button @click="modalLihat = false" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Tutup</button>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div x-show="modalEdit" x-cloak class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl w-full max-w-xl p-6 shadow-lg">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Edit Layanan</h3>
                <input type="text" placeholder="Nama Layanan" value="Surat Keterangan Domisili" class="w-full border p-2 rounded-xl mb-4 focus:ring-2 focus:ring-yellow-300" />
                <textarea placeholder="Deskripsi" class="w-full border p-2 rounded-xl mb-4 focus:ring-2 focus:ring-yellow-300">Surat untuk keperluan domisili warga</textarea>
                <div class="flex justify-end space-x-3">
                    <button @click="modalEdit = false" class="px-4 py-2 bg-gray-100 rounded-xl hover:bg-gray-200">Batal</button>
                    <button class="px-4 py-2 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600">Perbarui</button>
                </div>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div x-show="modalHapus" x-cloak class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-lg">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Hapus Layanan</h3>
                <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus layanan <strong>"Surat Keterangan Domisili"</strong>? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex justify-end space-x-3">
                    <button @click="modalHapus = false" class="px-4 py-2 bg-gray-100 rounded-xl hover:bg-gray-200">Batal</button>
                    <button class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700">Hapus</button>
                </div>
            </div>
        </div>
        
        <!-- Modal Hapus -->
        <div x-show="modalTtd" x-cloak class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-lg">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Tanda Tangan Pengajuan</h3>
                <p class="text-gray-700 mb-4">Pastikan semua informasi telah diperiksa sebelum menandatangani pengajuan layanan <strong>"Surat Keterangan Domisili"</strong> atas nama <strong>Budi Santoso</strong>.</p>
        
                <div class="border rounded-lg p-4 mb-4 text-gray-600 bg-gray-50">
                    <p><strong>Status:</strong> Menunggu Persetujuan</p>
                    <p><strong>Tanggal Pengajuan:</strong> 7 Mei 2025</p>
                </div>
        
                <div class="flex justify-end space-x-3">
                    <button @click="modalTtd = false" class="px-4 py-2 bg-gray-100 rounded-xl hover:bg-gray-200">Batal</button>
                    <button class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700">Tanda Tangani</button>
                </div>
            </div>
        </div>        
    </div>
</x-admin-layout>
