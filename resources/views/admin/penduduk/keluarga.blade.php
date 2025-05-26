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
                const matchesSearch = item.kode_keluarga.toLowerCase().includes(this.search.toLowerCase());
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
                            class="absolute right-1 top-1 bottom-1 bg-indigo-400 hover:bg-indigo-600 text-white px-4 py-1 rounded-full text-sm">
                            Cari
                        </button>
                    </div>
                </form>

                <a href="{{ url()->current() }}"
                   class="bg-gray-200 hover:bg-gray-300 text-indigo-500 w-auto p-2 rounded-full text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </a>
            </div>
            {{-- Button tambah Keluarga --}}
            <button @click="selectedKeluarga = null; showAddModal = true"
                class="flex items-center gap-2 bg-indigo-400 hover:bg-indigo-600 text-white px-4 py-2 rounded-full transition duration-200 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-plus-icon lucide-plus">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg>
                <span>Tambah Keluarga</span>
            </button>
        </div>

        {{-- Tabel Keluarga --}}
        <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-indigo-400 text-gray-50 uppercase text-xs font-semibold tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">Kode Keluarga</th>
                        <th class="px-4 py-3 text-left">Kepala Keluarga</th>
                        <th class="px-4 py-3 text-left">Alamat</th>
                        <th class="px-6 py-3 text-center">RT</th>
                        <th class="px-6 py-3 text-center">RW</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50" x-show="filteredKeluarga.length > 0">
                    <template x-for="item in filteredKeluarga" :key="item.kode_keluarga">
                         <tr class="even:bg-gray-50 hover:bg-gray-100">
                            <td class="px-4 py-3 text-gray-800 font-medium" x-text="item.kode_keluarga"></td>
                            <td class="px-4 py-3 text-gray-600" x-text="item.kepala_keluarga"></td>
                            <td class="px-4 py-3 text-gray-600"
                                x-text="item.alamat.length > 50 ? item.alamat.slice(0, 50) + '...' : item.alamat"></td>
                            <td class="px-4 py-3 text-gray-600 text-center" x-text="item.rt"></td>
                            <td class="px-4 py-3 text-gray-600 text-center" x-text="item.rw"></td>
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
            <div x-show="filteredKeluarga.length === 0" class="text-center text-gray-500 py-6">
                Data keluarga tidak ditemukan.
            </div>
        </div>

        {{-- pagination --}}
        <div class="mt-4">
            {{ $keluarga->links() }}
        </div>

        {{-- modal sukses/error --}}
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

        {{-- Modal Tambah --}}
        <div x-show="showAddModal" @click.away="showAddModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-6">
                <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 border-b pb-2">Tambah Keluarga</h2>
                <form action="{{ route('keluarga.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <!-- Kode Keluarga & Alamat -->
                        <div>
                            <label for="kode_keluarga" class="block text-sm font-medium">Kode Keluarga</label>
                            <input type="text" id="kode_keluarga" name="kode_keluarga"
                                x-model="selectedKeluarga?.kode_keluarga"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="nik_kepala_keluarga" class="block text-sm font-medium">NIK Kepala
                                Keluarga</label>
                            <input type="text" id="nik_kepala_keluarga" name="nik_kepala_keluarga"
                                x-model="selectedKeluarga?.nik_kepala_keluarga"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="alamat" class="block text-sm font-medium">Alamat</label>
                            <input type="text" id="alamat" x-model="selectedKeluarga?.alamat" name="alamat"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>

                        <!-- RT & RW -->
                        <div>
                            <label for="rt" class="block text-sm font-medium">RT</label>
                            <input type="text" id="rt" x-model="selectedKeluarga?.rt" name="rt"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="rw" class="block text-sm font-medium">RW</label>
                            <input type="text" id="rw" x-model="selectedKeluarga?.rw" name="rw"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-6 flex justify-end gap-2">
                        <button type="button" @click="showAddModal = false"
                            class="px-4 py-2 bg-gray-200 rounded-md text-sm text-gray-700 hover:bg-gray-300">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 rounded-md text-sm text-white hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- modal detail --}}
        <div x-show="showDetailModal" @click.away="showDetailModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4">

            <div class="bg-white rounded-xl shadow-2xl max-h-screen w-full sm:max-w-3xl overflow-hidden">
                <div class="p-4 sm:p-6 flex flex-col space-y-4 max-h-[90vh] overflow-y-auto">
                    <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 border-b pb-2">
                        Detail Keluarga
                    </h2>

                    <div class="text-center">
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500">Kode Keluarga</p>
                            <p class="font-medium text-gray-800" x-text="selectedKeluarga.kode_keluarga"></p>
                        </div>

                        <div class="grid mt-4 grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                                <p class="text-xs text-gray-500">Kepala Keluarga</p>
                                <p class="font-medium text-gray-800" x-text="selectedKeluarga.kepala_keluarga"></p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                                <p class="text-xs text-gray-500">NIK Kepala Keluarga</p>
                                <p class="font-medium text-gray-800" x-text="selectedKeluarga.nik_kepala_keluarga">
                                </p>
                            </div>
                        </div>

                        <!-- Scrollable Table -->
                        <div class="bg-gray-50 rounded-lg shadow-sm mt-4 max-h-64 overflow-y-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-100 sticky top-0 z-10">
                                    <tr>
                                        <th class="p-2">NIK</th>
                                        <th class="p-2">Nama</th>
                                        <th class="p-2">Hubungan</th>
                                        <th class="p-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="anggota in selectedKeluarga.anggota" :key="anggota.nik">
                                        <tr class="border-b">
                                            <td class="p-2" x-text="anggota.nik"></td>
                                            <td class="p-2" x-text="anggota.nama"></td>
                                            <td class="p-2" x-text="anggota.hubungan"></td>
                                            <td class="p-2">
                                                <button
                                                    @click="window.location.href = `/admin/penduduk?search=${anggota.nik}`"
                                                    class="text-blue-600 hover:underline">Detail</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center pt-2">
                        <button @click="showDetailModal = false"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal edit --}}
        <div x-show="showEditModal" @click.away="showEditModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4">
            <div
                class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-4 sm:p-6 space-y-4">
                <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 border-b pb-2">Edit Data Keluarga
                </h2>
                <form :action="'/admin/keluarga/' + selectedKeluarga.kode_keluarga" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <!-- Kode Keluarga & Alamat -->
                        <div>
                            <label for="kode_keluarga" class="block text-sm font-medium">Kode Keluarga</label>
                            <input type="text" id="kode_keluarga" name="kode_keluarga"
                                x-model="selectedKeluarga?.kode_keluarga"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="nik_kepala_keluarga" class="block text-sm font-medium">NIK Kepala
                                Keluarga</label>
                            <input type="text" id="nik_kepala_keluarga" name="nik_kepala_keluarga"
                                x-model="selectedKeluarga?.nik_kepala_keluarga"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="alamat" class="block text-sm font-medium">Alamat</label>
                            <input type="text" id="alamat" x-model="selectedKeluarga?.alamat" name="alamat"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>

                        <!-- RT & RW -->
                        <div>
                            <label for="rt" class="block text-sm font-medium">RT</label>
                            <input type="text" id="rt" x-model="selectedKeluarga?.rt" name="rt"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="rw" class="block text-sm font-medium">RW</label>
                            <input type="text" id="rw" x-model="selectedKeluarga?.rw" name="rw"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                    </div>
                    <div class="text-center pt-4 space-x-2">
                        <button type="button" @click="showEditModal = false"
                            class="px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">Batal</button>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- modal hapus --}}
        <div x-show="showDeleteModal" @click.away="showDeleteModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4">
            <div class="bg-white rounded-lg shadow-xl w-96 p-6 text-center">
                <h2 class="text-xl font-semibold mb-4 text-red-600">Hapus Keluarga?</h2>
                <p class="mb-4">Apakah Anda yakin ingin menghapus keluarga dengan no KK
                    <strong x-text="selectedKeluarga.kode_keluarga"></strong>?
                </p>

                <form :action="`/admin/keluarga/${selectedKeluarga.kode_keluarga}`" method="POST" x-ref="deleteForm">
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
