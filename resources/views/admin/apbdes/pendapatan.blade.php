<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <section class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 mb-4">
        {{-- Card Anggaran --}}
        <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Anggaran</p>
                    <h2 class="text-xl font-bold text-blue-600 mt-1">
                        Rp {{ number_format($totalAnggaran, 2, ',', '.') }}
                    </h2>
                </div>
            </div>
        </div>

        {{-- Card Realisasi --}}
        <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Realisasi</p>
                    <h2 class="text-xl font-bold text-red-600 mt-1">
                        Rp {{ number_format($totalRealisasi, 2, ',', '.') }}
                    </h2>
                </div>
            </div>
        </div>

        {{-- Card Selisih --}}
        @php
            $selisih = $totalSelisih ?? 0;

            $selisihColor = 'text-blue-600';
            $badgeText = '';
            $badgeColor = '';

            if ($selisih > 0) {
                $selisihColor = 'text-green-600';
                $badgeText = 'Surplus';
                $badgeColor = 'bg-green-100 text-green-700';
            } elseif ($selisih < 0) {
                $selisihColor = 'text-red-600';
                $badgeText = 'Defisit';
                $badgeColor = 'bg-red-100 text-red-700';
            }
        @endphp

        <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <p class="text-gray-500 text-sm">Total Selisih</p>

                @if ($badgeText)
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $badgeColor }}">
                        {{ $badgeText }}
                    </span>
                @endif
            </div>
            <h2 class="text-xl font-bold mt-1 {{ $selisihColor }}">
                Rp {{ number_format($selisih, 2, ',', '.') }}
            </h2>
        </div>
    </section>

    <div class="container p-6 bg-white rounded-xl" x-data="{
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        selectedPendapatan: {},
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

            @if ($tahunDipilih)
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
            @endif
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
                            <th class="p-2 w-80">Nama</th>
                            <th class="p-2 text-left">Anggaran</th>
                            <th class="p-2 text-left">Realisasi</th>
                            <th class="p-2 text-left">Selisih</th>
                            <th class="p-2 text-center">Aksi</th>
                        </tr>
                    </x-slot>
                    <x-slot name="body">
                        @foreach ($data as $pendapatan)
                            <tr>
                                <td class="p-2 w-80">{{ $pendapatan->nama }}</td>
                                <td class="p-2">Rp {{ number_format($pendapatan->anggaran, 2, ',', '.') }}</td>
                                <td class="p-2">Rp {{ number_format($pendapatan->realisasi, 2, ',', '.') }}</td>
                                <td class="p-2">Rp {{ number_format($pendapatan->selisih, 2, ',', '.') }}</td>
                                <td class="p-2 text-center cursor-pointer">
                                    <button @click="selectedPendapatan = {{ $pendapatan }}; showEditModal = true"
                                        class="text-yellow-600 hover:text-yellow-800"><svg
                                            class="hover:scale-125 transition w-[20px] h-[20px]" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1"
                                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                    </button>
                                    <button @click="selectedPendapatan = {{ $pendapatan }}; showDeleteModal = true"
                                        class="text-red-600 hover:text-red-800 rounded-full">
                                        <svg class="w-[20px] h-[20px] hover:scale-125 transition" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1"
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
                {{-- ANGGARAN --}}
                <div>
                    <label for="anggaran" class="block text-sm font-medium">Anggaran</label>
                    <input type="number" name="anggaran" step="0.01" min="0"
                        class="mt-1 block w-full p-2 border rounded" required>
                </div>

                {{-- REALISASI --}}
                <div>
                    <label for="realisasi" class="block text-sm font-medium">Realisasi</label>
                    <input type="number" name="realisasi" step="0.01" min="0"
                        class="mt-1 block w-full p-2 border rounded" required>
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
            <form method="POST"
                :action="'{{ route('adminapbdes.pendapatan.update', '') }}/' + selectedPendapatan.id_pendapatan">
                @csrf
                @method('PUT')
                <input type="hidden" name="tahun" value="{{ $tahunDipilih }}">

                <div class="mb-4">
                    <label class="block mb-1 text-sm">Nama <span class="text-red-600">*</span></label>
                    <input type="text" name="nama" class="w-full border rounded px-3 py-2"
                        x-model="selectedPendapatan.nama" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Anggaran <span class="text-red-600">*</span></label>
                    <input type="number" name="anggaran" step="0.01" min="0"
                        class="mt-1 block w-full p-2 border rounded" x-model="selectedPendapatan.anggaran" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Realisasi <span class="text-red-600">*</span></label>
                    <input type="number" name="realisasi" step="0.01" min="0"
                        class="mt-1 block w-full p-2 border rounded" x-model="selectedPendapatan.realisasi" required>
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <x-button type="button" variant="secondary" @click="showEditModal = false">Batal</x-button>
                    <x-button type="submit" variant="primary">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- Modal Hapus --}}
        <x-modal show="showDeleteModal">
            <h2 class="text-xl font-semibold mb-4 text-red-600">Hapus Pendapatan</h2>
            <p class="text-sm text-gray-700 mb-6">
                Apakah kamu yakin ingin menghapus pendapatan <strong x-text="selectedPendapatan.nama"></strong>?
                Tindakan ini tidak dapat dibatalkan.
            </p>
            <form method="POST"
                :action="'{{ route('adminapbdes.pendapatan.destroy', '') }}/' + selectedPendapatan.id_pendapatan">
                @csrf
                @method('DELETE')
                <input type="hidden" name="tahun" value="{{ $tahunDipilih }}">
                <div class="flex justify-end space-x-2">
                    <x-button type="button" variant="secondary" @click="showDeleteModal = false">Batal</x-button>
                    <x-button type="submit" variant="danger">Hapus</x-button>
                </div>
            </form>
        </x-modal>

    </div>
</x-admin-layout>
