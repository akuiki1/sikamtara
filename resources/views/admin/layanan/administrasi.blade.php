<x-admin-layout>
    <x-slot:title>Layanan Administrasi Online</x-slot>
    {{-- logika table --}}
    <div x-data="{
        search: '',
        filterRole: '',
        filterStatus: '',
        email: '',
        showApplyModal: false,
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        selectedAdministrasi: null,
        administrasi: @js($administrasiJs),
        get filteredAdministrasi() {
            return this.administrasi.filter(item => {
                const matchesSearch = `${item.id_administrasi}`.toLowerCase().includes(this.search.toLowerCase());
                const matchesRole = this.filterRole === '' || item.role === this.filterRole;
                const matchesStatus = this.filterStatus === '' || item.status_verifikasi === this.filterStatus;
                return matchesSearch && matchesRole && matchesStatus;
            });
        }
    }">
        {{-- section card --}}
        <section>
            {{-- container card --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- card 1 --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Jumlah Layanan Tersedia</p>
                            <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $jumlahLayanan }}</h2>
                        </div>

                        <div class="text-violet-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text">
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M10 9H8" />
                                <path d="M16 13H8" />
                                <path d="M16 17H8" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- card 2 --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Jumlah Layanan Masuk</p>
                            <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $jumlahMasuk }}</h2>
                        </div>
                        <div class="text-teal-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-input-icon lucide-file-input">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M2 15h10" />
                                <path d="m9 18 3-3-3-3" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- card 3 --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Layanan Siap Tanda Tangan</p>
                            <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $jumlahSiapTtd }}</h2>
                        </div>
                        <div class="text-amber-400 scale-x-[-1]">
                            <svg class="w-[36px] h-[36px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.2"
                                    d="M18 5V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5M9 3v4a1 1 0 0 1-1 1H4m11.383.772 2.745 2.746m1.215-3.906a2.089 2.089 0 0 1 0 2.953l-6.65 6.646L9 17.95l.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z" />
                            </svg>

                        </div>
                    </div>
                </div>

                {{-- card 4 --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Jumlah Layanan Selesai tahun ini</p>
                            <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $jumlahSelesaiTahunIni }}</h2>
                        </div>
                        <div class="text-sky-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-check2-icon lucide-file-check-2">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="m3 15 2 2 4-4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        {{-- section table layanan administrasi --}}
        <section id="administrasi">
            {{-- container table --}}
            <div class="md:col-span-4 bg-white p-5 rounded-2xl shadow mt-4">

                {{-- container header --}}
                <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
                    {{-- LEFT SECTION: Search, Filter, Clear --}}
                    <div class="flex flex-wrap items-center gap-2">
                        {{-- SEARCH FORM --}}
                        <form method="GET" class="relative w-full md:w-80">
                            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                {{-- Search Icon --}}
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-width="2"
                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                </svg>
                            </span>
                            <input type="text" name="search" placeholder="Cari Layanan..."
                                value="{{ request('search') }}"
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

                    {{-- RIGHT SECTION: Tambah Layanan --}}
                    <div>
                        <x-button @click="selectedLayanan = null; showApplyModal = true">
                            {{-- Plus Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>Ajukan Layanan</span>
                        </x-button>
                        <x-button @click="selectedLayanan = null; showAddModal = true">
                            {{-- Plus Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>Tambah Layanan Baru</span>
                        </x-button>
                    </div>
                </div>

                {{-- layanan - card version --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 rounded-xl">

                    <!-- Jika tidak ada data -->
                    <template x-if="filteredAdministrasi.length === 0">
                        <div class="col-span-full text-center text-gray-500 py-6">
                            Data Administrasi tidak ditemukan.
                        </div>
                    </template>

                    <!-- Card binding alpine -->
                    <template x-for="item in filteredAdministrasi" :key="item.id_administrasi">
                        <div @click="selectedAdministrasi = item; showDetailModal = true"
                            class="cursor-pointer hover:scale-105 bg-white rounded-2xl hover:shadow-lg transition-all border border-black/10 p-6 flex flex-col justify-between h-full">
                            <div class="flex-grow">
                                <h3 class="text-2xl font-semibold text-gray-800 mb-2" x-text="item.nama_administrasi">
                                </h3>
                                <p class="text-gray-600 text-sm leading-relaxed"
                                    x-text="item.deskripsi || 'Deskripsi tidak tersedia.'"></p>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- pagination --}}
                <div class="mt-4">
                    {{ $administrasi->links() }}
                </div>
            </div>

            {{-- modal tambah --}}
            <x-modal show="showAddModal" title="Tambah Layanan Baru">
                <form x-data="{
                    docName: '',
                    fileTooLarge: false,
                
                    previewDoc(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.docName = file.name;
                            this.fileTooLarge = file.size > 2 * 1024 * 1024; // 2MB = 2 * 1024 * 1024 bytes
                        }
                    },
                
                    handleSubmit(event) {
                        if (this.fileTooLarge) {
                            alert('Ukuran file melebihi 2MB. Silakan unggah file yang lebih kecil.');
                            event.preventDefault();
                        }
                    }
                }" @submit="handleSubmit($event)"
                    action="{{ route('adminadministrasi.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    {{-- Baris 1: Nama Administrasi --}}
                    <div>
                        <label for="nama_administrasi" class="text-sm text-gray-600 mb-1 block">Nama Layanan<span
                                class="text-red-600">*</span></label>
                        <input type="text" name="nama_administrasi" id="nama_administrasi"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                            placeholder="Masukkan nama layanan" required />
                    </div>

                    {{-- Baris 2: deskripsi --}}
                    <div>
                        <label for="deskripsi" class="text-sm text-gray-600 mb-1 block">Deskripsi<span
                                class="text-red-600">*</span></label>
                        <textarea name="deskripsi" id="deskripsi" rows="6"
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition resize-none"
                            placeholder="Tulis deskripsi layanan di sini..." required></textarea>
                    </div>

                    {{-- persyaratan --}}
                    <div>
                        <label for="persyaratan" class="text-sm text-gray-600 mb-1 block">Persyaratan<span
                                class="text-red-600">*</span></label>
                        <textarea name="persyaratan" id="persyaratan" rows="6"
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition resize-none"
                            placeholder="- Persyaratan..." required oninput="formatPersyaratan(this)"></textarea>
                    </div>


                    {{-- Form Upload PDF/Word --}}
                    <div>
                        <label for="form" class="text-sm text-gray-600 mb-1 block">Form<span
                                class="text-red-600">*</span><span class="text-gray-400 text-xs font-normal"> (File
                                Pdf atau Word, Maksimal 2Mb)</span></label>
                        <div class="border border-gray-200 rounded-xl p-3 transition hover:border-gray-400">
                            <input type="file" name="form" id="form" accept=".pdf,.doc,.docx"
                                @change="previewDoc($event)"
                                class="block w-full text-sm text-gray-800 focus:outline-none focus:ring-0">
                            <template x-if="fileTooLarge">
                                <p class="mt-2 text-sm text-red-600">Ukuran file melebihi 2MB.</p>
                            </template>
                            <template x-if="docName">
                                <div class="mt-3 flex items-center space-x-2 bg-gray-100 px-4 py-2 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7 16V4a2 2 0 012-2h6a2 2 0 012 2v12m-2 4h-8a2 2 0 01-2-2v-4h12v4a2 2 0 01-2 2z" />
                                    </svg>
                                    <span x-text="docName" class="text-sm text-gray-700 truncate max-w-xs"></span>
                                </div>
                            </template>
                        </div>
                    </div>


                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                        <x-button type="button" @click="showAddModal = false" variant="secondary">Batal</x-button>
                        <x-button type="submit">Simpan</x-button>
                    </div>
                </form>
            </x-modal>

            {{-- Modal Detail --}}
            <x-modal show="showDetailModal">
                <!-- Header -->
                <div class="mb-6 space-y-1">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Detail Layanan <span x-text="selectedAdministrasi.nama_administrasi"></span>
                    </h2>
                    <p class="text-sm text-gray-500">Lihat informasi lengkap dan kelola data layanan administrasi.</p>
                </div>

                <!-- Konten Utama -->
                <div class="space-y-6">
                    <!-- Tombol Unduh -->
                    <div class="">
                        <a :href="'/storage/' + selectedAdministrasi.form" download
                            class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out bg-indigo-400 hover:bg-indigo-600 text-white text-sm px-4 py-2">
                            <!-- Icon Download -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                            </svg>
                            Unduh Formulir Pengisian
                        </a>
                    </div>


                    <!-- Deskripsi -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Deskripsi</h3>
                        <p class="text-gray-700 leading-relaxed" x-text="selectedAdministrasi.deskripsi_full"></p>
                    </div>

                    <!-- Persyaratan -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Persyaratan</h3>
                        <p class="text-gray-700 leading-relaxed"
                            x-html="selectedAdministrasi.persyaratan.replaceAll('\n', '<br>')">
                        </p>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                    <x-button type="button" @click="showDetailModal = false; showApplyModal = true">
                        Apply
                    </x-button>
                    <x-button type="button" @click="showDetailModal = false" variant="secondary">
                        Tutup
                    </x-button>

                    <x-button variant="warning" @click="showDetailModal = false; showEditModal = true">
                        Edit
                    </x-button>

                    <x-button variant="danger" @click="showDetailModal = false; showDeleteModal = true">
                        Hapus
                    </x-button>
                </div>
            </x-modal>

            {{-- Modal Edit --}}
            <x-modal show="showEditModal">
                <!-- Tombol Panah Kembali -->
                <div class="flex items-center mb-8">
                    <button type="button" @click="showEditModal = false; showDetailModal = true"
                        class="flex items-center text-gray-600 hover:text-indigo-600 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 18l-6-6 6-6" />
                        </svg>
                        <span>Kembali</span>
                    </button>
                </div>

                <form x-data="{
                    fileName: '',
                    fileTooLarge: false,
                
                    previewFile() {
                        const file = this.$refs.fileInput.files[0];
                        if (file) {
                            this.fileName = file.name;
                            this.fileTooLarge = file.size > 2 * 1024 * 1024;
                        } else {
                            this.fileTooLarge = false;
                        }
                    },
                
                    clearFile() {
                        this.fileName = '';
                        this.$refs.fileInput.value = '';
                        this.fileTooLarge = false;
                    },
                
                    handleSubmit(e) {
                        if (this.fileTooLarge) {
                            alert('Ukuran file terlalu besar. Maksimal 2MB.');
                            e.preventDefault();
                            return false;
                        }
                    }
                }" @submit="handleSubmit($event)" method="POST"
                    :action="'/admin/layanan/administrasi/' + selectedAdministrasi.id_administrasi"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <!-- Header -->
                    <div class="relative w-full mb-6">
                        <label for="nama_administrasi"
                            class="absolute -top-2 left-3 bg-white px-1 text-sm text-gray-500 transition-all peer-focus:-top-3 peer-focus:text-xs peer-focus:text-indigo-500">
                            Nama Layanan<span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="nama_administrasi"
                            class="peer px-4 pt-3 pb-2 border border-gray-300 rounded-xl text-gray-900 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 text-2xl font-bold w-full"
                            :value="selectedAdministrasi.nama_administrasi">
                    </div>

                    <!-- Form Upload (Gunakan $refs dan state dari x-data di form) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Formulir Administrasi
                            <span class="text-xs text-gray-400 font-normal">(unggah untuk mengganti)</span>
                        </label>

                        <!-- Input File (Hidden) -->
                        <input x-ref="fileInput" type="file" name="form" accept=".pdf,.doc,.docx"
                            class="hidden" @change="previewFile()">

                        <!-- Baris Tombol & Info -->
                        <div class="flex items-center gap-4">
                            <!-- Tombol Upload -->
                            <x-button type="button" variant="primary" @click="$refs.fileInput.click()"
                                class="flex items-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 3v12m5-7-5-5-5 5M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                                </svg>
                                <span class="ml-2">Unggah Form Baru</span>
                            </x-button>

                            <!-- Info File Baru -->
                            <template x-if="fileName">
                                <div
                                    class="flex items-center gap-2 px-2 py-1 text-sm text-blue-700 bg-blue-50 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-paperclip-icon lucide-paperclip">
                                        <path d="M13.234 20.252 21 12.3" />
                                        <path
                                            d="m16 6-8.414 8.586a2 2 0 0 0 0 2.828 2 2 0 0 0 2.828 0l8.414-8.586a4 4 0 0 0 0-5.656 4 4 0 0 0-5.656 0l-8.415 8.585a6 6 0 1 0 8.486 8.486" />
                                    </svg>
                                    <span class="font-medium"
                                        x-text="fileName.length > 25 ? fileName.slice(0, 25) + '...' : fileName"></span>

                                    <!-- Tombol X -->
                                    <button type="button" @click="clearFile()"
                                        class="text-blue-400 hover:text-red-500 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <!-- Info File Lama -->
                            <template x-if="!fileName && selectedAdministrasi.name_form_edit">
                                <div
                                    class="flex items-center gap-2 px-2 py-1 text-sm text-gray-700 bg-gray-50 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-paperclip-icon lucide-paperclip">
                                        <path d="M13.234 20.252 21 12.3" />
                                        <path
                                            d="m16 6-8.414 8.586a2 2 0 0 0 0 2.828 2 2 0 0 0 2.828 0l8.414-8.586a4 4 0 0 0 0-5.656 4 4 0 0 0-5.656 0l-8.415 8.585a6 6 0 1 0 8.486 8.486" />
                                    </svg>
                                    <span class="font-medium" x-text="selectedAdministrasi.name_form_edit"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Pesan error jika terlalu besar -->
                        <template x-if="fileTooLarge">
                            <p class="text-sm text-red-600 mt-2">Ukuran file melebihi 2MB. Silakan pilih file lain.</p>
                        </template>
                    </div>


                    <!-- Deskripsi -->
                    <div class="relative w-full mb-6">
                        <label
                            class="absolute -top-2 left-3 bg-white px-1 text-sm text-gray-500 transition-all peer-focus:-top-3 peer-focus:text-xs peer-focus:text-indigo-500">
                            Deskripsi<span class="text-red-600">*</span>
                        </label>
                        <textarea name="deskripsi" rows="8"
                            class="peer px-4 pt-5 pb-2 w-full text-base border border-gray-300 rounded-xl text-gray-900 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400"
                            x-text="selectedAdministrasi.deskripsi_full"></textarea>
                    </div>

                    <!-- Persyaratan -->
                    <div class="relative w-full mb-6">
                        <label
                            class="absolute -top-2 left-3 bg-white px-1 text-sm text-gray-500 transition-all peer-focus:-top-3 peer-focus:text-xs peer-focus:text-indigo-500">
                            Persyaratan<span class="text-red-600">*</span></span>
                        </label>
                        <textarea name="persyaratan" rows="8"
                            class="peer px-4 pt-5 pb-2 w-full text-base border border-gray-300 rounded-xl text-gray-900 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400"
                            x-text="selectedAdministrasi.persyaratan"></textarea>
                    </div>

                    <!-- CTA -->
                    <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                        <x-button type="button" @click="showEditModal = false" variant="secondary">
                            Batal
                        </x-button>

                        <x-button type="submit" variant="primary">
                            Simpan Perubahan
                        </x-button>
                    </div>
                </form>
            </x-modal>

            <!-- Modal hapus -->
            <x-modal show="showDeleteModal" title="Hapus Layanan">
                <div>
                    <p class="mb-4">Apakah Anda yakin ingin menghapus layanan untuk <strong
                            x-text="selectedAdministrasi.nama_administrasi"></strong> ?
                    </p>
                </div>
                <form :action="'/admin/layanan/administrasi/' + selectedAdministrasi.id_administrasi" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-center gap-4">
                        <x-button type="button" @click="showDeleteModal = false" variant="secondary">
                            Batal
                        </x-button>
                        <x-button variant="danger" type="submit">Hapus</x-button>
                    </div>
                </form>
            </x-modal>

            {{-- modal apply --}}
            <x-modal show="showApplyModal">

                <form x-data="{
                    formFile: null,
                    lampiranFile: null,
                
                    checkFileSize(file) {
                        return file && file.size <= 2 * 1024 * 1024; // Max 2MB
                    },
                
                    handleSubmit(event) {
                        if (!this.checkFileSize(this.formFile)) {
                            alert('Ukuran file Formulir melebihi 2MB.');
                            event.preventDefault();
                            return;
                        }
                        if (!this.checkFileSize(this.lampiranFile)) {
                            alert('Ukuran file Lampiran melebihi 2MB.');
                            event.preventDefault();
                            return;
                        }
                    }
                }" @submit="handleSubmit" method="POST"
                    :action="`{{ url('admin/layanan/administrasi/apply') }}/${selectedAdministrasi.id_administrasi}`"
                    enctype="multipart/form-data">

                    @csrf

                    <!-- Header -->
                    <div class="mb-6 space-y-1">
                        <h2 class="text-2xl font-bold text-gray-900">
                            Formulir pengajuan surat <span x-text="selectedAdministrasi.nama_administrasi"></span>
                        </h2>
                        <p class="text-sm text-gray-500">Pastikan anda sudah mengunduh dan mengisi formulir di bawah
                            ini.
                        </p>
                        <div class="">
                            <a :href="'/storage/' + selectedAdministrasi.form" download
                                class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out bg-indigo-400 hover:bg-indigo-600 text-white text-sm px-4 py-2">
                                <!-- Icon Download -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                </svg>
                                Unduh Formulir Pengisian
                            </a>
                            <div class="py-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">Persyaratan</h3>
                                <p class="text-gray-700 leading-relaxed"
                                    x-html="selectedAdministrasi.persyaratan.replaceAll('\n', '<br>')">
                                </p>
                            </div>
                        </div>

                        {{-- File Form --}}
                        <div x-data="{
                            fileName: '',
                            clearFile() {
                                this.fileName = '';
                                this.$refs.fileInput.value = '';
                            }
                        }" class="py-4">

                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Formulir yang sudah diisi<span class="text-red-600">*</span>
                                <span class="text-xs text-gray-400 font-normal">(pdf, doc, docx. maks 2mb)</span>
                            </label>

                            <!-- Input File (Hidden) -->
                            <input x-ref="fileInput" type="file" name="form" accept=".pdf,.doc,.docx"
                                class="hidden"
                                @change="fileName = $refs.fileInput.files[0]?.name; formFile = $refs.fileInput.files[0]">


                            <!-- Baris Tombol & Info -->
                            <div class="flex items-center gap-4">
                                <!-- Tombol Upload -->
                                <x-button type="button" variant="primary" @click="$refs.fileInput.click()"
                                    class="flex items-center">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M12 3v12m5-7-5-5-5 5M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                                    </svg>
                                    <span class="ml-2">Upload Form</span>
                                </x-button>

                                <!-- Info File Baru -->
                                <template x-if="fileName">
                                    <div
                                        class="flex items-center gap-2 px-2 py-1 text-sm text-blue-700 bg-blue-50 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-paperclip-icon lucide-paperclip">
                                            <path d="M13.234 20.252 21 12.3" />
                                            <path
                                                d="m16 6-8.414 8.586a2 2 0 0 0 0 2.828 2 2 0 0 0 2.828 0l8.414-8.586a4 4 0 0 0 0-5.656 4 4 0 0 0-5.656 0l-8.415 8.585a6 6 0 1 0 8.486 8.486" />
                                        </svg>
                                        <span class="font-medium"
                                            x-text="fileName.length > 25 ? fileName.slice(0, 25) + '...' : fileName"></span>

                                        <!-- Tombol X -->
                                        <button type="button" @click="clearFile()"
                                            class="text-blue-400 hover:text-red-500 transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- File Lampiran --}}
                        <div x-data="{
                            fileName: '',
                            clearFile() {
                                this.fileName = '';
                                this.$refs.fileInput.value = '';
                            }
                        }" class="py-4">

                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Lampirkan persyaratan<span class="text-red-600">*</span>
                                <span class="text-xs text-gray-400 font-normal">(pdf, doc, docx. maks 2mb)</span>
                            </label>

                            <!-- Input File (Hidden) -->
                            <input x-ref="fileInput" type="file" name="lampiran" accept=".pdf,.doc,.docx"
                                class="hidden"
                                @change="fileName = $refs.fileInput.files[0]?.name; lampiranFile = $refs.fileInput.files[0]">

                            <!-- Baris Tombol & Info -->
                            <div class="flex items-center gap-4">
                                <!-- Tombol Upload -->
                                <x-button type="button" variant="primary" @click="$refs.fileInput.click()"
                                    class="flex items-center">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M12 3v12m5-7-5-5-5 5M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                                    </svg>
                                    <span class="ml-2">Upload Lampiran</span>
                                </x-button>

                                <!-- Info File Baru -->
                                <template x-if="fileName">
                                    <div
                                        class="flex items-center gap-2 px-2 py-1 text-sm text-blue-700 bg-blue-50 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-paperclip-icon lucide-paperclip">
                                            <path d="M13.234 20.252 21 12.3" />
                                            <path
                                                d="m16 6-8.414 8.586a2 2 0 0 0 0 2.828 2 2 0 0 0 2.828 0l8.414-8.586a4 4 0 0 0 0-5.656 4 4 0 0 0-5.656 0l-8.415 8.585a6 6 0 1 0 8.486 8.486" />
                                        </svg>
                                        <span class="font-medium"
                                            x-text="fileName.length > 25 ? fileName.slice(0, 25) + '...' : fileName"></span>

                                        <!-- Tombol X -->
                                        <button type="button" @click="clearFile()"
                                            class="text-blue-400 hover:text-red-500 transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                            <x-button type="button" @click="showApplyModal = false" variant="secondary"
                                class="flex items-center gap-2">
                                Batal
                            </x-button>

                            <x-button type="submit" variant="primary" class="flex items-center gap-2">
                                Ajukan Sekarang
                            </x-button>
                        </div>
                </form>
            </x-modal>
        </section>

        {{-- section layanan masuk & riwayat layanan --}}
        <section id="riwayatLayanan">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">

                {{-- container tabel pengajuan Masuk --}}
                <div id="pengajuanMasuk" x-data="{
                    layanan: {{ $layananMasuk }},
                    selected: null,
                }"
                    class="md:col-span-2 bg-white p-5 rounded-2xl shadow space-y-4">

                    {{-- Header --}}
                    <h2 class="text-lg font-semibold">Layanan Masuk</h2>

                    {{-- Daftar Layanan --}}
                    <div>
                        <template x-if="layanan.length === 0">
                            <div class="text-center text-gray-500 italic py-4">
                                Belum ada pengajuan masuk.
                            </div>
                        </template>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="layanan.length > 0">
                            <template x-for="item in layanan" :key="item.id">
                                <div @click="selected = item"
                                    class="cursor-pointer p-4 bg-gray-100 rounded-xl border-l-4 hover:border-blue-500 hover:bg-blue-50"
                                    :class="{ 'border-blue-600 bg-blue-50': selected?.id === item.id }">
                                    <h3 class="font-semibold text-gray-800" x-text="item.nama_layanan"></h3>
                                    <p class="text-sm text-gray-600">Pengguna: <span x-text="item.nama_user"></span>
                                    </p>
                                    <p class="text-sm text-gray-600">Tanggal: <span
                                            x-text="item.tanggal_pengajuan"></span></p>
                                    <p class="text-sm text-gray-600">Status:
                                        <span class="px-2 py-1 rounded text-white text-xs"
                                            :class="{
                                                'bg-yellow-500': item.status === 'baru',
                                                'bg-indigo-500': item.status === 'ditinjau',
                                                'bg-green-500': item.status === 'diproses',
                                                'bg-red-500': item.status === 'ditolak'
                                            }"
                                            x-text="item.status">
                                        </span>
                                    </p>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Detail Modal --}}
                    <x-modal show="selected">
                        <div class="rounded-2xl space-y-6 max-w-md mx-auto">
                            <!-- Header -->
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-gray-800">Detail Layanan</h3>
                                <button @click="selected = null" class="text-gray-400 hover:text-gray-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Detail Info -->
                            <div class="space-y-2 text-sm text-gray-600">
                                <p>
                                    <span class="font-medium text-gray-700">Nama Layanan:</span><br>
                                    <span class="text-gray-800" x-text="selected.nama_layanan"></span>
                                </p>
                                <p>
                                    <span class="font-medium text-gray-700">Pengguna:</span><br>
                                    <span class="text-gray-800" x-text="selected.nama_user"></span>
                                </p>
                                <p>
                                    <span class="font-medium text-gray-700">Tanggal Pengajuan:</span><br>
                                    <span class="text-gray-800" x-text="selected.tanggal_pengajuan"></span>
                                </p>
                                <p>
                                    <span class="font-medium text-gray-700">Status:</span><br>
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full text-white"
                                        :class="{
                                            'bg-yellow-500': selected.status === 'baru',
                                            'bg-indigo-500': selected.status === 'ditinjau',
                                            'bg-green-600': selected.status === 'diproses',
                                            'bg-red-500': selected.status === 'ditolak',
                                            'bg-gray-500': selected.status === 'selesai',
                                        }"
                                        x-text="selected.status">
                                    </span>
                                </p>
                            </div>

                            <!-- File Links -->
                            <div class="space-y-1 text-sm">
                                <div class="space-y-2">
                                    <!-- Formulir -->
                                    <template x-if="selected.form">
                                        <a :href="'/storage/' + selected.form" target="_blank"
                                            class="flex items-center justify-between p-3 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition group">
                                            <div class="flex items-center gap-3">
                                                <!-- Icon -->
                                                <svg class="w-5 h-5 text-indigo-500 group-hover:text-indigo-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                <span
                                                    class="text-sm font-medium text-indigo-700 group-hover:text-indigo-900">
                                                    Lihat Formulir
                                                </span>
                                            </div>
                                            <span
                                                class="text-xs text-indigo-400 group-hover:text-indigo-600">PDF</span>
                                        </a>
                                    </template>

                                    <!-- Lampiran -->
                                    <template x-if="selected.lampiran">
                                        <a :href="'/storage/' + selected.lampiran" target="_blank"
                                            class="flex items-center justify-between p-3 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition group">
                                            <div class="flex items-center gap-3">
                                                <!-- Icon -->
                                                <svg class="w-5 h-5 text-indigo-500 group-hover:text-indigo-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.172 7l-6.586 6.586a2 2 0 1 0 2.828 2.828L18 9.828a4 4 0 1 0-5.656-5.656L7 9" />
                                                </svg>
                                                <span
                                                    class="text-sm font-medium text-indigo-700 group-hover:text-indigo-900">
                                                    Lihat Lampiran
                                                </span>
                                            </div>
                                            <span
                                                class="text-xs text-indigo-400 group-hover:text-indigo-600">File</span>
                                        </a>
                                    </template>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                                <!-- Form tersembunyi -->
                                <form x-ref="statusForm" method="POST"
                                    action="{{ route('layanan.updateStatus') }}">
                                    @csrf
                                    <input type="hidden" name="id" :value="selected?.id">
                                    <input type="hidden" name="status" x-ref="statusInput">

                                    <!-- Tombol ACC -->
                                    <button
                                        @click.prevent="$refs.statusInput.value = 'diproses'; $refs.statusForm.submit()"
                                        class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out hover:scale-105 bg-indigo-400 hover:bg-indigo-600 text-white text-sm px-4 py-2">
                                        ACC
                                    </button>

                                    <!-- Tombol Tolak -->
                                    <button
                                        @click.prevent="$refs.statusInput.value = 'ditolak'; $refs.statusForm.submit()"
                                        class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out hover:scale-105 bg-red-400 hover:bg-red-500 text-white text-sm px-4 py-2">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    </x-modal>
                </div>

                {{-- container tabel pengajuan di proses --}}
                <div id="pengajuanDiproses" class="md:col-span-2 bg-white p-5 rounded-2xl shadow space-y-4"
                    x-data="{ layanan: @js($layananDiproses), selected: null }">

                    <h2 class="text-lg font-semibold">Layanan Diproses</h2>

                    {{-- Daftar Layanan --}}
                    <div>
                        <template x-if="layanan.length === 0">
                            <div class="text-center text-gray-500 italic py-4">
                                Belum ada layanan diproses.
                            </div>
                        </template>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="layanan.length > 0">
                            <template x-for="item in layanan" :key="item.id">
                                <div @click="selected = item"
                                    class="cursor-pointer p-4 bg-gray-100 rounded-xl border-l-4 hover:border-blue-500 hover:bg-blue-50"
                                    :class="{ 'border-blue-600 bg-blue-50': selected?.id === item.id }">
                                    <h3 class="font-semibold text-gray-800" x-text="item.nama_layanan"></h3>
                                    <p class="text-sm text-gray-600">Pengguna: <span x-text="item.nama_user"></span>
                                    </p>
                                    <p class="text-sm text-gray-600">Tanggal: <span
                                            x-text="item.tanggal_pengajuan"></span></p>
                                    <p class="text-sm text-gray-600">Status:
                                        <span class="px-2 py-1 rounded text-white text-xs"
                                            :class="{
                                                'bg-yellow-500': item.status === 'baru',
                                                'bg-indigo-500': item.status === 'ditinjau',
                                                'bg-green-500': item.status === 'diproses',
                                                'bg-red-500': item.status === 'ditolak'
                                            }"
                                            x-text="item.status">
                                        </span>
                                    </p>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Modal --}}
                    <x-modal show="selected">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-semibold text-gray-800">Detail Layanan</h3>
                            <button @click="selected = null" class="text-gray-400 hover:text-gray-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Informasi -->
                        <div class="space-y-2 text-sm text-gray-600">
                            <p><strong>Nama Layanan:</strong><br><span x-text="selected.nama_layanan"></span></p>
                            <p><strong>Pengguna:</strong><br><span x-text="selected.nama_user"></span></p>
                            <p><strong>Tanggal Pengajuan:</strong><br><span x-text="selected.tanggal_pengajuan"></span>
                            </p>
                            <p><strong>Status:</strong><br>
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full text-white"
                                    :class="{
                                        'bg-yellow-500': selected.status === 'baru',
                                        'bg-indigo-500': selected.status === 'ditinjau',
                                        'bg-green-600': selected.status === 'diproses',
                                        'bg-red-500': selected.status === 'ditolak',
                                        'bg-gray-500': selected.status === 'selesai',
                                    }"
                                    x-text="selected.status">
                                </span>
                            </p>
                        </div>
                        <!-- Upload Surat Final -->
                        <form x-show="selected" x-data="{
                            fileName: '',
                            fileTooLarge: false,
                            validateFile(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    this.fileName = file.name;
                                    this.fileTooLarge = file.size > 2 * 1024 * 1024;
                                } else {
                                    this.fileName = '';
                                    this.fileTooLarge = false;
                                }
                            },
                            handleSubmit(event) {
                                if (this.fileTooLarge) {
                                    alert('Ukuran file melebihi 2MB. Harap unggah file yang lebih kecil.');
                                    event.preventDefault();
                                }
                            }
                        }" @submit="handleSubmit($event)"
                            :action="`/admin/upload-surat-final/${selected.id}`" method="POST"
                            enctype="multipart/form-data" class="space-y-4 mt-6">
                            @csrf

                            <label for="surat_final" class="block text-sm font-medium text-gray-700">
                                Upload Surat Final<span class="text-red-500">*</span>
                                <small class="block text-xs font-normal text-gray-400">Format: PDF, DOC, DOCX • Maks
                                    2MB</small>
                            </label>

                            <input id="surat_final" type="file" name="surat_final" required
                                accept=".pdf,.doc,.docx" @change="validateFile($event)"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200" />

                            <!-- Pesan error -->
                            <template x-if="fileTooLarge">
                                <p class="text-sm text-red-600">Ukuran file terlalu besar. Maksimal 2MB.</p>
                            </template>

                            <div class="flex justify-end pt-6 mt-8 border-t border-gray-200">
                                <x-button type="submit">Selesaikan</x-button>
                            </div>
                        </form>
                    </x-modal>
                </div>

                {{-- container tabel Riwayat Layanan --}}
                <div id="pengajuanRiwayat" class="md:col-span-4 bg-white p-6 rounded-2xl shadow mt-6">
                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Riwayat Layanan</h2>
                    </div>

                    {{-- Filter & Search --}}
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mb-6">
                        {{-- Search --}}
                        <form method="GET" class="relative w-full md:w-80">
                            <input type="text" name="search_riwayat" value="{{ request('search_riwayat') }}"
                                class="pl-10 pr-24 py-2 w-full rounded-xl border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                                placeholder="Cari layanan..." />
                            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2"
                                        d="M21 21l-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                </svg>
                            </span>
                            <button type="submit"
                                class="absolute right-1 top-1 bottom-1 bg-indigo-500 hover:bg-indigo-600 text-white text-sm px-4 py-1 rounded-xl">
                                Cari
                            </button>
                        </form>
                        {{-- Filter Dropdown --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 relative">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2"
                                        d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                                </svg>
                                Filter
                            </button>

                            {{-- Panel --}}
                            <div x-show="open" @click.outside="open = false" x-transition
                                class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-10 z-50 p-4 space-y-4">
                                <form method="GET" class="space-y-4">
                                    <input type="hidden" name="search_riwayat"
                                        value="{{ request('search_riwayat') }}">

                                    <div>
                                        <label for="status_pengajuan"
                                            class="block text-sm font-medium text-gray-700">Status
                                            Pengajuan</label>
                                        <select id="status_pengajuan" name="status_pengajuan"
                                            class="mt-1 block w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                            <option value="">Semua Status</option>
                                            <option value="selesai"
                                                {{ request('status_pengajuan') == 'selesai' ? 'selected' : '' }}>
                                                Selesai</option>
                                            <option value="ditolak"
                                                {{ request('status_pengajuan') == 'ditolak' ? 'selected' : '' }}>
                                                Ditolak</option>
                                        </select>
                                    </div>

                                    <x-button type="submit" class="w-full justify-center">Terapkan Filter</x-button>
                                </form>
                            </div>
                        </div>
                        {{-- Clear Filter --}}
                        @if (request()->has('search_riwayat') || request()->has('status_pengajuan'))
                            <a href="{{ url()->current() }}"
                                class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-400 text-gray-600 rounded-xl">
                                Tampilkan Semua
                            </a>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div x-data="{
                        layanan: @js($layananRiwayat),
                        selected: null,
                    
                        hapusLayanan(id) {
                            if (confirm('Yakin ingin menghapus pengaduan ini?')) {
                                fetch(`/admin/layanan/hapus/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                                    }
                                }).then(response => {
                                    if (response.ok) {
                                        this.layanan = this.layanan.filter(item => item.id !== id);
                                        this.selected = null;
                                    } else {
                                        alert('Gagal menghapus data.');
                                    }
                                });
                            }
                        }
                    }">

                        {{-- content null --}}
                        <template x-if="layanan.length === 0">
                            <div class="text-center text-gray-400 italic py-10">Belum ada riwayat layanan.</div>
                        </template>

                        {{-- content --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 cursor-pointer"
                            x-show="layanan.length > 0">
                            <template x-for="item in layanan" :key="item.id">
                                <div @click="selected = item"
                                    class="relative bg-white border border-gray-200 rounded-2xl shadow-lg p-5 transition hover:shadow-xl">
                                    <!-- Badge Status -->
                                    <div class="absolute top-4 right-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white"
                                            :class="{
                                                'bg-green-600': item.status === 'selesai',
                                                'bg-red-500': item.status === 'ditolak'
                                            }"
                                            x-text="item.status">
                                        </span>
                                    </div>

                                    <!-- Content -->
                                    <h3 class="text-lg font-semibold text-gray-800 mb-1" x-text="item.nama_layanan">
                                    </h3>
                                    <p class="text-sm text-gray-500 mb-1">
                                        <span class="font-medium text-gray-700">Pengguna:</span>
                                        <span x-text="item.nama_user"></span>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <span class="font-medium text-gray-700">Tanggal:</span>
                                        <span x-text="item.tanggal_pengajuan"></span>
                                    </p>
                                </div>
                            </template>
                        </div>

                        {{-- modal detail --}}
                        <x-modal show="selected">
                            <div class="rounded-2xl space-y-6 max-w-md mx-auto">
                                <!-- Header -->
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xl font-semibold text-gray-800">Detail Layanan</h3>
                                    <button @click="selected = null"
                                        class="text-gray-400 hover:text-gray-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Detail Info -->
                                <div class="space-y-2 text-sm text-gray-600">
                                    <p>
                                        <span class="font-medium text-gray-700">Nama Layanan:</span><br>
                                        <span class="text-gray-800" x-text="selected.nama_layanan"></span>
                                    </p>
                                    <p>
                                        <span class="font-medium text-gray-700">Pengguna:</span><br>
                                        <span class="text-gray-800" x-text="selected.nama_user"></span>
                                    </p>
                                    <p>
                                        <span class="font-medium text-gray-700">Tanggal Pengajuan:</span><br>
                                        <span class="text-gray-800" x-text="selected.tanggal_pengajuan"></span>
                                    </p>
                                    <p>
                                        <span class="font-medium text-gray-700">Status:</span><br>
                                        <span
                                            class="inline-block px-2 py-1 text-xs font-semibold rounded-full text-white"
                                            :class="{
                                                'bg-yellow-500': selected.status === 'baru',
                                                'bg-indigo-500': selected.status === 'ditinjau',
                                                'bg-green-600': selected.status === 'diproses',
                                                'bg-red-500': selected.status === 'ditolak',
                                                'bg-gray-500': selected.status === 'selesai',
                                            }"
                                            x-text="selected.status">
                                        </span>
                                    </p>
                                </div>

                                <!-- File Links -->
                                <div class="space-y-1 text-sm">
                                    <div class="space-y-2">
                                        <!-- Formulir -->
                                        <template x-if="selected.form">
                                            <a :href="'/storage/' + selected.form" target="_blank"
                                                class="flex items-center justify-between p-3 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition group">
                                                <div class="flex items-center gap-3">
                                                    <!-- Icon -->
                                                    <svg class="w-5 h-5 text-indigo-500 group-hover:text-indigo-600"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    <span
                                                        class="text-sm font-medium text-indigo-700 group-hover:text-indigo-900">
                                                        Lihat Formulir
                                                    </span>
                                                </div>
                                                <span
                                                    class="text-xs text-indigo-400 group-hover:text-indigo-600">PDF</span>
                                            </a>
                                        </template>

                                        <!-- Lampiran -->
                                        <template x-if="selected.lampiran">
                                            <a :href="'/storage/' + selected.lampiran" target="_blank"
                                                class="flex items-center justify-between p-3 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition group">
                                                <div class="flex items-center gap-3">
                                                    <!-- Icon -->
                                                    <svg class="w-5 h-5 text-indigo-500 group-hover:text-indigo-600"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.172 7l-6.586 6.586a2 2 0 1 0 2.828 2.828L18 9.828a4 4 0 1 0-5.656-5.656L7 9" />
                                                    </svg>
                                                    <span
                                                        class="text-sm font-medium text-indigo-700 group-hover:text-indigo-900">
                                                        Lihat Lampiran
                                                    </span>
                                                </div>
                                                <span
                                                    class="text-xs text-indigo-400 group-hover:text-indigo-600">File</span>
                                            </a>
                                        </template>

                                        {{-- surat final --}}
                                        <template x-if="selected.surat_final">
                                            <a :href="'/storage/' + selected.surat_final" target="_blank"
                                                class="flex items-center justify-between p-3 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition group">
                                                <div class="flex items-center gap-3">
                                                    <!-- Icon -->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-5 h-5 text-indigo-500 group-hover:text-indigo-600"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M20 8.94a1.31 1.31 0 0 0-.06-.27v-.09a1.07 1.07 0 0 0-.19-.28l-6-6a1.07 1.07 0 0 0-.28-.19h-.09L13.06 2H7a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V8.94Zm-6-3.53L16.59 8H14ZM18 19a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h5v5a1 1 0 0 0 1 1h5Z" />
                                                    </svg>
                                                    <span
                                                        class="text-sm font-medium text-indigo-700 group-hover:text-indigo-900">
                                                        Lihat Surat Final
                                                    </span>
                                                </div>
                                                <span
                                                    class="text-xs text-indigo-400 group-hover:text-indigo-600">PDF</span>
                                            </a>
                                        </template>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                                    <x-button variant="secondary" @click="selected = null">Tutup</x-button>

                                    <!-- Tampilkan tombol hapus hanya jika status ditolak -->
                                    <template x-if="selected.status === 'ditolak'">
                                        <x-button variant="danger" @click="hapusLayanan(selected.id)">
                                            Hapus
                                        </x-button>
                                    </template>
                                </div>
                            </div>
                        </x-modal>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function formatPersyaratan(textarea) {
            let lines = textarea.value.split('\n');
            let formatted = lines.map(line => {
                line = line.trimStart();
                if (line === '') return '';
                return line.startsWith('-') ? line : `- ${line}`;
            }).join('\n');
            textarea.value = formatted;
        }
    </script>
</x-admin-layout>
