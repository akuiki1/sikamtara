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
        selectedDApbdes: null,
        dapbdes: @js($dapbdesJs),
        get filteredDApbdes() {
            return this.dapbdes.filter(item => {
                const searchTerm = this.search.toLowerCase();
                const matchesSearch =
                    item.id_rincian.toLowerCase().includes(searchTerm) ||
                    item.judul.toLowerCase().includes(searchTerm) ||
                    item.sub_judul.toLowerCase().includes(searchTerm) ||
                    item.kategori.toLowerCase().includes(searchTerm);
    
                const matchesFilter = this.filter === '' || item.kategori === this.filter;
                const matchesTahun = this.tahun === '' || item.id_apbdes.slice(0, 4) === this.tahun;
    
                return matchesSearch && matchesFilter && matchesTahun;
            });
        }
    
    }">

        {{-- search bar + filter + tambah apbdes --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
            {{-- LEFT SECTION: Search, Filter, Clear --}}
            <div class="flex flex-wrap items-center gap-2">
                {{-- SEARCH FORM --}}
                <form method="GET" class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        {{-- Search Icon --}}
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-width="2"
                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </span>
                    <input type="text" name="search" placeholder="Cari tahun..." value="{{ request('search') }}"
                        class="pl-10 pr-24 py-2 w-full rounded-full border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                        @keydown.enter="$event.target.form.submit()">
                    <x-button type="submit"
                        class="absolute right-1 top-1 bottom-1 bg-indigo-400 hover:bg-indigo-600 text-white px-4 py-1 rounded-full text-sm">
                        Cari
                    </x-button>
                </form>

                {{-- TOMBOL CLEAR FILTER (hanya muncul kalau filter aktif) --}}
                @if (request()->has('search') || request()->has('role') || request()->has('status'))
                    <a href="{{ url()->current() }}"
                        class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-400 text-gray-600 rounded-full">
                        Tampilkan Semua
                    </a>
                @endif
            </div>

            {{-- RIGHT SECTION: Tambah tahun --}}
            <div>
                <x-button @click="selectedApbdes = null; showAddModal = true">
                    {{-- Plus Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Tambah Tahun</span>
                </x-button>
            </div>
        </div>

        {{-- table --}}
        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="px-6 py-3 w-12 text-left text-sm">Tahun</th>
                    <th class="px-6 py-3 w-24 text-left text-sm">kategori</th>
                    <th class="px-6 py-3 w-28 text-left text-sm">judul</th>
                    <th class="px-6 py-3 w-28 text-left text-sm">sub_judul</th>
                    <th class="px-6 py-3 text-left text-sm">anggaran</th>
                    <th class="px-6 py-3 text-left text-sm">realisasi</th>
                    <th class="px-6 py-3 w-36 text-center text-sm">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                <template x-show="filteredDApbdes.length === 0">
                    <tr>
                        <td colspan="4" class="text-center px-6 py-4 text-sm text-gray-500">
                            Tidak ada data APBDes ditemukan.
                        </td>
                    </tr>
                </template>
                <template x-for="item in filteredDApbdes" :key="item.id_d_apbdes">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 w-12 text-sm" x-text="item.id_apbdes"></td>
                        <td class="px-6 py-4 w-24text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                :class="{
                                    'bg-green-400': item.kategori === 'Pendapatan',
                                    'bg-red-400': item.kategori === 'Belanja',
                                    'bg-orange-400': item.kategori === 'Pembiayaan'
                                }"
                                x-text="item.kategori"></span>
                        </td>
                        <td class="px-6 py-4 w-28 text-sm" x-text="item.judul"></td>
                        <td class="px-6 py-4 w-28 text-sm" x-text="item.sub_judul"></td>
                        <td class="px-6 py-4 text-sm" x-text="formatRupiah(item.anggaran)"></td>
                        <td class="px-6 py-4 text-sm" x-text="formatRupiah(item.realisasi)"></td>
                        <td class="px-6 py-4 w-36 text-center space-x-2">
                            <!-- Tombol Lihat -->
                            <button @click="selectedApbdes = item; openModal = 'detail'"
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
                            <button @click="selectedApbdes = item; openModal = 'edit'" title="edit"
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
                            <button @click="selectedApbdes = item; openModal = 'hapus'" title="Hapus"
                                class="text-red-500 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-trash-2 hover:text-lg">
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
            </x-slot>
        </x-table>

        {{-- modal tambah --}}
        <template x-if="openModal === 'tambah'">
            <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl relative max-h-screen overflow-y-auto">
                    <h2 class="text-xl font-bold mb-6 text-gray-800">Tambah Data APBDes</h2>

                    <form action="/apbdes/detail" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-900">

                            <!-- Tahun -->
                            <div>
                                <label for="id_apbdes" class="block mb-2 font-semibold">Tahun</label>
                                <select name="id_apbdes" id="id_apbdes" class="w-full border p-3 rounded-lg"
                                    required>
                                    <template x-for="item in daftarApbdes" :key="item.id_apbdes">
                                        <option :value="item.id_apbdes" x-text="item.tahun"></option>
                                    </template>
                                </select>
                            </div>

                            <!-- Judul -->
                            <div>
                                <label for="judul" class="block mb-2 font-semibold">Judul</label>
                                <input type="text" name="judul" id="judul" placeholder="Judul"
                                    class="w-full border p-3 rounded-lg" required>
                            </div>

                            <!-- Sub Judul -->
                            <div class="md:col-span-2">
                                <label for="sub_judul" class="block mb-2 font-semibold">Sub Judul / Deskripsi</label>
                                <textarea name="sub_judul" id="sub_judul" rows="3"
                                    class="w-full border p-3 rounded-lg resize-y focus:ring-2 focus:ring-yellow-600"
                                    placeholder="Contoh: Belanja Bidang Pembangunan Desa untuk Infrastruktur Jalan..." required></textarea>
                            </div>

                            <!-- Anggaran -->
                            <div>
                                <label for="anggaran" class="block mb-2 font-semibold">Anggaran (Rp)</label>
                                <input type="number" name="anggaran" id="anggaran"
                                    placeholder="Masukkan nilai anggaran" class="w-full border p-3 rounded-lg"
                                    required>
                            </div>

                            <!-- Realisasi -->
                            <div>
                                <label for="realisasi" class="block mb-2 font-semibold">Realisasi (Rp)</label>
                                <input type="number" name="realisasi" id="realisasi"
                                    placeholder="Masukkan nilai realisasi" class="w-full border p-3 rounded-lg"
                                    required>
                            </div>

                            <!-- Kategori -->
                            <div class="md:col-span-2">
                                <label for="kategori" class="block mb-2 font-semibold">Kategori</label>
                                <select name="kategori" id="kategori" class="w-full border p-3 rounded-lg" required>
                                    <option value="Pendapatan">Pendapatan</option>
                                    <option value="Belanja">Belanja</option>
                                    <option value="Pembiayaan">Pembiayaan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tombol aksi -->
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="openModal = ''"
                                class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 transition">Batal</button>
                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- Modal detail -->
        <template x-if="openModal === 'detail' && selectedApbdes">
            <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl p-6 w-full max-w-2xl shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold capitalize" x-text="openModal + ' APBDes'"></h3>
                        <button @click="openModal = ''"
                            class="text-xl text-gray-500 hover:text-red-500">&times;</button>
                    </div>
                    <div class="space-y-3 text-sm text-gray-700">
                        <p><strong>Tahun:</strong> <span x-text="selectedApbdes.id_apbdes"></span></p>
                        <p><strong>Kategori:</strong> <span x-text="selectedApbdes.kategori"></span></p>
                        <p><strong>Judul:</strong> <span x-text="selectedApbdes.judul"></span></p>
                        <p><strong>Sub Judul:</strong> <span x-text="selectedApbdes.sub_judul"></span></p>
                        <p><strong>Anggaran:</strong> <span x-text="selectedApbdes.anggaran"></span></p>
                        <p><strong>Realisasi:</strong> <span x-text="selectedApbdes.realisasi"></span></p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button @click="openModal = ''"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tutup</button>
                    </div>
                </div>
            </div>
        </template>

        <!-- Modal edit -->
        <template x-if="openModal === 'edit' && selectedApbdes">
            <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl relative max-h-screen overflow-y-auto">
                    <h2 class="text-xl font-bold mb-4">Edit APBDes</h2>
                    <form :action="`/apbdes/detail/${selectedApbdes.id_d_apbdes}`" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Grid 2 kolom -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-900">
                            <!-- Tahun -->
                            <div>
                                <label for="id_apbdes" class="block mb-2 font-semibold">Tahun</label>
                                <select name="id_apbdes" id="id_apbdes" class="w-full border p-3 rounded-lg"
                                    required>
                                    <template x-for="item in daftarApbdes" :key="item.id_apbdes">
                                        <option :value="item.id_apbdes"
                                            :selected="selectedApbdes.id_apbdes == item.id_apbdes" x-text="item.tahun">
                                        </option>
                                    </template>
                                </select>
                            </div>

                            <!-- Judul -->
                            <div>
                                <label for="judul" class="block mb-2 font-semibold">Judul</label>
                                <input type="text" name="judul" id="judul" :value="selectedApbdes.judul"
                                    class="w-full border p-3 rounded-lg" placeholder="Judul kegiatan" required>
                            </div>

                            <!-- Anggaran -->
                            <div>
                                <label for="anggaran" class="block mb-2 font-semibold">Anggaran</label>
                                <input type="number" name="anggaran" id="anggaran"
                                    :value="selectedApbdes.anggaran" class="w-full border p-3 rounded-lg"
                                    placeholder="Contoh: 5000000" required>
                            </div>

                            <!-- Realisasi -->
                            <div>
                                <label for="realisasi" class="block mb-2 font-semibold">Realisasi</label>
                                <input type="number" name="realisasi" id="realisasi"
                                    :value="selectedApbdes.realisasi" class="w-full border p-3 rounded-lg"
                                    placeholder="Contoh: 4500000" required>
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="kategori" class="block mb-2 font-semibold">Kategori</label>
                                <select name="kategori" id="kategori" class="w-full border p-3 rounded-lg" required>
                                    <option value="Pendapatan" :selected="selectedApbdes.kategori === 'Pendapatan'">
                                        Pendapatan</option>
                                    <option value="Belanja" :selected="selectedApbdes.kategori === 'Belanja'">
                                        Belanja</option>
                                    <option value="Pembiayaan" :selected="selectedApbdes.kategori === 'Pembiayaan'">
                                        Pembiayaan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Full Width: Sub Judul -->
                        <div class="text-gray-900">
                            <label for="sub_judul" class="block mb-2 font-semibold">Sub Judul / Deskripsi</label>
                            <textarea name="sub_judul" id="sub_judul" rows="4"
                                class="w-full border p-3 rounded-lg resize-y focus:ring-2 focus:ring-yellow-600"
                                placeholder="Masukkan sub judul atau deskripsi rinci..." x-text="selectedApbdes.sub_judul" required></textarea>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="openModal = ''"
                                class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 transition">Batal</button>
                            <button type="submit"
                                class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">Update</button>
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
                        <h3 class="text-lg font-bold capitalize" x-text="openModal + ' APBDes'"></h3>
                        <button @click="openModal = ''"
                            class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
                    </div>
                    <p class="text-sm text-gray-700 mb-6">Apakah Anda yakin ingin menghapus APBDes <strong><span
                                x-text="selectedApbdes.sub_judul"></span></strong> tahun <strong><span
                                x-text="selectedApbdes.id_apbdes"></span></strong> ?</p>
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
