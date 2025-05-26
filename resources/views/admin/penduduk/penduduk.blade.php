<x-admin-layout>
    <x-slot:title>{{ 'kelola penduduk' }}</x-slot>

    {{-- Logika tabel penduduk --}}
    <div class="p-6" x-data="{
        search: '',
        filter: '',
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
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
                    class="bg-gray-300 hover:bg-gray-400 text-black w-auto px-4 py-2 rounded-full text-sm">
                    Tampilkan Semua
                </a>
            </div>
            {{-- Button tambah penduduk --}}
            <button @click="selectedPenduduk = null; showAddModal = true"
                class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700">
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
                    <template x-for="item in filteredPenduduk" :key="item.nik">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-700" x-text="item.nama"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="item.tanggal_lahir"></td>
                            <td class="px-6 py-4 text-sm text-gray-500"
                                x-text="item.alamat.length > 50 ? item.alamat.slice(0, 50) + '...' : item.alamat"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="item.jenis_kelamin"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="item.status"></td>
                            <td class="px-6 py-4 text-center">
                                <button @click="selectedPenduduk = item; showDetailModal = true"
                                    class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="1"
                                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                        <path stroke="currentColor" stroke-width="1"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                                <button @click="selectedPenduduk = {...item}; showEditModal = true"
                                    class="text-yellow-600 hover:text-yellow-800"><svg class="w-[20px] h-[20px]"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </button>
                                <button @click="selectedPenduduk = item; showDeleteModal = true"
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
            {{ $penduduk->links() }}
        </div>

        {{-- Modal Tambah --}}
        <div x-show="showAddModal" @click.away="showAddModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-6">
                <h2 class="text-lg font-semibold text-center mb-4">Tambah Penduduk</h2>
                <form action="#" method="POST" @submit.prevent>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama -->
                        <div class="col-span-2">
                            <label for="nik" class="block text-sm font-medium">NIK</label>
                            <input type="text" id="nama" x-model="selectedPenduduk?.nik"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div class="col-span-2">
                            <label for="nama" class="block text-sm font-medium">Nama</label>
                            <input type="text" id="nama" x-model="selectedPenduduk?.nama"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium mb-1">Jenis Kelamin</label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis_kelamin" value="L"
                                        x-model="selectedPenduduk.jenis_kelamin" class="form-radio text-blue-600">
                                    <span class="ml-2 text-sm">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis_kelamin" value="P"
                                        x-model="selectedPenduduk.jenis_kelamin" class="form-radio text-pink-500">
                                    <span class="ml-2 text-sm">Perempuan</span>
                                </label>
                            </div>
                        </div>

                        <!-- Tempat & Tanggal Lahir -->
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" x-model="selectedPenduduk?.tempat_lahir"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" x-model="selectedPenduduk?.tanggal_lahir"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>

                        <!-- Agama & Pendidikan -->
                        <div>
                            <label for="agama" class="block text-sm font-medium">Agama</label>
                            <input type="text" id="agama" x-model="selectedPenduduk?.agama"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="pendidikan" class="block text-sm font-medium">Pendidikan</label>
                            <select id="pendidikan" x-model="selectedPenduduk?.pendidikan"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                                <option value="">Pilih Pendidikan</option>
                                <option value="Tidak Sekolah">Tidak Sekolah</option>
                                <option value="Belum Tamat SD">Belum Tamat SD</option>
                                <option value="SD/Sederajat">SD/Sederajat</option>
                                <option value="SMP/Sederajat">SMP/Sederajat</option>
                                <option value="SMA/Sederajat">SMA/Sederajat</option>
                                <option value="Diploma I/II">Diploma I</option>
                                <option value="Diploma I/II">Diploma II</option>
                                <option value="Diploma III">Diploma III</option>
                                <option value="Strata I (S1)/Diploma IV">Strata I (S1)/Diploma IV</option>
                                <option value="Strata II (S2)">Strata II (S2)</option>
                                <option value="Strata III (S3)">Strata III (S3)</option>
                            </select>
                        </div>

                        <!-- Pekerjaan & Status Perkawinan -->
                        <div>
                            <label for="pekerjaan" class="block text-sm font-medium">Pekerjaan</label>
                            <input type="text" id="pekerjaan" x-model="selectedPenduduk?.pekerjaan"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div class="">
                            <label for="status_perkawinan" class="block text-sm font-medium">Status Kawin</label>
                            <select x-model="selectedPenduduk?.status_perkawinan"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                                <option value="">Pilih Status Kawin</option>
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin">Kawin</option>
                                <option value="Cerai">Cerai</option>
                            </select>
                        </div>

                        <!-- Golongan Darah & Kewarganegaraan -->
                        <div>
                            <label for="golongan_darah" class="block text-sm font-medium">Golongan Darah</label>
                            <input type="text" id="golongan_darah" x-model="selectedPenduduk?.golongan_darah"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="kewarganegaraan" class="block text-sm font-medium">Kewarganegaraan</label>
                            <input type="text" id="kewarganegaraan" x-model="selectedPenduduk?.kewarganegaraan"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>

                        <!-- Kode Keluarga & Alamat -->
                        <div>
                            <label for="kode_keluarga" class="block text-sm font-medium">Kode Keluarga</label>
                            <input type="text" id="kode_keluarga" x-model="selectedPenduduk?.kode_keluarga"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium">Hubungan</label>
                            <select x-model="selectedPenduduk?.hubungan"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                                <option value="">Pilih Hubungan Keluarga</option>
                                <option value="Kepala Keluarga">Kepala Keluarga</option>
                                <option value="Suami">Suami</option>
                                <option value="Istri">Istri</option>
                                <option value="Anak">Anak</option>
                                <option value="Menantu">Menantu</option>
                                <option value="Mertua">Mertua</option>
                                <option value="Orang tua">Orang tua</option>
                                <option value="Pembantu">Pembantu</option>
                            </select>
                        </div>

                        <div>
                            <label for="alamat" class="block text-sm font-medium">Alamat</label>
                            <input type="text" id="alamat" x-model="selectedPenduduk?.alamat"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>

                        <!-- RT & RW -->
                        <div>
                            <label for="rt" class="block text-sm font-medium">RT</label>
                            <input type="text" id="rt" x-model="selectedPenduduk?.rt"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="rw" class="block text-sm font-medium">RW</label>
                            <input type="text" id="rw" x-model="selectedPenduduk?.rw"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>

                        <!-- Status Tinggal -->
                        <div>
                            <label for="status" class="block text-sm font-medium">Status Tinggal</label>
                            <select x-model="selectedPenduduk?.status"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                                <option value="Tetap">Tetap</option>
                                <option value="Pindah">Pindah</option>
                                <option value="Meninggal">Meninggal</option>
                            </select>
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

        {{-- modal edit --}}
        <div x-show="showEditModal" @click.away="showEditModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-4 sm:p-6 space-y-4">
                <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 border-b pb-2">Edit Data Penduduk
                </h2>
                <form @submit.prevent="updatePenduduk" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Kode Keluarga</label>
                            <input type="text" x-model="selectedPenduduk.kode_keluarga"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">NIK</label>
                            <input type="text" x-model="selectedPenduduk.nik"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Nama</label>
                            <input type="text" x-model="selectedPenduduk.nama"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Jenis Kelamin</label>
                            <select x-model="selectedPenduduk.jenis_kelamin"
                                class="w-full border rounded px-3 py-2 text-sm">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-span-full">
                            <label for="status" class="block text-sm text-gray-500 mb-1">Hubungan</label>
                            <select x-model="selectedPenduduk.hubungan"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                                <option value="">Pilih Hubungan Keluarga</option>
                                <option value="Kepala Keluarga">Kepala Keluarga</option>
                                <option value="Suami">Suami</option>
                                <option value="Istri">Istri</option>
                                <option value="Anak">Anak</option>
                                <option value="Menantu">Menantu</option>
                                <option value="Mertua">Mertua</option>
                                <option value="Orang tua">Orang tua</option>
                                <option value="Pembantu">Pembantu</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Tempat Lahir</label>
                            <input type="text" x-model="selectedPenduduk.tempat_lahir"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Tanggal Lahir</label>
                            <input type="date" x-model="selectedPenduduk.tanggal_lahir"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Agama</label>
                            <input type="text" x-model="selectedPenduduk.agama"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Pendidikan</label>
                            <select type="text" x-model="selectedPenduduk.pendidikan"
                                class="w-full border rounded px-3 py-2 text-sm">
                                <option value="">Pilih Pendidikan</option>
                                <option value="Tidak Sekolah">Tidak Sekolah</option>
                                <option value="Belum Tamat SD">Belum Tamat SD</option>
                                <option value="SD/Sederajat">SD/Sederajat</option>
                                <option value="SMP/Sederajat">SMP/Sederajat</option>
                                <option value="SMA/Sederajat">SMA/Sederajat</option>
                                <option value="Diploma I/II">Diploma I</option>
                                <option value="Diploma I/II">Diploma II</option>
                                <option value="Diploma III">Diploma III</option>
                                <option value="Strata I (S1)/Diploma IV">Strata I (S1)/Diploma IV</option>
                                <option value="Strata II (S2)">Strata II (S2)</option>
                                <option value="Strata III (S3)">Strata III (S3)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Pekerjaan</label>
                            <input type="text" x-model="selectedPenduduk.pekerjaan"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Status Perkawinan</label>
                            <input type="text" x-model="selectedPenduduk.status_perkawinan"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Golongan Darah</label>
                            <input type="text" x-model="selectedPenduduk.golongan_darah"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Kewarganegaraan</label>
                            <input type="text" x-model="selectedPenduduk.kewarganegaraan"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">RT</label>
                            <input type="number" x-model="selectedPenduduk.rt"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">RW</label>
                            <input type="number" x-model="selectedPenduduk.rw"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div class="col-span-full">
                            <label class="block text-xs text-gray-500 mb-1">Status Tinggal</label>
                            <select type="text" x-model="selectedPenduduk.status"
                                class="w-full border rounded px-3 py-2 text-sm">
                                <option value="Tetap">Tetap</option>
                                <option value="Pindah">Pindah</option>
                                <option value="Meninggal">Meninggal</option>
                            </select>
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
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white rounded-lg shadow-xl w-96 p-6 text-center">
                <h2 class="text-xl font-semibold mb-4 text-red-600">Hapus Penduduk?</h2>
                <p class="mb-4">Apakah Anda yakin ingin menghapus data <strong
                        x-text="selectedPenduduk.nama"></strong>?</p>
                <div class="flex justify-center gap-4">
                    <button @click="showDeleteModal = false"
                        class="px-4 py-2 bg-gray-300 rounded-lg text-sm hover:bg-gray-400">Batal</button>
                    <button @click="/* lakukan hapus */"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">Hapus</button>
                </div>
            </div>
        </div>

        {{-- modal detail --}}
        <div x-show="showDetailModal" @click.away="showDetailModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4">
            <div class="bg-white rounded-xl shadow-2xl h- p-4 sm:p-6 space-y-4">
                <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 border-b pb-2">Detail Penduduk</h2>
                <div class="text-center">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <p class="text-xs text-gray-500">Kode Keluarga</p>
                        <p class="font-medium text-gray-800" x-text="selectedPenduduk.kode_keluarga"></p>
                    </div>
                    <div class="grid mt-4 grid-cols-2 sm:grid-cols-3 gap-3">
                        <!-- Field Container -->

                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500">NIK</p>
                            <p class="font-medium text-gray-800" x-text="selectedPenduduk.nik"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500">Nama</p>
                            <p class="font-medium text-gray-800" x-text="selectedPenduduk.nama"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500">Jenis Kelamin</p>
                            <p class="font-medium text-gray-800" x-text="selectedPenduduk.jenis_kelamin"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500">Tempat, Tgl Lahir</p>
                            <p class="font-medium text-gray-800">
                                <span x-text="selectedPenduduk.tempat_lahir"></span>,
                                <span x-text="selectedPenduduk.tanggal_lahir"></span>
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500">Agama</p>
                            <p class="font-medium text-gray-800" x-text="selectedPenduduk.agama"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500">Pendidikan</p>
                            <p class="font-medium text-gray-800" x-text="selectedPenduduk.pendidikan"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500">Pekerjaan</p>
                            <p class="font-medium text-gray-800" x-text="selectedPenduduk.pekerjaan"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500">Status Perkawinan</p>
                            <p class="font-medium text-gray-800" x-text="selectedPenduduk.status_perkawinan"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500">Golongan Darah</p>
                            <p class="font-medium text-gray-800" x-text="selectedPenduduk.golongan_darah"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500">Kewarganegaraan</p>
                            <p class="font-medium text-gray-800" x-text="selectedPenduduk.kewarganegaraan"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-xs text-gray-500">RT / RW</p>
                            <p class="font-medium text-gray-800">
                                <span x-text="selectedPenduduk.rt"></span> /
                                <span x-text="selectedPenduduk.rw"></span>
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm col-span-full">
                            <p class="text-xs text-gray-500">Status Tinggal</p>
                            <p class="font-medium text-gray-800" x-text="selectedPenduduk.status"></p>
                        </div>
                    </div>
                </div>


                <div class="text-center pt-4">
                    <button @click="showDetailModal = false"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
