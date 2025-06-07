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
                        <x-button type='submit' variant="primary" class="absolute right-1 top-1 bottom-1">
                            Cari
                        </x-button>
                    </div>
                </form>

                <a href="{{ url()->current() }}"
                    class="bg-gray-200 hover:bg-gray-300 text-indigo-500 w-auto p-2 rounded-full text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </a>
            </div>
            {{-- Button tambah penduduk --}}
            <button @click="selectedPenduduk = null; showAddModal = true"
                class="flex items-center gap-2 bg-indigo-400 hover:bg-indigo-600 text-white px-4 py-2 rounded-full transition duration-200 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-plus-icon lucide-plus">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg>
                <span>Tambah Penduduk</span>
            </button>

        </div>

        {{-- Tabel penduduk --}}
        <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-indigo-400 text-gray-50 uppercase text-xs font-semibold tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-center">Nama</th>
                        <th class="px-4 py-3 text-center">Tanggal Lahir</th>
                        <th class="px-4 py-3 text-center">Alamat</th>
                        <th class="px-4 py-3 text-left">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50" x-show="filteredPenduduk.length > 0">
                    <template x-for="item in filteredPenduduk" :key="item.nik">
                        <tr class="even:bg-gray-50 hover:bg-gray-100">
                            <td class="px-4 py-3 text-gray-800 font-medium" x-text="item.nama"></td>
                            <td class="px-4 py-3 text-gray-600 text-center" x-text="item.tanggal_lahir"></td>
                            <td class="px-4 py-3 text-gray-600"
                                x-text="item.alamat.length > 50 ? item.alamat.slice(0, 50) + '...' : item.alamat">
                            </td>
                            <td class="px-4 py-3 text-center space-x-1 text-gray-600" x-text="item.jenis_kelamin"></td>
                            <td class="px-4 py-3 text-gray-600" x-text="item.status_tinggal"></td>
                            <td class="px-4 py-3 text-center space-x-1">
                                <!-- Detail -->
                                <button @click="selectedPenduduk = item; showDetailModal = true"
                                    class="text-blue-500 hover:text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <!-- Edit -->
                                <button @click="selectedPenduduk = {...item}; showEditModal = true"
                                    class="text-yellow-500 hover:text-yellow-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                                </button>
                                <!-- Delete -->
                                <button @click="selectedPenduduk = item; showDeleteModal = true"
                                    class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <!-- Notif -->
            <div x-show="filteredPenduduk.length === 0" class="text-center text-gray-500 py-6">
                Data penduduk tidak ditemukan.
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $penduduk->links() }}
        </div>


        {{-- modal sukses/error --}}
        <div x-data="{ showSuccess: {{ session('success') ? 'true' : 'false' }}, showError: {{ session('error') ? 'true' : 'false' }} }" x-init="setTimeout(() => {
            showSuccess = false;
            showError = false
        }, 8000)" class="fixed top-5 right-5 z-50 space-y-2">

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
                <h2 class="text-lg font-semibold text-center mb-4">Tambah Penduduk Baru</h2>
                <form action="{{ route('penduduk.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- KK --}}
                        <div class="col-span-2">
                            <label for="kode_keluarga" class="block text-sm font-medium">
                                Kode Keluarga
                            </label>
                            <input list="kodeKeluargaList" name="kode_keluarga" id="kode_keluarga"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Ketik atau pilih kode keluarga" required>
                            <datalist id="kodeKeluargaList">
                                @foreach ($daftar_keluarga as $keluarga)
                                    <option value="{{ $keluarga->kode_keluarga }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <!-- Nama -->
                        <div class="">
                            <label for="nik" class="block text-sm font-medium">NIK</label>
                            <input type="text" id="nik" name="nik" x-model="selectedPenduduk?.nik"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div class="">
                            <label for="nama" class="block text-sm font-medium">Nama</label>
                            <input type="text" id="nama" name="nama" x-model="selectedPenduduk?.nama"
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
                            <input type="text" id="tempat_lahir" name="tempat_lahir"
                                x-model="selectedPenduduk?.tempat_lahir"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                x-model="selectedPenduduk?.tanggal_lahir"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>

                        <!-- Agama & Pendidikan -->
                        <div>
                            <label for="agama" class="block text-sm font-medium">Agama</label>
                            <input type="text" id="agama" name="agama" x-model="selectedPenduduk?.agama"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="pendidikan" class="block text-sm font-medium">Pendidikan</label>
                            <select id="pendidikan" name="pendidikan" x-model="selectedPenduduk?.pendidikan"
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
                            <input type="text" id="pekerjaan" name="pekerjaan"
                                x-model="selectedPenduduk?.pekerjaan"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div class="">
                            <label for="status_perkawinan" class="block text-sm font-medium">Status Kawin</label>
                            <select id="status_perkawinan" name="status_perkawinan"
                                x-model="selectedPenduduk?.status_perkawinan"
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
                            <input type="text" id="golongan_darah" name="golongan_darah"
                                x-model="selectedPenduduk?.golongan_darah"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="kewarganegaraan" class="block text-sm font-medium">Kewarganegaraan</label>
                            <input type="text" id="kewarganegaraan" name="kewarganegaraan"
                                x-model="selectedPenduduk?.kewarganegaraan"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="hubungan" class="block text-sm font-medium">Hubungan</label>
                            <select x-model="selectedPenduduk?.hubungan" id="hubungan" name="hubungan"
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
                            <input type="text" id="alamat" name="alamat" x-model="selectedPenduduk?.alamat"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>

                        <!-- RT & RW -->
                        <div>
                            <label for="rt" class="block text-sm font-medium">RT</label>
                            <input type="text" id="rt" name="rt" x-model="selectedPenduduk?.rt"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label for="rw" class="block text-sm font-medium">RW</label>
                            <input type="text" id="rw" name="rw" x-model="selectedPenduduk?.rw"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>

                        <!-- Status Tinggal -->
                        <div class="col-span-2">
                            <label for="status_tinggal" class="block text-sm font-medium">Status Tinggal</label>
                            <select id="status_tinggal" name="status_tinggal"
                                x-model="selectedPenduduk?.status_tinggal"
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
                            class="px-4 py-2 bg-indigo-400 rounded-md text-sm text-white hover:bg-indigo-600">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- modal edit --}}
        <div x-show="showEditModal" @click.away="showEditModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4">
            <div
                class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-4 sm:p-6 space-y-4">
                <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 border-b pb-2">Edit Data Penduduk
                </h2>
                <form :action="'/admin/penduduk/' + selectedPenduduk.nik" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label for="kode_keluarga" class="block text-sm font-medium">
                                Kode Keluarga
                            </label>
                            <input list="kodeKeluargaList" name="kode_keluarga" id="kode_keluarga"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                x-model="selectedPenduduk.kode_keluarga"
                                :placeholder="selectedPenduduk?.kode_keluarga ?? 'Ketik atau pilih kode keluarga'"
                                required>
                            <datalist id="kodeKeluargaList">
                                @foreach ($daftar_keluarga as $keluarga)
                                    <option value="{{ $keluarga->kode_keluarga }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <div>
                            <label class="block text-xs text-gray-500 mb-1">NIK</label>
                            <input type="text" id="nik" name="nik" x-model="selectedPenduduk.nik"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Nama</label>
                            <input type="text" id="nama" name="nama" x-model="selectedPenduduk.nama"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
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
                        <div class="col-span-full">
                            <label for="hubungan" class="block text-sm text-gray-500 mb-1">Hubungan</label>
                            <select id="hubungan" name="hubungan" x-model="selectedPenduduk.hubungan"
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
                            <input type="text" id="tempat_lahir" name="tempat_lahir"
                                x-model="selectedPenduduk.tempat_lahir"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                x-model="selectedPenduduk.tanggal_lahir"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Agama</label>
                            <input type="text" id="agama" name="agama" x-model="selectedPenduduk.agama"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Pendidikan</label>
                            <select type="text" id="pendidikan" name="pendidikan"
                                x-model="selectedPenduduk.pendidikan" class="w-full border rounded px-3 py-2 text-sm">
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
                            <input type="text" id="pekerjaan" name="pekerjaan"
                                x-model="selectedPenduduk.pekerjaan"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Status Perkawinan</label>
                            <input type="text" id="status_perkawinan" name="status_perkawinan"
                                x-model="selectedPenduduk.status_perkawinan"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Golongan Darah</label>
                            <input type="text" id="golongan_darah" name="golongan_darah"
                                x-model="selectedPenduduk.golongan_darah"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Kewarganegaraan</label>
                            <input type="text" id="kewarganegaraan" name="kewarganegaraan"
                                x-model="selectedPenduduk.kewarganegaraan"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">RT</label>
                            <input type="number" id="rt" name="rt" x-model="selectedPenduduk.rt"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">RW</label>
                            <input type="number" id="rw" name="rw" x-model="selectedPenduduk.rw"
                                class="w-full border rounded px-3 py-2 text-sm" />
                        </div>
                        <div class="col-span-full">
                            <label class="block text-xs text-gray-500 mb-1">Status Tinggal</label>
                            <select type="text" id="status_tinggal" name="status_tinggal"
                                x-model="selectedPenduduk.status_tinggal"
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
                            <p class="font-medium text-gray-800" x-text="selectedPenduduk.status_tinggal"></p>
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
