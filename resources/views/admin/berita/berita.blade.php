<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    {{-- logika table --}}
    <div class="p-6" x-data="{
        search: '',
        filter: '',
        openModal: '',
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
            <button @click="openModal = 'tambah'"
                class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700">
                + Tambah Berita
            </button>
        </div>

        {{-- table --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Judul</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Tanggal</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Penulis</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" x-show="filteredBerita.length > 0">
                    <template x-for="item in filteredBerita" :key="item.id_berita">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm" x-text="item.judul_berita"></td>
                            <td class="px-6 py-4 text-sm" x-text="item.tanggal_publish"></td>
                            <td class="px-6 py-4 text-sm" x-text="item.penulis"></td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold"
                                    :class="{
                                        'bg-yellow-100 text-yellow-800': item.status === 'draft',
                                        'bg-green-100 text-green-800': item.status === 'published',
                                        'bg-gray-200 text-gray-600': item.status === 'archived'
                                    }"
                                    x-text="item.status"></span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <!-- Tombol Lihat -->
                                <button @click="selectedBerita = item; openModal = 'detail'"
                                    class="text-blue-500 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-eye-icon lucide-eye">
                                        <path
                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>

                                <!-- Tombol Edit -->
                                <button @click="selectedBerita = item; openModal = 'edit'" title="edit"
                                    class="text-yellow-500 hover:text-yellow-600 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-pencil-icon lucide-pencil">
                                        <path
                                            d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </button>

                                <!-- Tombol Hapus -->
                                <button @click="selectedBerita = item; openModal = 'hapus'" title="Hapus"
                                    class="text-red-500 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2 hover:text-lg">
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
                </tbody>
                <tbody x-show="filteredBerita.length === 0">
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada berita
                            ditemukan.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- modal tambah --}}
        <template x-if="openModal === 'tambah'">
            <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl relative max-h-screen overflow-y-auto">
                    <h2 class="text-xl font-bold mb-6 text-gray-800">Tambah APBDes</h2>

                    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <!-- Grid 2 kolom -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-900">
                            <!-- Judul Berita -->
                            <div>
                                <label for="judul_berita" class="block mb-2 font-semibold">Judul Berita</label>
                                <input type="text" name="judul_berita" id="judul_berita"
                                    placeholder="Judul Berita" class="w-full border p-3 rounded-lg" required>
                            </div>

                            <!-- Tanggal (sub_judul) -->
                            <div>
                                <label for="sub_judul" class="block mb-2 font-semibold">Tanggal</label>
                                <input type="date" name="sub_judul" id="sub_judul"
                                    class="w-full border p-3 rounded-lg" required>
                            </div>

                            <!-- Anggaran -->
                            <div>
                                <label for="anggaran" class="block mb-2 font-semibold">Anggaran</label>
                                <input type="text" name="anggaran" id="anggaran" placeholder="Anggaran"
                                    class="w-full border p-3 rounded-lg" required>
                            </div>

                            <!-- Tags -->
                            <div>
                                <label for="tags" class="block mb-2 font-semibold">Tags</label>
                                <input type="text" name="tags" id="tags"
                                    placeholder="Tag (pisahkan dengan koma)" class="w-full border p-3 rounded-lg">
                            </div>

                            <!-- Upload Gambar -->
                            <div>
                                <label for="gambar_cover" class="block mb-2 font-semibold">Upload Gambar</label>
                                <input type="file" name="judul" id="gambar_cover"
                                    class="w-full border p-3 rounded-lg file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-yellow-600 file:text-white hover:file:bg-yellow-700" />
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="kategori" class="block mb-2 font-semibold">Kategori</label>
                                <select name="kategori" id="kategori" class="w-full border p-3 rounded-lg" required>
                                    <option value="Pendapatan">Pendapatan</option>
                                    <option value="Belanja">Belanja</option>
                                    <option value="Pembiayaan">Pembiayaan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Full Width: Isi Berita -->
                        <div class="text-gray-900">
                            <label for="isi_berita" class="block mb-2 font-semibold">Isi Berita</label>
                            <textarea name="isi_berita" id="isi_berita" rows="5"
                                class="w-full border p-3 rounded-lg resize-y focus:ring-2 focus:ring-blue-600"
                                placeholder="Masukkan isi berita lengkap di sini..." required></textarea>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="openModal = ''"
                                class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 transition">Batal</button>
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- Modal detail -->
        <template x-if="openModal === 'detail' && selectedBerita">
            <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl p-6 w-full max-w-2xl shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold capitalize" x-text="openModal + ' Berita'"></h3>
                        <button @click="openModal = ''"
                            class="text-xl text-gray-500 hover:text-red-500">&times;</button>
                    </div>
                    <div class="space-y-3 text-sm text-gray-700">
                        <img :src="selectedBerita.gambar_cover" class="w-full rounded-xl" alt="Gambar Berita">
                        <p><strong>Judul:</strong> <span x-text="selectedBerita.judul_berita"></span></p>
                        <p><strong>Tanggal:</strong> <span x-text="selectedBerita.tanggal_publish"></span></p>
                        <p><strong>Penulis:</strong> <span x-text="selectedBerita.penulis"></span></p>
                        <p><strong>Status:</strong> <span x-text="selectedBerita.status"></span></p>
                        <p><strong>Isi:</strong> <span x-text="selectedBerita.isi_berita"></span></p>
                        <p><strong>Tags:</strong> <span x-text="selectedBerita.tags.join(', ')"></span></p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button @click="openModal = ''"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tutup</button>
                    </div>
                </div>
            </div>
        </template>

        <!-- Modal edit -->
        <template x-if="openModal === 'edit' && selectedBerita">
            <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl relative">
                    <h2 class="text-xl font-bold mb-4">Edit Berita</h2>
                    <form :action="`/berita/${selectedBerita.id_berita}`" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-4">
                            <input type="text" name="judul_berita" :value="selectedBerita.judul_berita"
                                class="border p-2 rounded" required>
                            <textarea name="isi_berita" rows="5" class="border p-2 rounded" x-text="selectedBerita.isi_berita"></textarea>
                            <input type="file" name="gambar_cover" class="border p-2 rounded">
                            <input type="date" name="tanggal_publish" :value="selectedBerita.tanggal_publish"
                                class="border p-2 rounded" required>
                            <input type="text" name="penulis" :value="selectedBerita.penulis"
                                class="border p-2 rounded" required>
                            <input type="text" name="tags" :value="selectedBerita.tags"
                                class="border p-2 rounded">
                            <select name="status" class="border p-2 rounded" :value="selectedBerita.status">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                        <div class="mt-4 flex justify-end gap-2">
                            <button type="button" @click="openModal = ''"
                                class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Batal</button>
                            <button type="submit"
                                class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- Modal hapus -->
        <template x-if="openModal === 'hapus' && selectedBerita">
            <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold capitalize" x-text="openModal + ' Berita'"></h3>
                        <button @click="openModal = ''"
                            class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
                    </div>
                    <p class="text-sm text-gray-700 mb-6">Apakah Anda yakin ingin menghapus berita <strong><span
                                x-text="selectedBerita.judul_berita"></span></strong> ?</p>
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
