<x-admin-layout>
    <x-slot:title>{{ 'Kelola Data Keluarga' }}</x-slot>


    {{-- Logika tabel keluarga --}}
    <div class="p-6" x-data="{
        search: '',
        filter: '',
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        selectedKeluarga: null,
        keluarga: @js($keluargaJs),
        get filteredKeluarga() {
            return this.keluarga.filter(item => {
                const matchesSearch = item.nama.toLowerCase().includes(this.search.toLowerCase());
                const matchesFilter = this.filter === '' || item.status === this.filter;
                return matchesSearch && matchesFilter;
            });
        }
    }">



        {{-- Search bar + filter + tambah keluarga --}}
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
                        <input type="text" name="search" placeholder="Cari keluarga..."
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
                    class="bg-gray-300 hover:bg-gray-400 text-black w-auto px-4 py-2 rounded-full text-sm">
                    Tampilkan Semua
                </a>
            </div>
            {{-- Button tambah Keluarga --}}
            <button @click="selectedKeluarga = null; showAddModal = true"
                class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700">
                + Tambah Keluarga
            </button>
        </div>

        {{-- Tabel Keluarga --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Kode Keluarga</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Kepala Keluarga</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Alamat</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">RT</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">RW</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" x-show="filteredKeluarga.length > 0">
                    <template x-for="item in filteredKeluarga" :key="item.kode_keluarga">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-700" x-text="item.kode_keluarga"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="item.kepala_keluarga"></td>
                            <td class="px-6 py-4 text-sm text-gray-500"
                                x-text="item.alamat.length > 50 ? item.alamat.slice(0, 50) + '...' : item.alamat"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="item.rt"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="item.rw"></td>
                            <td class="px-6 py-4 text-center">
                                <button @click="selectedKeluarga = item; showDetailModal = true"
                                    class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="1"
                                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                        <path stroke="currentColor" stroke-width="1"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                                <button @click="selectedKeluarga = {...item}; showEditModal = true"
                                    class="text-yellow-600 hover:text-yellow-800"><svg class="w-[20px] h-[20px]"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </button>
                                <button @click="selectedKeluarga = item; showDeleteModal = true"
                                    class="text-red-600 hover:text-red-800 hover:bg-gray-200 rounded-full">
                                    <svg class="w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $keluarga->links() }}
        </div>
    </div>
</x-admin-layout>
