<x-admin-layout>
    <x-slot:title>{{ 'kelola penduduk' }}</x-slot>

    {{-- Logika tabel penduduk --}}
    <div class="p-6" x-data="{
        search: '',
        filter: '',
        openModal: false,
        selectedPenduduk: null,
        penduduk: @js($penduduk),
        get filteredPenduduk() {
            return this.penduduk.filter(item => {
                const matchesSearch = item.nama.toLowerCase().includes(this.search.toLowerCase());
                const matchesFilter = this.filter === '' || item.status === this.filter;
                return matchesSearch && matchesFilter;
            });
        }
    }">

        {{-- Search bar + filter + tambah penduduk --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">

            {{-- Kontainer search dan filter --}}
            <div class="flex flex-col md:flex-row items-center gap-4">
                {{-- Search bar --}}
                <div class="relative">
                    <input type="text" placeholder="Cari nama penduduk..." x-model="search"
                        class="w-full md:w-80 pl-10 border border-gray-300 rounded-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">

                    <svg class="w-6 h-6 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                </div>

                {{-- Filter --}}
                <div class="relative">
                    <button @click="filter = filter ? '' : 'Aktif'"
                        class="px-4 py-2 border border-gray-300 rounded-full bg-white text-sm text-gray-700 focus:outline-none">
                        Filter: <span x-text="filter ? filter : 'Semua'"></span>
                    </button>
                </div>
            </div>

            {{-- Button tambah penduduk --}}
            <button @click="openModal = true" class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700">
                + Tambah Penduduk
            </button>
        </div>

        {{-- Tabel penduduk --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Tanggal Lahir</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Alamat</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" x-show="filteredPenduduk.length > 0">
                    <template x-for="item in filteredPenduduk" :key="item.id_penduduk">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-700" x-text="item.nama"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="item.tanggal_lahir"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="Str::limit(item.alamat), 50"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="item.jenis_kelamin"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="item.status"></td>
                            <td class="px-6 py-4 text-center">
                                <button @click="openModal = true; selectedPenduduk = item"
                                    class="text-blue-600 hover:text-blue-800">View</button>
                                <button @click="openModal = true; selectedPenduduk = item"
                                    class="text-yellow-600 hover:text-yellow-800">Edit</button>
                                <button @click="openModal = true; selectedPenduduk = item"
                                    class="text-red-600 hover:text-red-800">Hapus</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        {{-- Modal Tambah/Edit Penduduk --}}
        <div x-show="openModal" @click.away="openModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white rounded-lg shadow-xl w-96 p-6">
                <h2 class="text-xl font-semibold text-center mb-4">Tambah/Edit Penduduk</h2>
                <form action="#" method="POST" @submit.prevent>
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="nama" x-model="selectedPenduduk ? selectedPenduduk.nama : ''"
                            class="w-full px-4 py-2 text-sm border rounded-lg focus:ring focus:border-blue-500">
                    </div>
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" id="alamat" x-model="selectedPenduduk ? selectedPenduduk.alamat : ''"
                            class="w-full px-4 py-2 text-sm border rounded-lg focus:ring focus:border-blue-500">
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir"
                            x-model="selectedPenduduk ? selectedPenduduk.tanggal_lahir : ''"
                            class="w-full px-4 py-2 text-sm border rounded-lg focus:ring focus:border-blue-500">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select x-model="selectedPenduduk ? selectedPenduduk.status : ''"
                            class="w-full px-4 py-2 text-sm border rounded-lg focus:ring focus:border-blue-500">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <button type="button" @click="openModal = false"
                            class="px-6 py-2 bg-gray-200 rounded-lg text-sm text-gray-700 hover:bg-gray-300">Batal</button>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 rounded-lg text-sm text-white hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-admin-layout>
