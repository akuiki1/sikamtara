<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <section class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 mb-4">
        {{-- card 1 --}}
        <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Anggaran</p>
                    <h2 class="text-xl font-bold text-gray-900 mt-1">1201</h2>
                </div>

                <div class="text-violet-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-file-text-icon lucide-file-text">
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
                    <p class="text-gray-500 text-sm">Realisasi</p>
                    <h2 class="text-xl font-bold text-gray-900 mt-1">120</h2>
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
                    <p class="text-gray-500 text-sm">Selisih</p>
                    <h2 class="text-xl font-bold text-gray-900 mt-1">121</h2>
                </div>
                <div class="text-amber-400 scale-x-[-1]">
                    <svg class="w-[36px] h-[36px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                            d="M18 5V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5M9 3v4a1 1 0 0 1-1 1H4m11.383.772 2.745 2.746m1.215-3.906a2.089 2.089 0 0 1 0 2.953l-6.65 6.646L9 17.95l.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z" />
                    </svg>

                </div>
            </div>
        </div>
    </section>

    <div class="container p-6 bg-white rounded-xl" x-data="{
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
    }">
        {{-- header --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
            <div class="flex flex-wrap items-center gap-2">
                {{-- filter --}}
                <form method="GET" action="{{ route('adminapbdes.pendapatan') }}" class="py-1">
                    <div x-data="{ open: false }" class="relative w-48">
                        <!-- Trigger Button -->
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-2 border border-gray-300 rounded-full bg-white shadow-sm hover:bg-gray-50 focus:outline-none focus:ring focus:ring-blue-200 transition">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                                </svg>
                                <span class="text-sm text-gray-700">
                                    {{ $tahunDipilih ?? 'Pilih Tahun' }}
                                </span>
                            </div>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" d="M6 9l6 6 6-6" />
                            </svg>
                        </button>

                        <!-- Dropdown Options -->
                        <div x-show="open" @click.outside="open = false"
                            class="absolute z-10 mt-2 w-full rounded-xl border border-gray-200 bg-white shadow-lg">
                            @foreach ($tahunList as $tahun)
                                <button type="submit" name="tahun" value="{{ $tahun->tahun }}"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 transition">
                                    {{ $tahun->tahun }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>

            {{-- tombol tambah --}}
            <div>
                <x-button @click="showAddModal = true">
                    {{-- Plus Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Tambah pendapatan</span>
                </x-button>
            </div>
        </div>

        {{-- table --}}
        @if ($tahunDipilih)
            {{-- jika data kosong --}}
            @if ($data->isEmpty())
                <div class="text-center bg-white border rounded-xl p-12 text-gray-500 text-sm">
                    Belum ada data untuk tahun {{ $tahunDipilih }}.
                </div>
            @else
                {{-- jika data ada --}}
                <x-table class="w-full">
                    <x-slot name="head">
                        <tr>
                            <th class="p-2">Nama</th>
                            <th class="p-2">Anggaran</th>
                            <th class="p-2">Realisasi</th>
                            <th class="p-2">Selisih</th>
                            <th class="p-2">Aksi</th>
                        </tr>
                    </x-slot>
                    <x-slot name="body">
                        @foreach ($data as $pendapatan)
                            <tr>
                                <td class="p-2">{{ $pendapatan->nama }}</td>
                                <td class="p-2">Rp {{ number_format($pendapatan->anggaran, 2, ',', '.') }}</td>
                                <td class="p-2">Rp {{ number_format($pendapatan->realisasi, 2, ',', '.') }}</td>
                                <td class="p-2">Rp {{ number_format($pendapatan->selisih, 2, ',', '.') }}</td>
                                <td class="p-2 text-center cursor-pointer">
                                    <button @click="selectedKeluarga = {...item}; showEditModal = true"
                                        class="text-yellow-600 hover:text-yellow-800"><svg
                                            class="hover:scale-125 transition w-[20px] h-[20px]" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="1"
                                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                    </button>
                                    <button @click="selectedKeluarga = item; showDeleteModal = true"
                                        class="text-red-600 hover:text-red-800 rounded-full">
                                        <svg class="w-[20px] h-[20px] hover:scale-125 transition" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="1"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-table>
            @endif

            {{-- jika tahun belum di pilih --}}
        @else
            <p class="text-sm border text-gray-500 bg-white text-center rounded-xl p-12">
                Silakan pilih tahun terlebih dahulu.
            </p>
        @endif

        {{-- Modal Tambah --}}
        <x-modal show="showAddModal">
            <h2 class="text-xl font-semibold mb-4">Tambah Pendapatan</h2>
            <form method="POST" action="{{ route('adminapbdes.pendapatan.store') }}">
                @csrf
                <input type="hidden" name="tahun" value="{{ $tahunDipilih }}">
                <div class="mb-4">
                    <label class="block mb-1 text-sm">Nama</label>
                    <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm">Anggaran</label>
                    <input type="number" name="anggaran" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm">Realisasi</label>
                    <input type="number" name="realisasi" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="flex justify-end space-x-2 mt-6">
                    <x-button type="button" variant="secondary" @click="showAddModal = false">Batal</x-button>
                    <x-button type="submit" variant="primary">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- Modal Edit --}}
        <x-modal show="showEditModal">
            <h2 class="text-xl font-semibold mb-4">Edit Pendapatan</h2>
            <form method="POST" :action="'/admin/apbdes/pendapatan/' + selectedItem.id">
                @csrf
                @method('PUT')
                <input type="hidden" name="tahun" value="{{ $tahunDipilih }}">
                <div class="mb-4">
                    <label class="block mb-1 text-sm">Nama</label>
                    <input type="text" name="nama" class="w-full border rounded px-3 py-2"
                        x-model="selectedItem.nama" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm">Anggaran</label>
                    <input type="number" name="anggaran" class="w-full border rounded px-3 py-2"
                        x-model="selectedItem.anggaran" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm">Realisasi</label>
                    <input type="number" name="realisasi" class="w-full border rounded px-3 py-2"
                        x-model="selectedItem.realisasi" required>
                </div>
                <div class="flex justify-end space-x-2 mt-6">
                    <x-button type="button" variant="secondary" @click="showEditModal = false">Batal</x-button>
                    <x-button type="submit" variant="primary">Update</x-button>
                </div>
            </form>
        </x-modal>

        {{-- Modal Hapus --}}
        <x-modal show="showDeleteModal">
            <h2 class="text-xl font-semibold mb-4">Hapus Pendapatan</h2>
            <p>Yakin ingin menghapus <strong x-text="selectedItem.nama"></strong>?</p>
            <form method="POST" :action="'/admin/apbdes/pendapatan/' + selectedItem.id" class="mt-6">
                @csrf
                @method('DELETE')
                <div class="flex justify-center space-x-2">
                    <x-button type="button" variant="secondary" @click="showDeleteModal = false">Batal</x-button>
                    <x-button type="submit" variant="danger">Hapus</x-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-admin-layout>
