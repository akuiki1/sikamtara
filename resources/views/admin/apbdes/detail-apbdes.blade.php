<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    {{-- logika table --}}
    <div class="p-6" x-data="{
        search: '',
        tahun: '',
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        selectedApbdes: null,
        apbdes: @js($detailJs),
        get filteredApbdes() {
            return this.apbdes.filter(item => {
                const matchesSearch = this.search === '' || item.judul.toLowerCase().includes(this.search.toLowerCase()) || item.sub_judul.toLowerCase().includes(this.search.toLowerCase());
                const matchesTahun = this.tahun === '' || item.tahun.toString() === this.tahun;
                return matchesSearch && matchesTahun;
            });
        }
    
    }">

        {{-- search bar + filter + tambah apbdes --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
            {{-- LEFT SECTION: Search, Filter, Clear --}}
            <div class="flex flex-wrap items-center gap-2">
                <form method="GET" class="flex flex-wrap items-center gap-2">
                    <!-- Dropdown Tahun pakai x-model -->
                    <select x-model="tahun"
                        class="pl-4 pr-4 py-2 rounded-full border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                        <option value="">Semua Tahun</option>
                        <template x-for="item in {{ Js::from($tahun) }}" :key="item">
                            <option :value="item.tahun" x-text="item.tahun"></option>
                        </template>
                    </select>



                    {{-- Input Search --}}
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </span>
                        <input type="text" name="search" placeholder="Cari berdasarkan judul atau subjudul..."
                            x-model="search"
                            class="pl-10 pr-24 py-2 rounded-full border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm w-64" />
                        <button type="submit"
                            class="absolute right-1 top-1 bottom-1 bg-indigo-400 hover:bg-indigo-600 text-white px-4 py-1 rounded-full text-sm">
                            Cari
                        </button>
                    </div>
                </form>

                {{-- Tombol Clear Filter --}}
                @if (request()->has('search') || request()->has('tahun'))
                    <a href="{{ route('admindapbdes.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm px-4 py-2 rounded-full">
                        Tampilkan semua
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
                    <span>Tambah</span>
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
                <template x-show="filteredApbdes.length === 0">
                    <tr>
                        <td colspan="4" class="text-center px-6 py-4 text-sm text-gray-500">
                            Tidak ada data APBDes ditemukan.
                        </td>
                    </tr>
                </template>
                <template x-for="item in filteredApbdes" :key="item.id_rincian">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 w-12 text-sm" x-text="item.tahun"></td>
                        <td class="px-6 py-4 w-24text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                :class="{
                                    'bg-green-400': item.kategori === 'pendapatan',
                                    'bg-red-400': item.kategori === 'belanja',
                                    'bg-orange-400': item.kategori === 'pembiayaan'
                                }"
                                x-text="item.kategori"></span>
                        </td>
                        <td class="px-6 py-4 w-28 text-sm" x-text="item.judul"></td>
                        <td class="px-6 py-4 w-28 text-sm" x-text="item.sub_judul"></td>
                        <td class="px-6 py-4 text-sm" x-text="item.anggaran"></td>
                        <td class="px-6 py-4 text-sm" x-text="item.realisasi"></td>
                        <td class="px-6 py-4 w-36 text-center space-x-2">
                            <!-- Tombol Edit -->
                            <button @click="selectedApbdes = {...item}; showEditModal = true" title="edit"
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
                            <button @click="selectedApbdes = item; showDeleteModal = true" title="Hapus"
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
        <x-modal show="showAddModal" title="Tambah Akun Baru">
            <form action="{{ route('admindapbdes.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-900">

                    <!-- Tahun -->
                    <div>
                        <label for="id_apbdes" class="block mb-2 font-semibold">Tahun</label>
                        <select name="id_apbdes" id="tahun" x-model="selectedApbdes.tahun"
                            class="border w-full p-2 rounded-lg pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                            required>
                            <option value="">-- Pilih Tahun --</option>
                            <template x-for="item in {{ Js::from($tahun) }}" :key="item.id_apbdes">
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
                            placeholder="jangan pakai koma (contoh 10000 untuk 10.000)"
                            class="w-full border p-3 rounded-lg" required>
                    </div>

                    <!-- Realisasi -->
                    <div>
                        <label for="realisasi" class="block mb-2 font-semibold">Realisasi (Rp)</label>
                        <input type="number" name="realisasi" id="realisasi"
                            placeholder="jangan pakai koma (contoh 10000 untuk 10.000)"
                            class="w-full border p-3 rounded-lg" required>
                    </div>

                    <!-- Kategori -->
                    <select name="kategori" x-model="filter"
                        class="border rounded-lg px-3 py-2 text-sm text-gray-700">
                        <option value="">Semua Kategori</option>
                        <option value="pendapatan">Pendapatan</option>
                        <option value="belanja">Belanja</option>
                        <option value="pembiayaan">Pembiayaan</option>
                    </select>
                </div>

                <!-- Tombol aksi -->
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showAddModal = false"
                        class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 transition">Batal</button>
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Simpan</button>
                </div>
            </form>

        </x-modal>

        <!-- Modal edit -->
        <x-modal show="showEditModal" title="Edit Rincian Apbdes">
            <form :action="`{{ url('/admin/detail-apbdes/update') }}/${selectedApbdes.id_rincian}`" method="POST"
                class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Grid 2 kolom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-900 mb-6">
                    <!-- Tahun -->
                    <div class="relative w-full">
                        <label for="tahun" class="block mb-2 font-semibold">Tahun</label>
                        <select name="id_apbdes " id="tahun" x-model="selectedApbdes.tahun"
                            class="border w-full p-2 rounded-lg pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                            required>
                            <option value="">-- Pilih Tahun --</option>
                            <template x-for="item in {{ Js::from($tahun) }}" :key="item.id_apbdes">
                                <option :value="item.id_apbdes" x-text="item.tahun"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori" class="block mb-2 font-semibold">Kategori</label>
                        <select name="kategori" id="kategori" x-model="selectedApbdes.kategori"
                            class="w-full border p-3 rounded-lg" required>
                            <option value="Pendapatan">Pendapatan</option>
                            <option value="Belanja">Belanja</option>
                            <option value="Pembiayaan">Pembiayaan</option>
                        </select>
                    </div>

                    <!-- Judul -->
                    <div class="text-gray-900 md:col-span-2">
                        <label for="judul" class="block mb-2 font-semibold">Judul</label>
                        <input type="text" name="judul" id="judul" x-model="selectedApbdes.judul"
                            class="w-full border p-3 rounded-lg" placeholder="Judul kegiatan" required>
                    </div>

                    <!-- Sub Judul -->
                    <div class="text-gray-900 md:col-span-2">
                        <label for="sub_judul" class="block mb-2 font-semibold">Sub Judul / Deskripsi</label>
                        <textarea name="sub_judul" id="sub_judul" rows="4" x-model="selectedApbdes.sub_judul"
                            class="w-full border p-3 rounded-lg resize-y focus:ring-2 focus:ring-yellow-600"
                            placeholder="Masukkan sub judul atau deskripsi rinci..." required></textarea>
                    </div>

                    <!-- Anggaran -->
                    <div>
                        <label for="anggaran" class="block mb-2 font-semibold">Anggaran</label>
                        <input type="number" name="anggaran" id="anggaran"
                            :value="parseInt(selectedApbdes.anggaran.replace(/[^\d]/g, ''))"
                            class="w-full border p-3 rounded-lg" placeholder="Contoh: 5000000" required>
                    </div>

                    <!-- Realisasi -->
                    <div>
                        <label for="realisasi" class="block mb-2 font-semibold">Realisasi</label>
                        <input type="number" name="realisasi" id="realisasi"
                            :value="parseInt(selectedApbdes.realisasi.replace(/[^\d]/g, ''))"
                            class="w-full border p-3 rounded-lg" placeholder="Contoh: 4500000" required>
                    </div>


                </div>
                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-3 border-t pt-6 ">
                    <x-button type="button" @click="showEditModal = false" variant="secondary"
                        size="md">Batal</x-button>
                    <x-button type="submit">Update</x-button>
                </div>
            </form>
        </x-modal>

        <!-- Modal hapus -->
        <x-modal show="showDeleteModal" title="Hapus Berita">
            <div>
                <p class="mb-4">Apakah Anda yakin ingin menghapus rincian <strong
                        x-text="selectedApbdes?.judul ?? 'Data tidak ditemukan'"></strong>?
                </p>
            </div>
            <form :action="'detail-apbdes/delete/' + selectedApbdes.id_rincian" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-center gap-4">
                    <x-button type="button" @click="showDeleteModal = false" variant="secondary">Batal</x-button>
                    <x-button variant="danger" type="submit">Hapus</x-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-admin-layout>
