<x-admin-layout>
    <x-slot:title>Layanan Pengaduan</x-slot>

    <div class="p-6" x-data="{
        search: '',
        filter: '',
        tambahModal: '',
        openModal: '',
        editModal: '',
        hapusModal: '',
        complaints: [
            { id: 1, nama: 'Budi Santoso', judul: 'Jalan rusak', status: 'Diproses' },
            { id: 2, nama: 'Siti Aminah', judul: 'Lampu mati', status: 'Selesai' },
            { id: 3, nama: 'Joko Widodo', judul: 'Banjir', status: 'Diproses' },
            { id: 4, nama: 'Ani Rahmawati', judul: 'Sampah menumpuk', status: 'Ditolak' },
        ],
        get filteredComplaints() {
            return this.complaints.filter(item => {
                const matchesSearch = item.nama.toLowerCase().includes(this.search.toLowerCase()) ||
                    item.judul.toLowerCase().includes(this.search.toLowerCase());
                const matchesFilter = this.filter === '' || item.status === this.filter;
                return matchesSearch && matchesFilter;
            });
        }
    }">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">Daftar Pengaduan</h2>
            <button @click="tambahModal = 'tambah'" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Pengaduan
            </button>
        </div>

        <!-- Search & Filter -->
        <div class="flex flex-col md:flex-row gap-4 mb-4">
            <div class="relative">
                <input type="text" placeholder="Cari nama atau judul..." x-model="search"
                    class="w-full md:w-80 pl-10 border border-gray-300 rounded-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">

                <svg class="w-6 h-6 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>
            </div>


            <select x-model="filter"
                class="w-full md:w-1/4 border border-gray-300 rounded-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                <option value="">Semua Status</option>
                <option value="Diproses">Diproses</option>
                <option value="Selesai">Selesai</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700"></th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Judul Pengaduan</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" x-show="filteredComplaints.length > 0">
                    <template x-for="item in filteredComplaints" :key="item.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-800" x-text="item.id"></td>
                            <td class="px-6 py-4 text-sm text-gray-800" x-text="item.nama"></td>
                            <td class="px-6 py-4 text-sm text-gray-800" x-text="item.judul"></td>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold"
                                    :class="{
                                        'bg-yellow-100 text-yellow-800': item.status === 'Diproses',
                                        'bg-green-100 text-green-800': item.status === 'Selesai',
                                        'bg-red-100 text-red-800': item.status === 'Ditolak'
                                    }"
                                    x-text="item.status"></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center space-x-2">
                                <button @click="openModal = 'detail'; selectedComplaint = item"
                                    class="text-blue-500 hover:underline">Lihat</button>
                                <button @click="editModal = 'edit'; selectedComplaint = item"
                                    class="text-yellow-500 hover:underline">Edit</button>
                                <button @click="hapusModal = 'hapus'; selectedComplaint = item"
                                    class="text-red-500 hover:underline">Hapus</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
                <tbody x-show="filteredComplaints.length === 0">
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- tambahModal -->
        <template x-if="tambahModal !== ''">
            <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold capitalize" x-text="tambahModal + ' Pengaduan'"></h3>
                        <button @click="tambahModal = ''"
                            class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
                    </div>
                    <div>
                        <form>
                            <div class="mb-4">
                                <label class="block text-sm mb-1">Nama</label>
                                <input type="text" class="w-full border px-3 py-2 rounded"
                                    placeholder="Nama pengadu">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm mb-1">Judul Pengaduan</label>
                                <input type="text" class="w-full border px-3 py-2 rounded"
                                    placeholder="Judul laporan">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm mb-1">Deskripsi</label>
                                <textarea class="w-full border px-3 py-2 rounded" placeholder="Isi pengaduan"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
                                    @click="tambahModal = ''">Batal</button>
                                <button type="button"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>

        <!-- editModal -->
        <template x-if="editModal !== ''">
            <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold capitalize" x-text="editModal + ' Pengaduan'"></h3>
                        <button @click="editModal = ''"
                            class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
                    </div>
                    <div>
                        <form>
                            <div class="mb-4">
                                <label class="block text-sm mb-1">Nama</label>
                                <input type="text" class="w-full border px-3 py-2 rounded"
                                    placeholder="Nama pengadu">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm mb-1">Judul Pengaduan</label>
                                <input type="text" class="w-full border px-3 py-2 rounded"
                                    placeholder="Judul laporan">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm mb-1">Deskripsi</label>
                                <textarea class="w-full border px-3 py-2 rounded" placeholder="Isi pengaduan"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
                                    @click="editModal = ''">Batal</button>
                                <button type="button"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>

        <!-- lihatModal -->
        <template x-if="openModal !== ''">
            <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold capitalize" x-text="openModal + ' Pengaduan'"></h3>
                        <button @click="openModal = ''"
                            class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><strong>Nama:</strong> <span x-text="selectedComplaint?.nama"></span></p>
                        <p><strong>Judul:</strong> <span x-text="selectedComplaint?.judul"></span></p>
                        <p><strong>Status:</strong> <span x-text="selectedComplaint?.status"></span></p>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button @click="openModal = ''"
                            class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Tutup</button>
                    </div>
                </div>
            </div>
        </template>

        <!-- hapusModal -->
        <template x-if="hapusModal !== ''">
            <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold capitalize" x-text="hapusModal + ' Pengaduan'"></h3>
                        <button @click="hapusModal = ''"
                            class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
                    </div>
                    <p class="text-sm text-gray-700 mb-6">Apakah Anda yakin ingin menghapus pengaduan dari <strong><span x-text="selectedComplaint?.nama"></span></strong> dengan judul <strong><span x-text="selectedComplaint?.judul"></span></strong> ?</p>
                    <p class="text-sm text-gray-700 mb-6">Tindakan ini tidak dapat dibatalkan.</p>
                    <div class="flex justify-end space-x-3">
                        <button @click="hapusModal = ''"
                            class="px-4 py-2 bg-gray-100 rounded-xl hover:bg-gray-200">Batal</button>
                        <button class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700">Hapus</button>
                    </div>
                </div>
            </div>
        </template>

    </div>
</x-admin-layout>
