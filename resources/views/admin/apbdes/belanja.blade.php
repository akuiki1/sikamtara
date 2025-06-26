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

            if ($totalSelisih > 0) {
                $badge =
                    '<span class="px-2 py-0.5 text-xs font-semibold text-green-600 bg-green-100 rounded-full">Surplus</span>';
                $bgClass = 'bg-white';
                $textClass = 'text-green-600';
            } elseif ($totalSelisih < 0) {
                $badge =
                    '<span class="px-2 py-0.5 text-xs font-semibold text-red-600 bg-red-100 rounded-full">Defisit</span>';
                $bgClass = 'bg-white';
                $textClass = 'text-red-600';
            } else {
                $badge = '';
                $bgClass = 'bg-gray-50';
                $textClass = 'text-gray-800';
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
            {{-- Anggaran Belanja --}}
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                <p class="text-gray-500 text-sm">Anggaran Belanja</p>
                <h2 class="text-xl font-bold text-green-600 mt-1">
                    Rp {{ number_format($totalAnggaran, 2, ',', '.') }}
                </h2>
            </div>

            {{-- Realisasi --}}
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                <p class="text-gray-500 text-sm">Total Realisasi Belanja</p>
                <h2 class="text-xl font-bold text-red-500 mt-1">
                    Rp {{ number_format($totalRealisasi, 2, ',', '.') }}
                </h2>
            </div>

            {{-- Selisih --}}
            <div class="rounded-2xl shadow-sm p-5 border border-gray-100 {{ $bgClass }}">
                <div class="flex justify-between items-center">
                    <p class="text-gray-500 text-sm">Selisih</p>
                    {!! $badge !!}
                </div>
                <h2 class="text-xl font-bold mt-1 {{ $textClass }}">
                    Rp {{ number_format($totalSelisih, 2, ',', '.') }}
                </h2>
            </div>
        </div>
    </section>

    {{-- container --}}
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
        selectedBelanja: null,
    
        formatRupiah(value) {
            if (!value) return 'Rp 0';
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
        }
    }">

        {{-- header --}}
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

            @if ($tahunDipilih)
                <div>
                    <x-button @click="showAddBidangModal = true">Tambah Bidang</x-button>
                    <x-button @click="showAddRincianModal = true">Tambah Rincian Belanja</x-button>
                </div>
            @endif
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

                            {{-- Tampilkan tombol tambah jika rincian kosong --}}
                            @if ($belanja->rincianBelanja->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500">
                                        Belum ada rincian belanja.<br>
                                        <button
                                            @click="selectedBelanja = {{ json_encode($belanja) }}; showAddRincianModal = true"
                                            class="mt-2 px-3 py-1 bg-indigo-500 text-white text-sm rounded hover:bg-indigo-600 transition">
                                            + Tambah Rincian
                                        </button>
                                    </td>
                                </tr>
                            @else
                                @foreach ($belanja->rincianBelanja as $rincian)
                                    @php
                                        $totalAnggaran += $rincian->anggaran ?? 0;
                                        $totalRealisasi += $rincian->realisasi ?? 0;
                                        $totalSelisih += $rincian->selisih ?? 0;
                                    @endphp
                                    <tr class="border-t">
                                        <td class="px-4 py-2 cursor-pointer hover:underline"
                                            @click="selectedItem = {{ json_encode($rincian) }}; showDetailRincianModal = true">
                                            {{ $rincian->nama }}
                                        </td>
                                        <td class="px-4 py-2">Rp
                                            {{ number_format($rincian->anggaran ?? 0, 2, ',', '.') }}</td>
                                        <td class="px-4 py-2">Rp
                                            {{ number_format($rincian->realisasi ?? 0, 2, ',', '.') }}</td>
                                        <td class="px-4 py-2">Rp
                                            {{ number_format($rincian->selisih ?? 0, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif


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
        @else
            <div class="text-center text-gray-500 p-8 border rounded-xl">
                <p class="text-sm">Silahkan Pilih Tahun Terlebih Dahulu</p>
            </div>
        @endif

        <!-- Modal Add Bidang -->
        <form method="POST" action="{{ route('bidang.belanja.store') }}">
            @csrf

            <x-modal show="showAddBidangModal" title="Tambah Bidang">
                <!-- Input Nama Bidang -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1" for="nama">Nama Bidang</label>
                    <input type="text" name="nama" id="nama"
                        class="w-full px-4 py-3 text-xl font-semibold text-gray-800 border rounded-xl focus:outline-none focus:ring focus:ring-indigo-200"
                        required>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-2 mt-6">
                    <x-button type="button" @click="showAddBidangModal = false" variant="secondary">Batal</x-button>
                    <x-button type="submit" variant="primary">Simpan</x-button>
                </div>
            </x-modal>
        </form>

        <!-- Modal Edit Bidang -->
        <form method="POST" action="{{ route('bidang.belanja.update') }}">
            @csrf
            @method('PUT')

            <!-- Kirim ID bidang sebagai hidden input -->
            <input type="hidden" name="id_belanja" :value="selectedBelanja.id_belanja">

            <x-modal show="showEditBidangModal" title="Edit Bidang">
                <div class="">
                    <label class="block text-xs text-gray-500 mb-1" for="nama">Nama Bidang</label>
                    <input type="text" name="nama" id="nama" x-model="selectedBelanja.nama"
                        class="w-full h-full py-1 px-2 rounded-xl border text-gray-800 focus:outline-none focus:ring focus:ring-indigo-200"
                        required>
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

        {{-- Modal Add Rincian --}}
        <form method="POST" action="{{ route('rincian.belanja.store') }}">
            @csrf

            <x-modal show="showAddRincianModal" title="Tambah Rincian Belanja">
                <div class="space-y-4">
                    {{-- PILIH BIDANG (id_belanja) --}}
                    <div>
                        <label for="id_belanja" class="block text-sm font-medium">Pilih Bidang</label>
                        <select name="id_belanja" id="id_belanja" class="mt-1 block w-full p-2 border rounded"
                            required>
                            <option value="">-- Pilih Bidang --</option>
                            @foreach ($data as $belanja)
                                <option value="{{ $belanja->id_belanja }}">
                                    {{ $belanja->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- PILIH TAHUN ANGGARAN --}}
                    <div>
                        <label for="id_tahun_anggaran" class="block text-sm font-medium">Pilih Tahun Anggaran</label>
                        <select name="id_tahun_anggaran" id="id_tahun_anggaran"
                            class="mt-1 block w-full p-2 border rounded" required>
                            <option value="">-- Pilih Tahun --</option>
                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun->id_tahun_anggaran }}">
                                    {{ $tahun->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- NAMA RINCIAN --}}
                    <div>
                        <label for="nama" class="block text-sm font-medium">Nama Rincian</label>
                        <input type="text" name="nama" id="nama"
                            class="mt-1 block w-full p-2 border rounded" required>
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
                </div>

                <div class="flex justify-end mt-6 space-x-2">
                    <x-button type="button" @click="showAddRincianModal = false"
                        variant="secondary">Batal</x-button>
                    <x-button type="submit" variant="primary">Simpan</x-button>
                </div>
            </x-modal>
        </form>

        {{-- Modal Detail Rincian --}}
        <x-modal show="showDetailRincianModal" title="Detail Rincian Belanja">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama</label>
                <p class="text-lg font-semibold text-gray-800" x-text="selectedItem?.nama"></p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-500 mb-1">Anggaran</label>
                <p class="text-gray-800" x-text="formatRupiah(selectedItem?.anggaran)"></p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-500 mb-1">Realisasi</label>
                <p class="text-gray-800" x-text="formatRupiah(selectedItem?.realisasi)"></p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-500 mb-1">Selisih</label>
                <p class="text-gray-800" x-text="formatRupiah(selectedItem?.selisih)"></p>
            </div>

            <div class="flex justify-end space-x-2">
                <x-button @click="showDetailRincianModal = false" variant="secondary">Tutup</x-button>
                <x-button @click="showDetailRincianModal = false; showEditRincianModal = true"
                    variant="warning">Edit</x-button>
                <x-button @click="showDetailRincianModal = false; showDeleteRincianModal = true"
                    variant="danger">Hapus</x-button>
            </div>
        </x-modal>

        {{-- Modal Edit Rincian --}}
        <form method="POST" action="{{ route('rincian.belanja.update') }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="id_rincian_belanja" :value="selectedItem?.id_rincian_belanja">

            <x-modal show="showEditRincianModal" title="Edit Rincian Belanja">
                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-sm text-gray-500 mb-1" for="nama">Nama Rincian</label>
                    <input type="text" id="nama" name="nama"
                        class="w-full px-4 py-3 text-xl font-semibold text-gray-800 border rounded-xl focus:ring-indigo-300"
                        x-model="selectedItem?.nama" required>
                </div>

                <!-- Anggaran -->
                <div class="mb-4">
                    <label class="block text-sm text-gray-500 mb-1" for="anggaran">Anggaran</label>
                    <input type="text" id="anggaran" name="anggaran" class="w-full px-4 py-2 border rounded-xl"
                        x-model="selectedItem.anggaran"
                        @input="selectedItem.anggaran = $event.target.value.replace(',', '.')">
                </div>


                <!-- Realisasi -->
                <div class="mb-4">
                    <label class="block text-sm text-gray-500 mb-1" for="realisasi">Realisasi</label>
                    <input type="number" id="realisasi" name="realisasi" class="w-full px-4 py-2 border rounded-xl"
                        x-model="selectedItem?.realisasi">
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-2 mt-6">
                    <x-button type="button" @click="showEditRincianModal = false; showDetailRincianModal = true"
                        variant="secondary">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </x-modal>
        </form>

        {{-- Modal Hapus Rincian --}}
        <form method="POST" action="{{ route('rincian.belanja.destroy') }}">
            @csrf
            @method('DELETE')

            <input type="hidden" name="id_rincian_belanja" :value="selectedItem.id_rincian_belanja">

            <x-modal show="showDeleteRincianModal" title="Hapus Rincian Belanja">
                <p class="text-sm text-gray-600 mb-4">
                    Apakah Anda yakin ingin menghapus rincian "<span x-text="selectedItem.nama"></span>"?
                </p>

                <div class="flex justify-end space-x-2">
                    <x-button type="button" @click="showDeleteRincianModal = false; showDetailRincianModal = true"
                        variant="secondary">Batal</x-button>
                    <x-button type="submit" variant="danger">Hapus</x-button>
                </div>
            </x-modal>
        </form>
    </div>
</x-admin-layout>
