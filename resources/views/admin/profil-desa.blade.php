<x-admin-layout>
    <x-slot:title>Profil Desa</x-slot:title>

    {{-- Sejarah Desa --}}
    <section x-data="{
        editing: false,
        sejarah: @js($sejarah->sejarah ?? ''),
        editedSejarah: @js($sejarah->sejarah ?? '')
    }" class="py-16 px-6 md:px-16 bg-gray-50">

        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                class="relative bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-full max-w-xl mx-auto mb-6"
                role="alert">
                <strong class="font-semibold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button @click="show = false"
                    class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-700 hover:text-green-900">
                    &times;
                </button>
            </div>
        @endif
        @error('sejarah')
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                class="relative bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-full max-w-xl mx-auto mb-6"
                role="alert">
                <strong class="font-semibold">Gagal!</strong>
                <span class="block sm:inline">Sejarah tidak boleh kosong!</span>
                <button @click="show = false"
                    class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-700 hover:text-red-900">
                    &times;
                </button>
            </div>
        @enderror


        <div class="max-w-xl mx-auto text-center">
            {{-- judul --}}
            <h2 class="text-2xl md:text-3xl font-semibold mb-8">Sejarah Desa</h2>

            {{-- isi --}}
            <div x-show="!sejarah && !editing" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" class="rounded-lg p-6 text-center">

                <p class="text-gray-700 mb-4">Belum ada sejarah desa</p>
                <x-button @click="editing = true">
                    Tambahkan sejarah
                </x-button>
            </div>
        </div>


        <!-- Jika ada sejarah dan tidak sedang mengedit -->
        <div x-show="sejarah && !editing" class="max-w-3xl mx-auto text-justify text-gray-700 leading-relaxed">
            <p x-text="sejarah"></p>
            <button @click="editing = true" class="text-blue-600 hover:underline text-sm">Edit</button>
        </div>

        <!-- Form edit sejarah -->
        <form x-show="editing" x-transition method="POST" action="{{ route('sejarah.update') }}"
            class="max-w-3xl mx-auto space-y-4 mt-4">
            @csrf
            @method('PUT')
            <textarea name="sejarah" x-model="editedSejarah" rows="10"
                class="w-full p-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200 text-gray-800"
                placeholder="Tulis sejarah desa di sini..."></textarea>

            <div class="flex justify-end space-x-4">
                <x-button type="button" @click="editing = false; editedSejarah = sejarah" variant="secondary">
                    Batal
                </x-button>
                <x-button type="submit" @click="sejarah = editedSejarah; editing = false">
                    Simpan
                </x-button>
            </div>
        </form>
    </section>

    {{-- Visi & Misi --}}
    <section class="py-16 px-6 md:px-16" x-data="{
        editing: false,
        visi: @js($visimisi->visi ?? ''),
        misi: @js($visimisi->misi ?? ''),
        editedVisi: @js($visimisi->visi ?? ''),
        editedMisi: @js($visimisi->misi ?? '')
    }">

        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                class="relative bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-full max-w-xl mx-auto mb-6"
                role="alert">
                <strong class="font-semibold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button @click="show = false"
                    class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-700 hover:text-green-900">
                    &times;
                </button>
            </div>
        @endif
        @error('visimisi')
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                class="relative bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-full max-w-xl mx-auto mb-6"
                role="alert">
                <strong class="font-semibold">Gagal!</strong>
                <span class="block sm:inline">Sejarah tidak boleh kosong!</span>
                <button @click="show = false"
                    class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-700 hover:text-red-900">
                    &times;
                </button>
            </div>
        @enderror

        <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Visi & Misi</h2>

        @if ($visimisi)
            <div class="grid md:grid-cols-2 gap-8" x-show="!editing">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4 text-green-600">Visi</h3>
                    <p class="text-gray-700"></p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4 text-green-600">Misi</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        @foreach (explode("\n", $visimisi->misi) as $misiItem)
                            <li>{{ $misiItem }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="text-center">
                <p class="text-gray-700 mb-4">Belum ada visi-misi</p>
                <div class="flex justify-center mb-6">
                    <button @click="editing = true"
                        class="bg-green-600 text-white text-sm px-6 py-2 rounded-full hover:bg-green-700">
                        Tambah Visi & Misi
                    </button>
                </div>
            </div>
        @endif

        @if (!$visimisi)
            <form action="{{ route('visimisi.update') }}" method="POST"
                class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 space-y-4" x-show="editing">
                @csrf
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Visi</label>
                    <textarea name="visi" rows="3" class="w-full border rounded p-2" required></textarea>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Misi (Pisahkan dengan Enter)</label>
                    <textarea name="misi" rows="5" class="w-full border rounded p-2" required></textarea>
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" @click="editing = false"
                        class="px-4 py-2 rounded-full border text-gray-600 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-full hover:bg-green-700">
                        Simpan
                    </button>
                </div>
            </form>
        @endif
    </section>


    {{-- Data Wilayah --}}
    <section x-data="{
        luas: '',
        penduduk: '',
        rt: '',
        rw: '',
        editing: false,
        original: {},
        startEdit() {
            this.original = { luas: this.luas, penduduk: this.penduduk, rt: this.rt, rw: this.rw };
            this.editing = true;
        },
        cancelEdit() {
            Object.assign(this, this.original);
            this.editing = false;
        },
        saveEdit() {
            // kirim ke server pake fetch/ajax di sini kalau mau
            this.editing = false;
        },
        tambahData() {
            this.luas = '';
            this.penduduk = '';
            this.rt = '';
            this.rw = '';
            this.editing = true;
        }
    }" class="py-16 px-6 md:px-16 bg-gray-50">
        <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Data Wilayah</h2>

        <template x-if="luas || penduduk || rt || rw">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-5xl mx-auto">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="luas" @input="startEdit()"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full" />
                    <div class="text-gray-600 mt-2">Luas Wilayah</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="penduduk" @input="startEdit()"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full" />
                    <div class="text-gray-600 mt-2">Jumlah Penduduk</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="rt" @input="startEdit()"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full" />
                    <div class="text-gray-600 mt-2">Jumlah RT</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="rw" @input="startEdit()"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full" />
                    <div class="text-gray-600 mt-2">Jumlah RW</div>
                </div>
            </div>
        </template>

        <!-- Form Input Baru saat Data Masih Kosong -->
        <div class="max-w-5xl mx-auto" x-show="editing && !(luas || penduduk || rt || rw)">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="luas"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full"
                        placeholder="Isi luas" />
                    <div class="text-gray-600 mt-2">Luas Wilayah</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="penduduk"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full"
                        placeholder="Isi jumlah penduduk" />
                    <div class="text-gray-600 mt-2">Jumlah Penduduk</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="rt"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full"
                        placeholder="Isi RT" />
                    <div class="text-gray-600 mt-2">Jumlah RT</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="rw"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full"
                        placeholder="Isi RW" />
                    <div class="text-gray-600 mt-2">Jumlah RW</div>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan / Batal -->
        <div class="text-center mt-8" x-show="editing">
            <button @click="saveEdit()" class="bg-green-600 text-white px-6 py-2 rounded-lg mr-2">Simpan</button>
            <button @click="cancelEdit()" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg">Batal</button>
        </div>

        <!-- Kalau Belum Ada Data, tampilkan tombol Tambah -->
        <template x-if="!luas && !penduduk && !rt && !rw && !editing">
            <div class="text-center mt-8">
                <p class="text-gray-500 mb-4">Data masih kosong</p>
                <button @click="tambahData()" class="bg-green-600 text-white px-6 py-2 rounded-lg">Tambah</button>
            </div>
        </template>
    </section>

    {{-- Struktur Pemerintahan --}}
    <section class="py-16 px-6 md:px-16 bg-gray-50" x-data="{
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
        selectedStrukturPemerintahan: null,
        strukturPemerintahan: @js($strukturPemerintahanJs),
        get filteredStrukturPemerintahan() {
            return this.strukturPemerintahan.filter(item => {
                const matchesSearch = `${item.id}`.toLowerCase().includes(this.search.toLowerCase());
                const matchesRole = this.filterRole === '' || item.role === this.filterRole;
                const matchesStatus = this.filterStatus === '' || item.status_verifikasi === this.filterStatus;
                return matchesSearch && matchesRole && matchesStatus;
            });
        }
    }">
        <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Struktur Pemerintahan</h2>
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
                <template x-if="filteredStrukturPemerintahan.length === 0">
                    <div class="col-span-full text-center text-gray-500 py-6">
                        Data Pegawai tidak ditemukan.
                    </div>
                </template>

                <!-- Card binding alpine -->
                <template x-for="item in filteredstrukturPemerintahan" :key="item.id">
                    <div
                        class="bg-white rounded-2xl hover:shadow-lg transition-all border border-black/10 p-6 flex flex-col justify-between h-full">
                        <div class="flex-grow">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-2" x-text="item.nama">
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed"
                                x-text="item.deskripsi || 'Deskripsi tidak tersedia.'"></p>
                        </div>
                        <div class="mt-4">
                            <x-button variant="primary" @click="selectedStrukturPemerintahan = item; showDetailModal = true">
                                Detail
                            </x-button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- pagination --}}
            <div class="mt-4">
                {{ $strukturPemerintahan->links() }}
            </div>
        </div>
    </section>

    {{-- Program Pembangunan Desa --}}
    <section class="py-16 px-6 md:px-16 bg-gray-50">
        <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Program Pembangunan Desa</h2>
        <div class="space-y-6 max-w-3xl mx-auto text-justify">
            <ul class="list-disc list-inside text-gray-700">
                <li>Pembangunan jalan desa untuk meningkatkan akses transportasi.</li>
                <li>Peningkatan fasilitas pendidikan dan kesehatan di desa.</li>
                <li>Program pemberdayaan ekonomi lokal melalui pelatihan keterampilan.</li>
                <li>Penanaman pohon dan pemeliharaan lingkungan untuk menjaga kelestarian alam.</li>
            </ul>
        </div>
    </section>
</x-admin-layout>
