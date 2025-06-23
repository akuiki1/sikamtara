<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="p-4 bg-white rounded-xl" x-data="{ showEditModal: false, showDeleteModal: false, selectedItem: null }">

        <!-- Pilih Tahun -->
        <form method="GET" class="mb-4">
            <label for="tahun" class="block font-medium">Pilih Tahun:</label>
            <select name="tahun" id="tahun" onchange="this.form.submit()" class="mt-1 p-2 border rounded">
                <option value="">-- Pilih Tahun --</option>
                @foreach ($tahunList as $tahun)
                    <option value="{{ $tahun->tahun }}" {{ request('tahun') == $tahun->tahun ? 'selected' : '' }}>
                        {{ $tahun->tahun }}
                    </option>
                @endforeach
            </select>
        </form>
        @if ($tahunDipilih)
            @foreach ($data as $belanja)
                <div class="border rounded mb-4">
                    <div class="bg-gray-100 px-4 py-2 font-semibold">{{ $belanja->nama }}</div>

                    @foreach ($belanja->rincianBelanja as $rincian)
                        <div x-data="{ open: false }" class="border-t">
                            <button @click="open = !open"
                                class="w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 flex justify-between">
                                <span>{{ $rincian->nama }}</span>
                                <span x-text="open ? '-' : '+'"></span>
                            </button>

                            <div x-show="open" class="p-4 space-y-2">
                                <div class="border p-3 rounded bg-white shadow">
                                    <div class="font-semibold">{{ $rincian->nama }}</div>
                                    <div class="text-sm">Realisasi:
                                        Rp{{ number_format($rincian->realisasi, 2, ',', '.') }}</div>
                                    <div class="text-sm">Selisih: Rp{{ number_format($rincian->selisih, 2, ',', '.') }}
                                    </div>

                                    <div class="mt-2 space-x-2">
                                        <button
                                            @click="selectedItem = {{ json_encode($rincian) }}; showEditModal = true"
                                            class="text-blue-600 hover:underline">Edit</button>
                                        <button
                                            @click="selectedItem = {{ json_encode($rincian) }}; showDeleteModal = true"
                                            class="text-red-600 hover:underline">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif

        <!-- Modal Edit -->
        <div x-show="showEditModal" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded w-full max-w-md" @click.away="showEditModal = false">
                <h2 class="text-lg font-semibold mb-4">Edit Rincian</h2>

                <form @submit.prevent="console.log('Edit:', selectedItem)">
                    <label class="block mb-2">Nama</label>
                    <input type="text" x-model="selectedItem.nama" class="w-full border p-2 rounded mb-4" />

                    <label class="block mb-2">Realisasi</label>
                    <input type="number" x-model="selectedItem.realisasi" class="w-full border p-2 rounded mb-4" />

                    <label class="block mb-2">Selisih</label>
                    <input type="number" x-model="selectedItem.selisih" class="w-full border p-2 rounded mb-4" />

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="showEditModal = false"
                            class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div x-show="showDeleteModal" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded w-full max-w-md" @click.away="showDeleteModal = false">
                <h2 class="text-lg font-semibold mb-4">Hapus Rincian</h2>
                <p>Apakah Anda yakin ingin menghapus rincian "<span x-text="selectedItem.nama"></span>"?</p>

                <div class="flex justify-end mt-4 space-x-2">
                    <button @click="showDeleteModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button @click="console.log('Delete:', selectedItem)"
                        class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
