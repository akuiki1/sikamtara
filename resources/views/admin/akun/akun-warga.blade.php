<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    {{-- logika table --}}
    <div class="p-6" x-data="{
        search: '',
        filter: '',
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        tanggal: '',
        bulan: '',
        tahun: '',
        selectedBerita: null,
        berita: [{
                id_berita: 1,
                judul_berita: 'Pembangunan Jalan Baru',
                isi_berita: 'Pemerintah desa memulai pembangunan jalan...',
                gambar_cover: 'https://via.placeholder.com/150',
                tanggal_publish: '2025-05-08',
                penulis: 'Admin Desa',
                status: 'published',
                tags: ['pembangunan', 'jalan'],
            },
            {
                id_berita: 2,
                judul_berita: 'Festival Budaya Kambat Utara',
                isi_berita: 'Masyarakat antusias mengikuti festival budaya...',
                gambar_cover: 'https://via.placeholder.com/150',
                tanggal_publish: '2025-05-05',
                penulis: 'Admin Desa',
                status: 'draft',
                tags: ['budaya', 'festival'],
            },
        ],
        get filteredBerita() {
            return this.berita.filter(item => {
                const tanggalBerita = item.tanggal_publish;
                const matchesSearch = item.judul_berita.toLowerCase().includes(this.search.toLowerCase());
                const matchesFilter = this.filter === '' || item.status === this.filter;
                const matchesTanggal = this.tanggal === '' || tanggalBerita === this.tanggal;
                const matchesBulan = this.bulan === '' || tanggalBerita.slice(5, 7) === this.bulan;
                const matchesTahun = this.tahun === '' || tanggalBerita.slice(0, 4) === this.tahun;
    
                return matchesSearch && matchesFilter && matchesTanggal && matchesBulan && matchesTahun;
            });
        }
    }">

        {{-- search bar + filter + tambah berita --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">

            {{-- kontainer search dan filter --}}
            <div class="flex flex-col md:flex-row items-center gap-4">
                {{-- search bar --}}
                <div class="relative">
                    <input type="text" placeholder="Cari nama atau judul..." x-model="search"
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
            <button @click="selectedPenduduk = null; showAddModal = true"
                class="flex items-center gap-2 bg-indigo-400 hover:bg-indigo-600 text-white px-4 py-2 rounded-full transition duration-200 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-plus-icon lucide-plus">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg>
                <span>Tambah Akun</span>
            </button>
        </div>

        {{-- table --}}
        <x-table>
            {{-- SLOT HEADER --}}
            <x-slot name="head">
                <tr>
                    <th class="px-4 py-3 text-center">nama</th>
                    <th class="px-4 py-3 text-center">email</th>
                    <th class="px-4 py-3 text-center">role</th>
                    <th class="px-4 py-3 text-center">status verifikasi</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </x-slot>

            {{-- SLOT BODY --}}
            <template x-for="item in filteredBerita" :key="item.id_berita">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm" x-text="item.judul_berita"></td>
                    <td class="px-6 py-4 text-center" x-text="item.tanggal_publish"></td>
                    <td class="px-6 py-4 text-center" x-text="item.penulis"></td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold"
                            :class="{
                                'bg-yellow-100 text-yellow-800': item.status === 'draft',
                                'bg-green-100 text-green-800': item.status === 'published',
                                'bg-gray-200 text-gray-600': item.status === 'archived'
                            }"
                            x-text="item.status"></span>
                    </td>
                    <!-- Tombol Aksi -->
                    <td class="px-6 py-4 text-center space-x-2">
                        <button @click="selectedPenduduk = item; showDetailModal = true"
                            class="text-blue-500 hover:text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-eye-icon lucide-eye">
                                <path
                                    d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                        <!-- Edit -->
                        <button @click="selectedPenduduk = {...item}; showEditModal = true"
                            class="text-yellow-500 hover:text-yellow-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-pencil-icon lucide-pencil">
                                <path
                                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                <path d="m15 5 4 4" />
                            </svg>
                        </button>
                        <!-- Delete -->
                        <button @click="selectedPenduduk = item; showDeleteModal = true"
                            class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-trash2-icon lucide-trash-2">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                <line x1="10" x2="10" y1="11" y2="17" />
                                <line x1="14" x2="14" y1="11" y2="17" />
                            </svg>
                        </button>
                    </td>
                </tr>
            </template>

            {{-- Jika tidak ada data --}}
            <tr x-show="filteredBerita.length === 0">
                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                    Tidak ada berita ditemukan.
                </td>
            </tr>
        </x-table>

        {{-- modal status --}}
        <div x-data="{ showSuccess: {{ session('success') ? 'true' : 'false' }}, showError: {{ session('error') ? 'true' : 'false' }} }" x-init="setTimeout(() => {
            showSuccess = false;
            showError = false
        }, 3000)" class="fixed top-5 right-5 z-50 space-y-2">

            <!-- Berhasil -->
            <div x-show="showSuccess" x-transition
                class="flex items-center gap-3 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>

            <!-- Gagal -->
            <div x-show="showError" x-transition
                class="flex items-center gap-3 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>

        {{-- modal tambah --}}
        <x-modal show="showAddModal" title="Tambah Akun Baru">
            <form action="#" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <div class="">
                            <label for="nik" class="block text-sm font-medium">NIK</label>
                            <input type="text" id="nik" name="nik" x-model="selectedPenduduk?.nik"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" @click="{{ 'showAddModal' }} = false"
                        class="inline-flex items-center rounded-full text-base px-5 py-3 focus:outline-none transition duration-150 ease-in-out bg-gray-200 hover:bg-gray-300 text-gray-700">Batal</button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- modal detail --}}
        <x-modal show="showDetailModal" title="Detail Akun">
            <form action="#" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <div class="">
                            <label for="nik" class="block text-sm font-medium">NIK</label>
                            <input type="text" id="nik" name="nik" x-model="selectedPenduduk?.nik"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" @click="{{ 'showDetailModal' }} = false"
                        class="inline-flex items-center rounded-full text-base px-5 py-3 focus:outline-none transition duration-150 ease-in-out bg-gray-200 hover:bg-gray-300 text-gray-700">Batal</button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- modal edit --}}
        <x-modal show="showEditModal" title="Edit Akun">
            <form action="#" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <div class="">
                            <label for="nik" class="block text-sm font-medium">NIK</label>
                            <input type="text" id="nik" name="nik" x-model="selectedPenduduk?.nik"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" @click="{{ 'showEditModal' }} = false"
                        class="inline-flex items-center rounded-full text-base px-5 py-3 focus:outline-none transition duration-150 ease-in-out bg-gray-200 hover:bg-gray-300 text-gray-700">Batal</button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- modal hapus --}}
        <div x-show="showDeleteModal" @click.away="showDeleteModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-xl shadow-2xl w-96 p-6 text-center">
                <h2 class="text-xl font-semibold mb-4 text-red-600">Hapus Penduduk?</h2>
                <p class="mb-4">Apakah Anda yakin ingin menghapus data <strong
                        x-text="selectedPenduduk.nama"></strong>?</p>

                <form :action="`/admin/penduduk/${selectedPenduduk.nik}`" method="POST" x-ref="deleteForm">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-center gap-4">
                        <button type="button" @click="showDeleteModal = false"
                            class="px-4 py-2 bg-gray-300 rounded-lg text-sm hover:bg-gray-400">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
