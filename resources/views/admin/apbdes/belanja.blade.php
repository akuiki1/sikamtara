<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    {{-- stat-card --}}
    <section>
        @php
            $totalAnggaran = 0;
            $totalRealisasi = 0;
            $totalSelisih = 0;

            foreach ($data as $item) {
                foreach ($item->rincianBelanja as $rincian) {
                    $totalAnggaran += $rincian->anggaran;
                    $totalRealisasi += $rincian->realisasi;
                    $totalSelisih += $rincian->selisih;
                }
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
            <x-stat-card label="Anggaran Belanja" :value="'Rp ' . number_format($totalAnggaran, 2, ',', '.')" color="text-green-600" />
            <x-stat-card label="Total Realisasi Belanja" :value="'Rp ' . number_format($totalRealisasi, 2, ',', '.')" color="text-red-500" />
            <x-stat-card label="Selisih" :value="'Rp ' . number_format($totalSelisih, 2, ',', '.')" />
        </div>


    </section>

    {{-- table --}}
    <div class="p-4 bg-white rounded-xl" x-data="{
        showAddBidangModal: false,
        showEditBidangModal: false,
        showDeleteBidangModal: false,
        showDetailBidangModal: false,
    
        showAddRincianModal: false,
        showEditRincianModal: false,
        showDeleteRincianModal: false,
        showDetailRincianModal: false,
    
        selectedItem: null,
        selectedBelanja: null
    }">

        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
            <div class="flex flex-wrap items-center gap-2">
                <form method="GET" class="relative inline-block">
                    <label for="tahun" class="sr-only">Pilih Tahun</label>
                    <div
                        class="flex items-center border border-gray-300 rounded-xl px-3 py-2 bg-white cursor-pointer w-48">
                        <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                        </svg>
                        <select name="tahun" id="tahun" onchange="this.form.submit()"
                            class="w-full bg-transparent text-sm focus:outline-none">
                            <option value="">Pilih Tahun</option>
                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun->tahun }}"
                                    {{ request('tahun') == $tahun->tahun ? 'selected' : '' }}>
                                    {{ $tahun->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <div>
                <x-button @click="showAddBidangModal = true">Tambah Bidang</x-button>
                <x-button @click="showAddRincianModal = true">Tambah Rincian Belanja</x-button>
            </div>
        </div>

        {{-- Tabel Data Belanja --}}
        @if ($tahunDipilih)
            @foreach ($data as $belanja)
                <div class="border rounded-xl overflow-hidden shadow mb-4">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-indigo-400 text-white">
                            <tr>
                                <th class="flex font-semibold px-4 py-2 cursor-pointer transition hover:underline w-96"
                                    @click="selectedBelanja = {{ json_encode($belanja) }}; showDetailBidangModal = true">
                                    {{ strtoupper($belanja->nama) }}
                                </th>
                                <th class="font-semibold px-4 py-2">Anggaran</th>
                                <th class="font-semibold px-4 py-2">Realisasi</th>
                                <th class="font-semibold px-4 py-2">Selisih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalAnggaran = 0;
                                $totalRealisasi = 0;
                                $totalSelisih = 0;
                            @endphp

                            @foreach ($belanja->rincianBelanja as $rincian)
                                @php
                                    $totalAnggaran += $rincian->anggaran ?? 0;
                                    $totalRealisasi += $rincian->realisasi ?? 0;
                                    $totalSelisih += $rincian->selisih ?? 0;
                                @endphp
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $rincian->nama }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($rincian->anggaran ?? 0, 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2">Rp {{ number_format($rincian->realisasi ?? 0, 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2">Rp {{ number_format($rincian->selisih ?? 0, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="bg-gray-100 font-semibold border-t">
                                <td class="px-4 py-2">TOTAL BELANJA</td>
                                <td class="px-4 py-2">Rp {{ number_format($totalAnggaran, 2, ',', '.') }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($totalRealisasi, 2, ',', '.') }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($totalSelisih, 2, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endforeach
        @endif

        <!-- Modal Edit Bidang -->
        <form method="POST" action="{{ route('bidang.belanja.update') }}">
            @csrf
            @method('PUT')

            <!-- Kirim ID bidang sebagai hidden input -->
            <input type="hidden" name="id_belanja" :value="selectedBelanja.id_belanja">

            <x-modal show="showEditBidangModal" title="Edit Bidang">
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-sm text-gray-700">Nama Bidang</label>
                    <input type="text" name="nama" x-model="selectedBelanja.nama"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <x-button type="button" @click="showEditBidangModal = false; showDetailBidangModal = true"
                        variant="secondary">
                        Batal
                    </x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </x-modal>
        </form>

        <!-- Modal Hapus Bidang -->
        <form method="POST" action="{{ route('bidang.belanja.destroy') }}">
            @csrf
            @method('DELETE')

            <input type="hidden" name="id_belanja" :value="selectedBelanja.id_belanja">

            <x-modal show="showDeleteBidangModal">
                <h2 class="text-lg font-semibold mb-4">Hapus Bidang</h2>
                <p>Apakah Anda yakin ingin menghapus bidang "<span x-text="selectedBelanja.nama"></span>"?</p>

                <div class="flex justify-end mt-4 space-x-2">
                    <x-button type="button" @click="showDeleteBidangModal = false; showDetailBidangModal = true"
                        variant="secondary">Batal</x-button>
                    <x-button type="submit" variant="danger">Hapus</x-button>
                </div>
            </x-modal>
        </form>

        <!-- Modal Detail Bidang -->
        <x-modal show="showDetailBidangModal" title="Detail Bidang">
            <div class="border p-2 rounded-xl">
                <h2 class="text-xs text-gray-400 ">Nama Bidang</h2>
                <h2 class="text-lg font-semibold text-gray-800" x-text="selectedBelanja.nama"></h2>
            </div>

            <div class="flex justify-end gap-3 pt-6">
                <x-button variant="secondary" @click="showDetailBidangModal = false">Tutup</x-button>
                <x-button variant="warning"
                    @click="showDetailBidangModal = false; showEditBidangModal = true">Edit</x-button>
                <x-button variant="danger"
                    @click="showDetailBidangModal = false; showDeleteBidangModal = true">Hapus</x-button>
            </div>
        </x-modal>
    </div>
</x-admin-layout>
