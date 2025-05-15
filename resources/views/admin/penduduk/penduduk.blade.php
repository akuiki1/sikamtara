<x-admin-layout>
    <x-slot:title>{{ 'kelola penduduk' }}</x-slot>

    {{-- Logika tabel penduduk --}}
    <div class="p-6" x-data="{
        search: '',
        filter: '',
        openModal: false,
        selectedPenduduk: null,
        penduduk: @js($pendudukJs),
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
            <div class="flex items-center gap-2">
                <form method="GET" class="flex flex-col md:flex-row items-center gap-4">
                    <div class="relative w-full md:w-80">
                        <!-- Ikon kaca pembesar -->
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <svg class="w-6 h-6 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </span>

                        <!-- Input pencarian -->
                        <input type="text" name="search" placeholder="Cari nama penduduk..."
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-20 border border-gray-300 rounded-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">

                        <!-- Tombol Cari di dalam input -->
                        <button type="submit"
                            class="absolute right-1 top-1 bottom-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-full text-sm">
                            Cari
                        </button>
                    </div>
                </form>

                <a href="{{ url()->current() }}"
                    class="bg-gray-300 hover:bg-gray-400 text-black px-3 py-1 rounded-lg text-sm">
                    Set Default
                </a>
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
                            <td class="px-6 py-4 text-sm text-gray-500"
                                x-text="item.alamat.length > 50 ? item.alamat.slice(0, 50) + '...' : item.alamat"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="item.jenis_kelamin"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="item.status_tinggal"></td>
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
        <div class="mt-4">
            {{ $penduduk->links() }}
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
