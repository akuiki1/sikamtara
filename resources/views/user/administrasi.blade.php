<x-layout>

    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-9 px-6 text-center">
    </section>

    {{-- section inti --}}
    <section class="px-10 pt-10 bg-gray-50" x-data="{
        search: '',
        filterRole: '',
        filterStatus: '',
        email: '',
        showPassword: false,
        showPassword2: false,
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
        {{-- container card --}}
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- card 1 --}}
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Jumlah layanan yang saya ajukan</p>
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
                        <p class="text-gray-500 text-sm">Jumlah layanan saya yang terkirim</p>
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
                        <p class="text-gray-500 text-sm">Menunggu tanda tangan</p>
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
                        <p class="text-gray-500 text-sm">Jumlah layanan saya yang selesai</p>
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
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
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
            </div>

            {{-- layanan - card version --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 rounded-xl">

                <!-- Jika tidak ada data -->
                <template x-if="filteredAdministrasi.length === 0">
                    <div class="col-span-full text-center text-gray-500 py-6 space-y-4" x-data="{ modalOpen: false }">
                        <p class="text-sm sm:text-base">Layanan Administrasi tidak ditemukan.</p>

                        <!-- Tombol Hubungi Admin -->
                        <x-button @click="modalOpen = true" class="hover:scale-105 hover:shadow">
                            Hubungi Admin
                        </x-button>

                        <!-- Modal ditransfer ke <body> -->
                        <template x-teleport="body">
                            <div x-show="modalOpen" x-transition
                                class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
                                style="display: none;">
                                <div @click.outside="modalOpen = false"
                                    class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 space-y-4 mx-2">
                                    <h2 class="text-lg font-semibold text-gray-800">Hubungi Admin</h2>
                                    <p class="text-sm text-gray-600">Silakan hubungi admin melalui salah satu
                                        kontak berikut:</p>

                                    <ul class="text-left text-sm text-gray-700 space-y-2">
                                        <li>
                                            📞 <a href="tel:+6281234567890" class="text-blue-600 hover:underline">+62
                                                812-3456-7890</a>
                                        </li>
                                        <li>
                                            💬 <a href="https://wa.me/6281234567890" target="_blank"
                                                class="text-green-600 hover:underline">WhatsApp Admin</a>
                                        </li>
                                        <li>
                                            📧 <a href="mailto:admin@desa.id"
                                                class="text-blue-600 hover:underline">admin@desa.id</a>
                                        </li>
                                    </ul>

                                    <div class="text-right">
                                        <x-button @click="modalOpen = false" variant="secondary">
                                            Tutup
                                        </x-button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- Card binding alpine -->
                <template x-for="item in filteredAdministrasi" :key="item.id_administrasi">
                    <div
                        class="bg-white rounded-2xl hover:shadow-lg transition-all border border-black/10 p-4 sm:p-5 md:p-6 flex flex-col justify-between h-full">

                        <div class="flex-grow">
                            <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2 truncate"
                                x-text="item.nama_administrasi">
                            </h3>
                            <p class="text-gray-600 text-sm sm:text-base leading-relaxed break-words"
                                x-text="item.deskripsi || 'Deskripsi tidak tersedia.'">
                            </p>
                        </div>

                        <div class="mt-4 flex flex-col sm:flex-row gap-2">
                            <x-button variant="secondary" size="sm"
                                @click="selectedAdministrasi = item; showDetailModal = true">
                                Detail
                            </x-button>
                            <x-button variant="primary" size="sm"
                                @click="selectedAdministrasi = item; showAddModal = true">
                                Ajukan Sekarang
                            </x-button>
                        </div>
                    </div>
                </template>
            </div>


            {{-- pagination --}}
            <div class="mt-4">
                {{ $administrasi->links() }}
            </div>
        </div>

        {{-- status error/berhasil --}}
        <x-modalstatus></x-modalstatus>

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
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                        <span>Unduh Formulir Pengisian</span>
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
                <x-button type="button" @click="showDetailModal = false" variant="secondary"
                    class="flex items-center gap-2">
                    <!-- Icon Close -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Tutup
                </x-button>

                <x-button variant="primary" @click="showDetailModal = false; showAddModal = true"
                    class="flex items-center gap-2">
                    <!-- Icon Edit -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L13 14l-4 1 1-4 8.5-8.5z" />
                    </svg>
                    Ajukan Sekarang
                </x-button>
            </div>
        </x-modal>

        {{-- Modal ajukan sekarang --}}
        <x-modal show="showAddModal">

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
                :action="'{{ route('services.apply', ['id' => 'placeholder']) }}'.replace('placeholder', selectedAdministrasi
                    .id_administrasi)"
                enctype="multipart/form-data">

                @csrf

                <!-- Header -->
                <div class="mb-6 space-y-1">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Formulir pengajuan surat <span x-text="selectedAdministrasi.nama_administrasi"></span>
                    </h2>
                    <p class="text-sm text-gray-500">Pastikan anda sudah mengunduh dan mengisi formulir di bawah ini.
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
                        </div>
                    </div>

                    <!-- CTA -->
                    <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                        <x-button type="button" @click="showAddModal = false" variant="secondary"
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

    {{-- riwayat --}}
    <section id="riwayatLayanan" class="px-10 pt-4 pb-10 bg-gray-50" x-data="{
        search: '{{ request('search_riwayat') }}',
        filterStatus: '',
        showDetailModal: false,
        selectedPengajuanAdministrasi: null,
        pengajuanAdministrasi: @js($pengajuanAdministrasi),
        get filteredAdministrasi() {
            return this.pengajuanAdministrasi
                .filter(item => {
                    const nama = item?.nama_administrasi?.toLowerCase() || '';
                    const matchesSearch = nama.includes(this.search.toLowerCase());
                    const matchesStatus = this.filterStatus === '' || item?.status_pengajuan === this.filterStatus;
                    return matchesSearch && matchesStatus;
                })
                .sort((a, b) => new Date(b?.updated_at) - new Date(a?.updated_at));
        }
    }">
        {{-- container tabel Riwayat Layanan --}}
        <div class="md:col-span-4 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-lg font-semibold mb-4">Layanan milik saya</h2>

            {{-- filter --}}
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
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
                        <input type="text" name="search_riwayat" placeholder="Cari Layanan..."
                            value="{{ request('search_riwayat') }}"
                            class="pl-10 pr-24 py-2 w-full rounded-full border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                            @keydown.enter="$event.target.form.submit()">
                        <x-button type="submit"
                            class="absolute right-1 top-1 bottom-1 bg-indigo-400 hover:bg-indigo-600 text-white px-4 py-1 rounded-full text-sm">
                            Cari
                        </x-button>
                    </form>

                    {{-- FILTER DROPDOWN --}}
                    @php
                        $filterAktif = collect([
                            'search_riwayat' => request('search_riwayat'),
                            'status_pengajuan' => request('status_pengajuan'),
                        ])
                            ->filter()
                            ->count();
                    @endphp

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" type="button"
                            class="relative flex items-center gap-2 px-4 py-2 rounded-full border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            aria-expanded="true" aria-haspopup="true">
                            <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                            </svg>
                            Filter
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>

                            @if ($filterAktif > 0)
                                <span
                                    class="absolute top-0 right-0 -mt-1 -mr-1 min-w-[1rem] h-auto px-1 text-xs bg-indigo-500 text-white font-bold rounded-full ring-2 ring-white flex items-center justify-center">
                                    {{ $filterAktif }}
                                </span>
                            @endif
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition.opacity.scale.origin.top.right
                            class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-10 z-50 p-4">
                            <form method="GET" class="space-y-4">
                                <input type="hidden" name="search_riwayat" value="{{ request('search_riwayat') }}">
                                <div>
                                    <label for="status_pengajuan"
                                        class="block text-sm font-medium text-gray-700">Status Pengajuan</label>
                                    <select id="status_pengajuan" name="status_pengajuan"
                                        class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Semua Status</option>
                                        <option value="baru"
                                            {{ request('status_pengajuan') == 'baru' ? 'selected' : '' }}>Baru</option>
                                        <option value="ditinjau"
                                            {{ request('status_pengajuan') == 'ditinjau' ? 'selected' : '' }}>Ditinjau
                                        </option>
                                        <option value="diproses"
                                            {{ request('status_pengajuan') == 'diproses' ? 'selected' : '' }}>Diproses
                                        </option>
                                        <option value="ditolak"
                                            {{ request('status_pengajuan') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                        </option>
                                        <option value="selesai"
                                            {{ request('status_pengajuan') == 'selesai' ? 'selected' : '' }}>Selesai
                                        </option>
                                    </select>
                                </div>
                                <x-button type="submit" class="w-full justify-center">Terapkan Filter</x-button>
                            </form>
                        </div>
                    </div>

                    @if (request()->has('search_riwayat') || request()->has('status_pengajuan'))
                        <a href="{{ url()->current() }}"
                            class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-400 text-gray-600 rounded-full">
                            Tampilkan Semua
                        </a>
                    @endif
                </div>
            </div>

            {{-- body --}}
            <div class="w-full h-80 relative">
                <x-table>
                    <x-slot name="head">
                        <tr>
                            <th class="px-4 py-3 text-center">Nama Layanan</th>
                            <th class="px-4 py-3 text-center">Di ajukan pada</th>
                            <th class="px-4 py-3 text-center">status terbaru</th>
                            <th class="px-4 py-3 text-center">di update pada</th>
                            <th class="px-4 py-3 text-center">aksi</th>
                        </tr>
                    </x-slot>
                    <x-slot name="body">
                        <tr x-show="filteredAdministrasi.length === 0">
                            <td colspan="5" class="text-center text-gray-500 py-6">Layanan Administrasi tidak
                                ditemukan.</td>
                        </tr>
                        <template x-for="item in filteredAdministrasi" :key="item.id_pengajuan_administrasi">
                            <tr class="even:bg-gray-50 hover:bg-gray-100">
                                <td class="px-4 py-3 text-gray-800 font-medium" x-text="item.nama_administrasi"></td>
                                <td class="px-4 py-3 text-gray-600 text-center" x-text="item.tanggal_pengajuan"></td>
                                <td class="px-4 py-3 text-gray-600 text-center" x-text="item.status_pengajuan"></td>
                                <td class="px-4 py-3 text-gray-600 text-center" x-text="item.updated_at"></td>
                                <td class="px-4 py-3 text-gray-600 text-center">
                                    <!-- Tombol aksi seperti Lihat / Edit -->
                                    <x-button @click="selectedPengajuanAdministrasi = item; showDetailModal = true"
                                        size="sm">Detail</x-button>
                                    <template x-if="item.status_pengajuan === 'baru'">
                                        <x-button @click="selectedPengajuanAdministrasi = item; showEditModal = true"
                                            size="sm" variant="warning">Edit</x-button>
                                    </template>
                                    <template x-if="item.status_pengajuan === 'ditolak'">
                                        <x-button @click="selectedPengajuanAdministrasi = item; showDeleteModal = true"
                                            size="sm" variant="danger">Hapus</x-button>
                                    </template>
                                    <template x-if="item.status_pengajuan === 'selesai' && item.surat_final">
                                        <a :href="`{{ route('surat.final.download', '') }}/${item.id_pengajuan_administrasi}`"
                                            target="_blank"
                                            class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out hover:scale-105 bg-green-400 hover:bg-green-500 text-white text-xs px-2 py-1 sm:px-3 sm:py-1.5 md:px-4 md:py-2">
                                            Unduh Surat Final
                                        </a>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </x-slot>
                </x-table>
            </div>
        </div>

        {{-- modal detail --}}
        <x-modal show="showDetailModal">
            <!-- Header -->

            <div class="mb-6 space-y-1">
                <h2 class="text-2xl font-bold text-gray-900">
                    Detail pengajuan <span x-text="selectedPengajuanAdministrasi.nama_administrasi"></span>
                </h2>
                <p class="text-sm text-gray-500">Lihat informasi lengkap dari pengajuan layanan administrasi anda.</p>
            </div>

            <!-- Konten Utama -->
            <div class="space-y-6">
                <!-- Tombol Unduh -->
                <div class="">
                    <a :href="'/storage/' + selectedPengajuanAdministrasi.form" download
                        class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out bg-indigo-400 hover:bg-indigo-600 text-white text-sm px-4 py-2 hover:scale-105">
                        <!-- Icon Download -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                        Unduh formulir&nbsp;<span x-text="selectedPengajuanAdministrasi.nama_administrasi"></span>
                    </a>
                </div>
                <!-- Deskripsi -->
                <div>
                    <h3 class="text-sm font-normal text-gray-500 mb-1">Diajukan pada
                        <span class="text-gray-800 font-semibold leading-relaxed"
                            x-text="selectedPengajuanAdministrasi.tanggal_pengajuan"></span>
                    </h3>

                    <h3 class="text-sm font-normal text-gray-500 mb-1">Terakhir diperbarui
                        <span class="text-gray-800 font-semibold leading-relaxed"
                            x-text="selectedPengajuanAdministrasi.updated_at"></span>
                    </h3>
                    <h3 class="text-sm font-normal text-gray-500 mb-1">Status Pengajuan
                        <span class="text-gray-800 font-semibold leading-relaxed"
                            x-text="selectedPengajuanAdministrasi.status_pengajuan">
                        </span>
                    </h3>
                </div>
            </div>
            <div class="my-4">
                <h2 class="mb-1 text-gray-700 ">Form yang dikirim</h2>
                <a :href="`{{ asset('storage') }}/${selectedPengajuanAdministrasi.form}`" target="_blank"
                    class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out bg-indigo-400 hover:bg-indigo-600 text-white text-sm px-4 py-2 hover:scale-105">
                    <!-- Icon Download -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                    &nbsp;<span x-text="selectedPengajuanAdministrasi.form_name"></span>
                </a>
            </div>
            <div class="">
                <h2 class="mb-1 text-gray-700 ">Lampiran yang dikirim</h2>
                <a :href="`{{ asset('storage') }}/${selectedPengajuanAdministrasi.lampiran}`" target="_blank"
                    class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out bg-indigo-400 hover:bg-indigo-600 text-white text-sm px-4 py-2 hover:scale-105">
                    <!-- Icon Download -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                    &nbsp;<span x-text="selectedPengajuanAdministrasi.lampiran_name"></span>
                </a>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                <x-button type="button" @click="showDetailModal = false" variant="secondary" size="md">
                    Tutup
                </x-button>
            </div>
        </x-modal>

        {{-- modal hapus --}}
        <x-modal show="showDeleteModal">
            <div class="mb-6 space-y-1">
                <h2 class="text-2xl font-bold text-gray-900">
                    Hapus Pengajuan <span x-text="selectedPengajuanAdministrasi.nama_administrasi"></span>
                </h2>
                <p class="text-sm text-gray-500">Apakah anda yakin ingin menghapus pengajuan ini? Tindakan ini tidak
                    dapat dibatalkan.</p>
            </div>
            <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                <x-button type="button" @click="showDeleteModal = false" variant="secondary" size="md">
                    Batal
                </x-button>
                <form method="POST"
                    :action="'{{ route('services.delete', ['id' => 'placeholder']) }}'.replace('placeholder',
                        selectedPengajuanAdministrasi.id_pengajuan_administrasi)">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="danger" size="md">
                        Hapus Pengajuan
                    </x-button>
                </form>
            </div>
        </x-modal>
    </section>

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
