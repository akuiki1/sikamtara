<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    {{-- Stat Cards --}}
    {{-- Stat Cards --}}
    <section class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        @php
            $cards = [
                ['title' => 'Penerimaan', 'data' => $totalPenerimaan, 'color' => 'green'],
                ['title' => 'Pengeluaran', 'data' => $totalPengeluaran, 'color' => 'red'],
            ];
        @endphp

        @foreach ($cards as $card)
            @php
                $anggaran = $card['data']['anggaran'];
                $realisasi = $card['data']['realisasi'];
                $selisih = $card['data']['selisih'];

                $isSurplus = $selisih > 0;
                $isDefisit = $selisih < 0;

                $badgeText = $isSurplus ? 'Surplus' : ($isDefisit ? 'Defisit' : 'Balance');
                $badgeColor = $isSurplus
                    ? 'bg-green-100 text-green-700'
                    : ($isDefisit
                        ? 'bg-red-100 text-red-700'
                        : 'bg-gray-100 text-gray-600');

                $textColor = "text-{$card['color']}-600";
                $selisihColor = $isSurplus ? 'text-green-600' : ($isDefisit ? 'text-red-600' : 'text-blue-600');

                $percentRealisasi = $anggaran > 0 ? round(($realisasi / $anggaran) * 100, 2) : 0;
                $percentSelisih = $anggaran > 0 ? round((abs($selisih) / $anggaran) * 100, 2) : 0;

                $barClass = fn($percent) => $percent >= 90
                    ? 'bg-green-500'
                    : ($percent >= 70
                        ? 'bg-yellow-500'
                        : 'bg-red-500');
            @endphp

            <div class="bg-white border border-gray-100 rounded-2xl shadow p-5 hover:shadow-md transition duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-700">{{ $card['title'] }}</h3>
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $badgeColor }}">
                        {{ $badgeText }}
                    </span>
                </div>

                <div class="space-y-4 text-sm text-gray-600">
                    {{-- Anggaran (tanpa progress bar) --}}
                    <div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Anggaran</span>
                            <span class="font-semibold {{ $textColor }}">
                                Rp {{ number_format($anggaran, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Realisasi --}}
                    <div>
                        <div class="flex justify-between mb-0.5">
                            <span class="text-gray-500">Realisasi</span>
                            <span class="font-semibold {{ $textColor }}">
                                Rp {{ number_format($realisasi, 2, ',', '.') }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full">
                            <div class="{{ $barClass($percentRealisasi) }} h-2 rounded-full transition-all duration-300"
                                style="width: {{ min($percentRealisasi, 100) }}%">
                            </div>
                        </div>
                    </div>

                    {{-- Selisih --}}
                    <div>
                        <div class="flex justify-between mb-0.5">
                            <span class="text-gray-500">Selisih</span>
                            <span class="font-semibold {{ $selisihColor }}">
                                Rp {{ number_format($selisih, 2, ',', '.') }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full">
                            <div class="{{ $selisih > 0 ? 'bg-green-500' : ($selisih < 0 ? 'bg-red-500' : 'bg-blue-400') }} h-2 rounded-full transition-all duration-300"
                                style="width: {{ min($percentSelisih, 100) }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>

    {{-- halaman inti --}}
    <section x-data="{
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        selectedItem: null,
    }">
        {{-- Data Table --}}
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">

            {{-- header --}}
            <div class="mb-3 flex justify-between items-center">
                <form method="GET" action="{{ route('adminapbdes.pembiayaan') }}" class="py-1">
                    <div x-data="{ open: false }" class="relative w-48">
                        <!-- Trigger Button -->
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-2 border border-gray-300 rounded-xl bg-white shadow-sm hover:bg-gray-50 focus:outline-none focus:ring focus:ring-blue-200 transition">
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
                @if ($tahunDipilih)
                    <x-button @click="showAddModal = true">
                        Tambah Pembiayaan
                    </x-button>
                @endif
            </div>

            {{-- table --}}
            @if ($tahunDipilih)
                <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr class="bg-indigo-400 text-gray-50 uppercase text-xs font-semibold tracking-wider">
                                <th class="py-2 px-3 w-52 text-left">Nama</th>
                                <th class="py-2 px-3 text-left">Anggaran</th>
                                <th class="py-2 px-3 text-left">Realisasi</th>
                                <th class="py-2 px-3 text-left">Selisih</th>
                                <th class="py-2 px-3 text-center w-24">Jenis</th>
                                <th class="py-2 px-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pembiayaan as $item)
                                <tr class="divide-y divide-gray-50">
                                    <td class="py-2 px-3 w-52">{{ $item->nama }}</td>
                                    <td class="py-2 px-3 text-left">Rp
                                        {{ number_format($item->anggaran, 2, ',', '.') }}
                                    </td>
                                    <td class="py-2 px-3 text-left">Rp
                                        {{ number_format($item->realisasi, 2, ',', '.') }}
                                    </td>
                                    <td
                                        class="py-2 px-3 {{ $item->selisih > 0 ? 'text-green-600' : ($item->selisih < 0 ? 'text-red-600' : 'text-blue-600') }}">
                                        Rp {{ number_format($item->selisih, 2, ',', '.') }}
                                    </td>
                                    <td class="py-2 px-3 capitalize w-24 text-center">{{ $item->jenis }}</td>
                                    <td class="py-2 px-3 text-center">
                                        <button @click="selectedItem = {{ Js::from($item) }}; showEditModal = true;"
                                            class="text-blue-500 hover:underline text-sm">
                                            Edit
                                        </button>
                                        <button @click="selectedItem = {{ Js::from($item) }}; showDeleteModal = true;"
                                            class="text-red-500 hover:underline text-sm ml-3">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-400">Belum ada data pembiayaan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-gray-500 p-8 border rounded-xl">
                    <p class="text-sm">Silahkan Pilih Tahun Terlebih Dahulu</p>
                </div>
            @endif
        </div>

        {{-- add modal --}}
        <x-modal show="showAddModal" title="Tambah Pembiayaan Baru">
            <form method="POST" action="{{ route('adminapbdes.pembiayaan.store') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama Pembiayaan -->
                    <div>
                        <label class="block text-sm text-gray-700">Nama Pembiayaan</label>
                        <input type="text" name="nama" required
                            class="form-input w-full border rounded-xl mt-1 h-8 px-4" />
                    </div>

                    <!-- Tahun Anggaran -->
                    <input type="hidden" name="id_tahun_anggaran"
                        value="{{ optional($tahunList->firstWhere('tahun', $tahunDipilih))->id_tahun_anggaran }}">


                    <!-- Jenis -->
                    <div>
                        <label class="block text-sm text-gray-700">Jenis</label>
                        <select name="jenis" required class="form-select w-full border rounded-xl mt-1 h-8 px-4">
                            <option value="penerimaan">Penerimaan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>

                    <!-- Anggaran -->
                    <div>
                        <label class="block text-sm text-gray-700">Anggaran</label>
                        <input type="number" name="anggaran" step="0.01" required
                            class="form-input w-full border rounded-xl mt-1 h-8 px-4" />
                    </div>

                    <!-- Realisasi -->
                    <div>
                        <label class="block text-sm text-gray-700">Realisasi</label>
                        <input type="number" name="realisasi" step="0.01" required
                            class="form-input w-full border rounded-xl mt-1 h-8 px-4" />
                    </div>
                </div>

                <div class="pt-4 text-right">
                    <x-button @click="showAddModal = false" variant="secondary">tutup</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- edit modal --}}
        <form method="POST" action="{{ route('adminapbdes.pembiayaan.update') }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="id_pembiayaan" :value="selectedItem?.id_pembiayaan">

            <x-modal show="showEditModal" title="Edit Pembiayaan">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama -->
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Nama</label>
                        <input type="text" name="nama" required
                            class="w-full px-3 py-2 text-sm border rounded-lg focus:ring focus:ring-indigo-200"
                            x-model="selectedItem.nama">
                    </div>

                    <!-- Jenis -->
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Jenis</label>
                        <select name="jenis" required class="w-full px-3 py-2 text-sm border rounded-lg"
                            x-model="selectedItem.jenis">
                            <option value="penerimaan">Penerimaan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>

                    <!-- Anggaran -->
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Anggaran</label>
                        <input type="number" name="anggaran" step="0.01" min="0"
                            class="w-full px-3 py-2 text-sm border rounded-lg" x-model="selectedItem.anggaran">
                    </div>

                    <!-- Realisasi -->
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Realisasi</label>
                        <input type="number" name="realisasi" step="0.01" min="0"
                            class="w-full px-3 py-2 text-sm border rounded-lg" x-model="selectedItem.realisasi">
                    </div>
                </div>

                <!-- Tahun Anggaran -->
                <input type="hidden" name="id_tahun_anggaran" :value="selectedItem.id_tahun_anggaran">
                <input type="hidden" name="id_pembiayaan" :value="selectedItem.id_pembiayaan">

                <!-- Tombol -->
                <div class="flex justify-end space-x-2 mt-5">
                    <x-button type="button" variant="secondary" @click="showEditModal = false">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </x-modal>
        </form>

        {{-- hapus modal --}}
        <form method="POST" action="{{ route('adminapbdes.pembiayaan.delete') }}">
            @csrf
            @method('DELETE')

            <!-- Hidden ID -->
            <input type="hidden" name="id_pembiayaan" :value="selectedItem?.id_pembiayaan">

            <x-modal show="showDeleteModal" title="Hapus Pembiayaan">
                <div class="text-sm text-gray-700 mb-6">
                    Yakin ingin menghapus pembiayaan:
                    <span class="font-semibold text-red-600" x-text="selectedItem?.nama"></span>?
                    <br>
                    Tindakan ini tidak dapat dibatalkan.
                </div>

                <div class="flex justify-end space-x-2">
                    <x-button type="button" variant="secondary" @click="showDeleteModal = false">Batal</x-button>
                    <x-button type="submit" variant="danger">Hapus</x-button>
                </div>
            </x-modal>
        </form>
    </section>
</x-admin-layout>
