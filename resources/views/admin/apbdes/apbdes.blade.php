<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    {{-- logika table --}}
    <div class="p-6" x-data="{
        search: '',
        tahun: '',
        openModal: '',
        selectedApbdes: null,
        apbdes: [{
                id_apbdes: 1,
                tahun: 2024,
                total_anggaran: 'Rp 3.432.000',
                total_realisasi: 'Rp 3.432.000',
            },
            {
                id_apbdes: 2,
                tahun: 2023,
                total_anggaran: 'Rp 2.100.000',
                total_realisasi: 'Rp 1.800.000',
            },
        ],
        get filteredApbdes() {
            return this.apbdes.filter(item => {
                const matchesSearch = this.search === '' || item.tahun.toString().includes(this.search);
                const matchesTahun = this.tahun === '' || item.tahun.toString() === this.tahun;
                return matchesSearch && matchesTahun;
            });
        }
    }">


        {{-- search bar + filter + tambah berita --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">

            {{-- kontainer search dan filter --}}
            <div class="flex flex-col md:flex-row items-center gap-4">
                {{-- search bar --}}
                <div class="relative">
                    <input type="text" placeholder="Cari tahun..." x-model="search"
                        class="w-full md:w-80 pl-10 border border-gray-300 rounded-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">

                    <svg class="w-6 h-6 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                </div>

                {{-- filter --}}
                <div class="relative" x-data="{
                    showFilters: false,
                    clearFilters() {
                        filter = '';
                        bulan = '';
                        tahun = '';
                    },
                    get activeCount() {
                        return [filter, bulan, tahun].filter(Boolean).length;
                    }
                }">
                    <!-- Toggle Button -->
                    <button @click="showFilters = !showFilters"
                        class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-full shadow-sm hover:bg-gray-50 transition-all duration-200 text-sm font-medium text-gray-700">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                        </svg>
                        <span>Filter</span>
                        <template x-if="activeCount > 0">
                            <span
                                class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-blue-600 rounded-full">
                                <span x-text="activeCount"></span>
                            </span>
                        </template>
                        <svg :class="{ 'rotate-180': showFilters }"
                            class="transform transition-transform duration-300 w-4 h-4 ml-1 text-gray-400"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="showFilters" @click.outside="showFilters = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        class="absolute z-50 mt-2 right-0 w-80 bg-white backdrop-blur-md border border-gray-200 rounded-2xl shadow-xl p-5 space-y-4 origin-top-right ">

                        <!-- Filter Section -->
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Status</label>
                                <select x-model="filter"
                                    class="w-full px-4 py-2 text-sm border rounded-lg focus:ring focus:border-blue-500">
                                    <option value="">Semua Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Bulan</label>
                                <select x-model="bulan"
                                    class="w-full px-4 py-2 text-sm border rounded-lg focus:ring focus:border-blue-500">
                                    <option value="">Semua Bulan</option>
                                    <template x-for="i in 12" :key="i">
                                        <option :value="String(i).padStart(2, '0')"
                                            x-text="new Date(0, i - 1).toLocaleString('id-ID', { month: 'long' })">
                                        </option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Tahun</label>
                                <select x-model="tahun"
                                    class="w-full px-4 py-2 text-sm border rounded-lg focus:ring focus:border-blue-500">
                                    <option value="">Semua Tahun</option>
                                    <template
                                        x-for="tahunItem in [...new Set(berita.map(b => b.tanggal_publish.slice(0,4)))]">
                                        <option :value="tahunItem" x-text="tahunItem"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <!-- Tombol Clear Filter -->
                        <button @click="filter=''; bulan=''; tahun=''"
                            class="w-full text-center text-sm text-blue-600 hover:underline transition">
                            Hapus Semua Filter
                        </button>
                    </div>
                </div>
            </div>
            {{-- button tambah berita --}}
            <button @click="openModal = 'tambah'"
                class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700">
                + Tambah Data APBDes
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Tahun</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Total Anggaran</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Total Realisasi</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" x-show="filteredApbdes.length > 0">
                    <template x-for="item in filteredApbdes" :key="item.id_apbdes">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm" x-text="item.tahun"></td>
                            <td class="px-6 py-4 text-sm" x-text="item.total_anggaran"></td>
                            <td class="px-6 py-4 text-sm" x-text="item.total_realisasi"></td>
                            <td class="px-6 py-4 text-center text-sm">
                                <button @click="selectedApbdes = item; openModal = 'edit'"
                                    class="text-blue-600 hover:underline">Edit</button>
                                <button @click="selectedApbdes = item; openModal = 'hapus'"
                                    class="text-blue-600 hover:underline">hapus</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
                <tbody x-show="filteredApbdes.length === 0">
                    <tr>
                        <td colspan="4" class="text-center px-6 py-4 text-sm text-gray-500">
                            Tidak ada data APBDes ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- modal tambah --}}
        <template x-if="openModal === 'tambah'">
            <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl relative">
                    <h2 class="text-xl font-bold mb-4">Tambah Tahun APBDes</h2>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        {{-- <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data"> --}}
                        @csrf
                        <div class="grid grid-cols-1 gap-4">
                            <div x-data="{ tahun: new Date().getFullYear() }" class="flex items-center gap-3 w-full">
                                <!-- Ikon Kalender -->
                                <svg class="w-6 h-6 text-gray-800 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                </svg>

                                <!-- Input + Tombol Atas Bawah -->
                                <div class="relative w-full">
                                    <input type="number" name="tahun" x-model="tahun" :placeholder="tahun"
                                        min="1900" max="2099"
                                        class="border w-full p-2 rounded-lg pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required>
                                </div>
                            </div>

                        </div>
                        <div class="mt-4 flex justify-end gap-2">
                            <button type="button" @click="openModal = ''"
                                class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Batal</button>
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- Modal Edit -->
        <template x-if="openModal === 'edit'">
            <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl relative" x-data="{ tahun: selectedApbdes?.tahun || new Date().getFullYear() }">
                    <h2 class="text-xl font-bold mb-4">Edit Tahun APBDes</h2>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex items-center gap-3 w-full">
                                <!-- Ikon Kalender -->
                                <svg class="w-6 h-6 text-gray-800 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                </svg>

                                <!-- Input Tahun -->
                                <div class="relative w-full">
                                    <input type="number" name="tahun" x-model="tahun" :placeholder="tahun"
                                        min="1900" max="2099" class="border w-full p-2 rounded-lg" />
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-6 flex justify-end gap-2">
                            <button type="button" @click="openModal = ''"
                                class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- Modal hapus -->
        <template x-if="openModal === 'hapus' && selectedApbdes">
            <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold capitalize" x-text="openModal + ' Data Apbdes'"></h3>
                        <button @click="openModal = ''"
                            class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
                    </div>
                    <p class="text-sm text-gray-700 mb-6">Apakah Anda yakin ingin menghapus data APBDes tahun <strong><span
                                x-text="selectedApbdes.tahun"></span></strong> ?</p>
                    <p class="text-sm text-gray-700 mb-6">Tindakan ini tidak dapat dibatalkan.</p>
                    <div class="flex justify-end space-x-3">
                        <button @click="openModal = ''"
                            class="px-4 py-2 bg-gray-100 rounded-xl hover:bg-gray-200">Batal</button>
                        <button class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700">Hapus</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-admin-layout>
