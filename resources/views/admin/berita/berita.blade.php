<x-admin-layout>
    <x-slot:title>kelola berita</x-slot>

    {{-- logika table --}}
    <div class="p-6" x-data="{
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
        selectedBerita: null,
        berita: @js($beritaJs),
        get filteredBerita() {
            return this.berita.filter(item => {
                const matchesSearch = `${item.id_berita}`.toLowerCase().includes(this.search.toLowerCase());
                const matchesRole = this.filterRole === '' || item.role === this.filterRole;
                const matchesStatus = this.filterStatus === '' || item.status_verifikasi === this.filterStatus;
                return matchesSearch && matchesRole && matchesStatus;
            });
        }
    }">

        {{-- Search bar + filter + tambah --}}
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
                    <input type="text" name="search" placeholder="Cari Berita..." value="{{ request('search') }}"
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
                        'search' => request('search'),
                        'role' => request('role'),
                        'status' => request('status'),
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>

                        {{-- BADGE ANGKA --}}
                        @if ($filterAktif > 0)
                            <span
                                class="absolute top-0 right-0 -mt-1 -mr-1 min-w-[1rem] h-auto px-1 text-xs bg-indigo-500 text-white font-bold rounded-full ring-2 ring-white flex items-center justify-center">
                                {{ $filterAktif }}
                            </span>
                        @endif
                    </button>

                    {{-- FILTER PANEL --}}
                    <div x-show="open" @click.outside="open = false" x-transition.opacity.scale.origin.top.right
                        class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-10 z-50 p-4">
                        <form method="GET" class="space-y-4">
                            <input type="hidden" name="search" value="{{ request('search') }}">

                            {{-- Status Berita --}}
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status
                                    Berita</label>
                                <select id="status" name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Semua Status</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft
                                    </option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>
                                        Published</option>
                                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>
                                        Archived</option>
                                </select>
                            </div>

                            <x-button type="submit" class="w-full justify-center">Terapkan Filter</x-button>
                        </form>
                    </div>
                </div>


                {{-- TOMBOL CLEAR FILTER (hanya muncul kalau filter aktif) --}}
                @if (request()->has('search') || request()->has('role') || request()->has('status'))
                    <a href="{{ url()->current() }}"
                        class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-400 text-gray-600 rounded-full">
                        Tampilkan Semua
                    </a>
                @endif
            </div>

            {{-- RIGHT SECTION: Tambah Berita --}}
            <div>
                <x-button @click="selectedBerita = null; showAddModal = true">
                    {{-- Plus Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Tambah Berita</span>
                </x-button>
            </div>
        </div>

        {{-- table --}}
        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="px-4 py-3 text-center">Judul</th>
                    <th class="px-4 py-3 text-center">Isi</th>
                    <th class="px-4 py-3 text-center">Tanggal Publish</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body" x-show="filteredBerita.length > 0">
                <template x-if="filteredBerita.length === 0">
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-6">
                            Data Berita tidak ditemukan.
                        </td>
                    </tr>
                </template>
                <template x-for="item in filteredBerita" :key="item.id_berita">
                    <tr class="even:bg-gray-50 hover:bg-gray-100">
                        <td class="px-4 py-3 text-gray-600" x-text="item.judul_berita"></td>
                        <td class="px-4 py-3 text-gray-600 text-center" x-text="item.isi_berita"></td>
                        <td class="px-4 py-3 text-gray-600 text-center" x-text="item.tanggal_publish"></td>
                        <td class="px-4 py-3 text-gray-600 text-center" x-text="item.status"></td>
                        {{-- tombol --}}
                        <td class="px-6 py-4 text-center">
                            <button @click="selectedBerita = item; showDetailModal = true"
                                class="text-blue-600 hover:text-blue-800">
                                <svg class="w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="1"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                    <path stroke="currentColor" stroke-width="1"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                            <button @click="selectedBerita = {...item}; showEditModal = true"
                                class="text-yellow-600 hover:text-yellow-800"><svg class="w-[20px] h-[20px]"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </button>
                            <button @click="selectedBerita = item; showDeleteModal = true"
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
            </x-slot>
        </x-table>

        {{-- pagination --}}
        <div class="mt-4">
            {{ $berita->links() }}
        </div>

        {{-- modal tambah --}}
        <x-modal show="showAddModal" title="Tambah Berita Baru">
            <form action="{{ route('adminberita.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8" x-data="{
                    previewCover: null,
                    updatePreview(e) {
                        const file = e.target.files[0];
                        if (file) {
                            this.previewCover = URL.createObjectURL(file);
                        }
                    }
                }">
                @csrf

                {{-- Baris 1: Gambar + Judul --}}
                <div>
                    <label for="gambar_cover" class="text-sm text-gray-600 mb-1 block">Gambar Cover</label>
                    <div class="border border-gray-200 rounded-xl p-3 transition hover:border-gray-400">
                        <input type="file" name="gambar_cover" id="gambar_cover" accept="image/*"
                            @change="updatePreview"
                            class="block w-full text-sm text-gray-800 focus:outline-none focus:ring-0">
                        <template x-if="previewCover">
                            <img :src="previewCover" alt="Preview"
                                class="mt-3 w-full h-44 object-cover rounded-lg border border-gray-200 shadow-sm" />
                        </template>
                    </div>
                </div>

                <div>
                    <label for="judul_berita" class="text-sm text-gray-600 mb-1 block">Judul Berita</label>
                    <input type="text" name="judul_berita" id="judul_berita"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                        placeholder="Masukkan judul berita" required />
                </div>


                {{-- Isi Berita --}}
                <div>
                    <label for="isi_berita" class="text-sm text-gray-600 mb-1 block">Isi Berita</label>
                    <textarea name="isi_berita" id="isi_berita" rows="6"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition resize-none"
                        placeholder="Tulis isi berita di sini..." required></textarea>
                </div>

                {{-- Baris 2: Tanggal + Status --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="status" class="text-sm text-gray-600 mb-1 block">Status</label>
                        <select name="status" id="status"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2 text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>

                    {{-- Penulis --}}
                    <div>
                        <label for="penulis" class="text-sm text-gray-600 mb-1 block">Penulis</label>
                        @auth
                            <input type="hidden" name="penulis" value="{{ Auth::user()->id_user }}">
                            <input type="text" disabled value="{{ Auth::user()->nama }}"
                                class="w-full rounded-xl bg-gray-100 border border-gray-200 px-4 py-2 text-gray-700 cursor-not-allowed">
                        @else
                            <input type="text" name="penulis" id="penulis"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                                placeholder="Nama penulis">
                        @endauth
                    </div>
                </div>



                {{-- Tombol Aksi --}}
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <x-button type="button" @click="showAddModal = false" variant="secondary">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        <!-- Modal detail -->
        <x-modal show="showDetailModal">
            <div class="col-span-full border-b pb-2 mb-4 flex items-center justify-between gap-4">
                <p class="font-bold text-2xl text-gray-800" x-text="selectedBerita.judul_berita"></p>

                <!-- Badge Status -->
                <span class="text-xs font-semibold px-2 py-1 rounded-full"
                    :class="{
                        'bg-green-100 text-green-800': selectedBerita.status === 'published',
                        'bg-yellow-100 text-yellow-800': selectedBerita.status === 'draft',
                        'bg-gray-200 text-gray-800': selectedBerita.status === 'archived'
                    }"
                    x-text="selectedBerita.status">
                </span>
            </div>
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <!-- Foto -->
                    <img :src="selectedBerita.gambar_cover ? '/storage/' + selectedBerita.gambar_cover : 'img/default-avatar.png'"
                        alt="Foto Berita" class="col-span-full rounded-lg object-cover border border-gray-300" />

                </div>
            </div>
            <div class="">
                <p class="text-xs text-gray-500">Diupload <span x-text="selectedBerita.tanggal_publish"></span> Oleh
                    <span x-text="selectedBerita.penulis"></span>
                </p>
            </div>
            <div class="grid mt-4 grid-cols-1 sm:grid-cols-2 gap-2">
                <div class="col-span-full">
                    <p class="font-normal text-gray-800 break-words" x-text="selectedBerita.isi_berita_full"></p>
                </div>
            </div>

            <!-- Tombol Tutup -->
            <div class="text-right pt-4">
                <x-button variant="primary" @click="showDetailModal = false">
                    Tutup
                </x-button>
            </div>
        </x-modal>

        <!-- Modal edit -->
        <x-modal show="showEditModal" title="Edit Berita">
            <form :action="'/admin/berita/' + selectedBerita.id_berita" method="POST" enctype="multipart/form-data"
                class="space-y-8" x-data="{
                    previewCover: selectedBerita.gambar_cover ? '{{ asset('storage') }}/' + selectedBerita.gambar_cover : null,
                    updatePreview(e) {
                        const file = e.target.files[0];
                        if (file) {
                            this.previewCover = URL.createObjectURL(file);
                        }
                    }
                }">
                @csrf
                @method('PUT')

                {{-- Baris 1: Gambar + Judul --}}
                <div>
                    <label for="edit_gambar_cover" class="text-sm text-gray-600 mb-1 block">Gambar Cover</label>
                    <div class="border border-gray-200 rounded-xl p-3 transition hover:border-gray-400">
                        <input type="file" name="gambar_cover" id="edit_gambar_cover" accept="image/*"
                            @change="updatePreview"
                            class="block w-full text-sm text-gray-800 focus:outline-none focus:ring-0">
                        <template x-if="previewCover">
                            <img :src="previewCover" alt="Preview"
                                class="mt-3 w-full h-44 object-cover rounded-lg border border-gray-200 shadow-sm" />
                        </template>
                    </div>
                </div>
                <div>
                    <label for="edit_judul_berita" class="text-sm text-gray-600 mb-1 block">Judul Berita</label>
                    <input type="text" name="judul_berita" id="edit_judul_berita"
                        x-model="selectedBerita.judul_berita"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                        placeholder="Masukkan judul berita" required />
                </div>

                {{-- Isi Berita --}}
                <div>
                    <label for="edit_isi_berita" class="text-sm text-gray-600 mb-1 block">Isi Berita</label>
                    <textarea name="isi_berita" id="edit_isi_berita" rows="6" x-text="selectedBerita.isi_berita_full"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition resize-none"
                        placeholder="Tulis isi berita di sini..." required></textarea>
                </div>

                {{-- Baris 2: Tanggal + Status --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="edit_status" class="text-sm text-gray-600 mb-1 block">Status</label>
                        <select name="status" id="edit_status" x-model="selectedBerita.status"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2 text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit_penulis" class="text-sm text-gray-600 mb-1 block">Penulis</label>
                        <input type="text" id="edit_penulis" x-model="selectedBerita.penulis"
                            class="rounded-xl border border-gray-200 px-4 py-2 text-gray-900 bg-gray-100 cursor-not-allowed"
                            readonly />
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <x-button type="button" @click="showEditModal = false" variant="secondary">Batal</x-button>
                    <x-button type="submit">Simpan
                        Perubahan</x-button>
                </div>
            </form>
        </x-modal>

        <!-- Modal hapus -->
        <x-modal show="showDeleteModal" title="Hapus Berita">
            <div>
                <p class="mb-4">Apakah Anda yakin ingin menghapus berita <strong
                        x-text="selectedBerita.judul_berita"></strong> ?
                </p>
            </div>
            <form :action="'/admin/berita/' + selectedBerita.id_berita" method="POST">
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
