<x-admin-layout>
    <x-slot:title>Layanan Pengaduan</x-slot>

    <section>
        {{-- container card --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- card 1 --}}
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Pengaduan Masuk</p>
                        <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $total }}</h2>
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
                        <p class="text-gray-500 text-sm">Pengaduan Baru</p>
                        <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $terkirim }}</h2>
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
                        <p class="text-gray-500 text-sm">Diproses</p>
                        <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $diproses }}</h2>
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
                        <p class="text-gray-500 text-sm">Ditutup</p>
                        <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $ditutup }}</h2>
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

    <section class="mt-6" x-data="{
        showAddModal: false,
        showDetailModal: false,
        showAccModal: false,
        showTolakModal: false,
        showProsesModal: false,
        showSelesaikanModal: false,
        showDeleteModal: false,
        selectedPengaduan: null,
        pengaduan: @js($pengaduanJs),
    }">
        {{-- content --}}
        <div class="bg-white p-4 rounded-xl shadow">
            {{-- header --}}
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
                <form method="GET" class="flex flex-wrap items-center gap-2" x-data @change="$el.submit()">

                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>

                        <input type="text" name="search" value="{{ request('search') }}"
                            class="border rounded-full pl-9 pr-3 py-2 text-sm w-full"
                            placeholder="Cari judul atau isi..." @input.debounce.500ms="$el.form.submit()">
                    </div>

                    <div class="relative">
                        {{-- Icon Filter (kiri) --}}
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 4a1 1 0 011-1h16a1 1 0 01.8 1.6l-6.2 8.3a1 1 0 00-.2.6v4.5a1 1 0 01-1.4.9l-2-1a1 1 0 01-.6-.9v-3.5a1 1 0 00-.2-.6L3.2 5.6A1 1 0 013 4z" />
                        </svg>

                        {{-- Icon Dropdown Arrow (kanan) --}}
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 transition-transform duration-300 pointer-events-none peer-focus:rotate-180"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>

                        {{-- Select Field --}}
                        <select name="status"
                            class="peer border rounded-full pl-9 pr-8 py-2 text-sm appearance-none w-full">
                            <option value="">Filter</option>
                            @foreach (['terkirim', 'diterima', 'diproses', 'ditolak', 'selesai'] as $status)
                                <option value="{{ $status }}"
                                    {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if (request()->has('search') || request()->has('status'))
                        <a href="{{ route('admin.pengaduan.index') }}"
                            class="flex items-center gap-1 text-sm text-red-600 bg-red-100 px-4 py-2 rounded-full ml-2 transition transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Clear Filter</span>
                        </a>
                    @endif
                </form>

                <x-button @click="showAddModal = true">Tambah Pengaduan</x-button>
            </div>

            {{-- body --}}
            <x-table>
                <x-slot name="head">
                    <tr>
                        <td class="p-2 font-bold text-left w-48">Nama</td>
                        <td class="p-2 font-bold text-left">Pengaduan</td>
                        <td class="p-2 font-bold text-center w-32">Tanggal Masuk</td>
                        <td class="p-2 font-bold text-center w-24">Status</td>
                        <td class="p-2 font-bold text-center w-52">Aksi</td>
                    </tr>
                </x-slot>

                <x-slot name="body">
                    @forelse($pengaduans as $pengaduan)
                        <tr>
                            <td class="p-2 text-left">{{ $pengaduan->user->nama ?? '-' }}</td>
                            <td class="p-2 text-left">{{ Str::limit($pengaduan->judul_pengaduan, 50) }}</td>
                            <td class="p-2 text-center w-32">{{ $pengaduan->created_at->format('d M Y') }}</td>
                            <td class="p-2 text-center w-24">{{ $pengaduan->status }}</td>
                            <td class="p-2 text-left space-x-1 w-52">
                                <x-button
                                    @click="selectedPengaduan = {{ json_encode($pengaduan) }}; showDetailModal = true"
                                    size="sm" variant="secondary">
                                    Detail
                                </x-button>


                                @if ($pengaduan->status === 'terkirim')
                                    <x-button
                                        @click="selectedPengaduan = {{ json_encode($pengaduan) }}; showAccModal = true"
                                        size="sm" variant="primary">
                                        Acc
                                    </x-button>
                                    <x-button
                                        @click="selectedPengaduan = {{ json_encode($pengaduan) }}; showTolakModal = true"
                                        size="sm" variant="danger">
                                        Tolak
                                    </x-button>
                                @elseif ($pengaduan->status === 'diterima')
                                    <x-button
                                        @click="selectedPengaduan = {{ json_encode($pengaduan) }}; showProsesModal = true"
                                        size="sm" variant="warning">Proses</x-button>
                                @elseif ($pengaduan->status === 'diproses')
                                    <x-button
                                        @click="selectedPengaduan = {{ json_encode($pengaduan) }}; showSelesaikanModal = true"
                                        size="sm" variant="success">Selesaikan</x-button>
                                @elseif ($pengaduan->status === 'ditolak')
                                    <x-button
                                        @click="selectedPengaduan = {{ json_encode($pengaduan) }}; showDeleteModal = true"
                                        size="sm" variant="danger">Hapus</x-button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Belum ada pengaduan.</td>
                        </tr>
                    @endforelse
                </x-slot>
            </x-table>

            {{-- paginate --}}
            <div class="mt-4">
                {{ $pengaduans->links() }}
            </div>
        </div>

        {{-- add modal --}}
        <x-modal show="showAddModal" title="Tambah Pengaduan">
            <form method="POST" action="{{ route('admin.pengaduan.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 gap-4 mb-4">
                    {{-- Nama User --}}
                    <input type="hidden" name="id_user" value="{{ auth()->user()->id_user }}">

                    {{-- Judul --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Judul Pengaduan</label>
                        <input type="text" name="judul_pengaduan" class="w-full border rounded px-3 py-2 text-sm"
                            placeholder="Masukkan judul" required>
                    </div>

                    {{-- Isi --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Isi Pengaduan</label>
                        <textarea name="isi_pengaduan" class="w-full border rounded px-3 py-2 text-sm" rows="4"
                            placeholder="Masukkan isi pengaduan" required></textarea>
                    </div>

                    {{-- Lampiran --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Lampiran</label>
                        <input type="file" name="lampiran" accept=".jpg,.jpeg,.png,.pdf" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <x-button variant="secondary" @click="showAddModal = false" type="button">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- detail modal --}}
        <x-modal show="showDetailModal" title="Detail Pengaduan">
            <div class="space-y-4 text-sm text-gray-700">
                <div>
                    <p class="font-semibold">Nama</p>
                   <p x-text="selectedPengaduan.user.penduduk.nama"></p>
                </div>

                <div>
                    <p class="font-semibold">Judul</p>
                    <p x-text="selectedPengaduan.judul_pengaduan"></p>
                </div>

                <div>
                    <p class="font-semibold">Isi</p>
                    <p x-text="selectedPengaduan.isi_pengaduan"></p>
                </div>

                <div>
                    <p class="font-semibold">Tanggal Masuk</p>
                    <p x-text="new Date(selectedPengaduan.created_at).toLocaleString()"></p>
                </div>

                <div>
                    <p class="font-semibold">Status</p>
                    <p class="capitalize" x-text="selectedPengaduan.status"></p>
                </div>

                <div x-show="selectedPengaduan.lampiran">
                    <p class="font-semibold mb-1">Lampiran</p>
                    <template
                        x-if="selectedPengaduan.lampiran.endsWith('.jpg') || selectedPengaduan.lampiran.endsWith('.png') || selectedPengaduan.lampiran.endsWith('.jpeg')">
                        <img :src="'/storage/' + selectedPengaduan.lampiran" alt="Lampiran"
                            class="rounded-lg shadow w-full max-w-md">
                    </template>

                    <template
                        x-if="selectedPengaduan.lampiran.endsWith('.pdf') || selectedPengaduan.lampiran.endsWith('.doc') || selectedPengaduan.lampiran.endsWith('.docx')">
                        <a class="inline-flex items-center text-blue-600 underline hover:text-blue-800"
                            :href="'/storage/' + selectedPengaduan.lampiran" target="_blank">
                            Lihat lampiran
                        </a>
                    </template>
                </div>
            </div>

            <div class="mt-6 text-right">
                <x-button variant="secondary" @click="showDetailModal = false">Tutup</x-button>
            </div>
        </x-modal>

        {{-- acc modal --}}
        <x-modal show="showAccModal" title="Acc Pengaduan">
            <form method="POST" action="{{ route('admin.pengaduan.acc') }}">
                @csrf

                {{-- Hidden input ID --}}
                <input type="hidden" name="id_pengaduan" :value="selectedPengaduan.id_pengaduan">

                <p class="text-sm text-gray-600 mb-4">
                    Apakah Anda yakin ingin menerima pengaduan dengan judul
                    <span class="font-semibold text-green-600" x-text="selectedPengaduan.judul_pengaduan"></span>?
                </p>

                <div class="flex justify-end gap-2">
                    <x-button variant="secondary" @click="showAccModal = false" type="button">Batal</x-button>
                    <x-button variant="success" type="submit">Terima</x-button>
                </div>
            </form>
        </x-modal>

        {{-- tolak modal --}}
        <x-modal show="showTolakModal" title="Tolak Pengaduan">
            <form method="POST" action="{{ route('admin.pengaduan.reject') }}">
                @csrf

                {{-- Hidden input ID --}}
                <input type="hidden" name="id_pengaduan" :value="selectedPengaduan.id_pengaduan">

                <p class="text-sm text-gray-600 mb-4">
                    Apakah Anda yakin ingin <span class="font-semibold text-red-600">menolak</span> pengaduan dengan
                    judul
                    <span class="font-semibold text-red-600" x-text="selectedPengaduan.judul_pengaduan"></span>?
                </p>

                <div class="flex justify-end gap-2">
                    <x-button variant="secondary" @click="showTolakModal = false" type="button">Batal</x-button>
                    <x-button variant="danger" type="submit">Tolak</x-button>
                </div>
            </form>
        </x-modal>

        {{-- proses modal --}}
        <x-modal show="showProsesModal" title="Proses Pengaduan">
            <form method="POST" action="{{ route('admin.pengaduan.proses') }}">
                @csrf

                {{-- Hidden input ID --}}
                <input type="hidden" name="id_pengaduan" :value="selectedPengaduan.id_pengaduan">

                <p class="text-sm text-gray-600 mb-4">
                    Apakah Anda yakin ingin memproses pengaduan dengan judul
                    <span class="font-semibold text-blue-600" x-text="selectedPengaduan.judul_pengaduan"></span>?
                </p>

                <div class="flex justify-end gap-2">
                    <x-button variant="secondary" @click="showProsesModal = false" type="button">Batal</x-button>
                    <x-button variant="primary" type="submit">Proses</x-button>
                </div>
            </form>
        </x-modal>

        {{-- selesaikan modal --}}
        <x-modal show="showSelesaikanModal" title="Selesaikan Pengaduan">
            <form method="POST" action="{{ route('admin.pengaduan.selesaikan') }}">
                @csrf

                {{-- Hidden input --}}
                <input type="hidden" name="id_pengaduan" :value="selectedPengaduan.id_pengaduan">

                <p class="text-sm text-gray-600 mb-4">
                    Apakah Anda yakin pengaduan
                    <span class="font-semibold text-blue-600" x-text="selectedPengaduan.judul_pengaduan"></span> sudah
                    selesai ditindaklanjuti?
                </p>

                <div class="flex justify-end gap-2">
                    <x-button variant="secondary" @click="showSelesaikanModal = false"
                        type="button">Batal</x-button>
                    <x-button variant="primary" type="submit">Selesaikan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- hapus modal --}}
        <x-modal show="showDeleteModal" title="Hapus Pengaduan">
            <form method="POST" action="{{ route('admin.pengaduan.destroy') }}">
                @csrf

                {{-- Hidden input untuk ID pengaduan --}}
                <input type="hidden" name="id_pengaduan" :value="selectedPengaduan.id_pengaduan">

                <p class="text-sm text-gray-600 mb-4">
                    Apakah Anda yakin ingin menghapus pengaduan berjudul
                    <span class="font-semibold text-red-600" x-text="selectedPengaduan.judul_pengaduan"></span>?
                    Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="flex justify-end gap-2">
                    <x-button variant="secondary" @click="showDeleteModal = false" type="button">Batal</x-button>
                    <x-button variant="danger" type="submit">Hapus</x-button>
                </div>
            </form>
        </x-modal>
    </section>
</x-admin-layout>
