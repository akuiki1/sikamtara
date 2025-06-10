<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-10 px-6 text-center">
    </section>

    <section class="p-6 space-y-6" x-data="{
        search: '',
        tahun: '',
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        selectedApbdes: null,
        apbdes: @js($detailJs),
        get filteredApbdes() {
            return this.apbdes.filter(item => {
                const matchesSearch = this.search === '' || item.judul.toLowerCase().includes(this.search.toLowerCase()) || item.sub_judul.toLowerCase().includes(this.search.toLowerCase());
                const matchesTahun = this.tahun === '' || item.tahun.toString() === this.tahun;
                return matchesSearch && matchesTahun;
            });
        },
        get pendapatan() {
            return this.filteredApbdes.filter(i => i.kategori === 'pendapatan');
        },
        get belanja() {
            return this.filteredApbdes.filter(i => i.kategori === 'belanja');
        },
        get pembiayaan() {
            return this.filteredApbdes.filter(i => i.kategori === 'pembiayaan');
        },
        get totalAnggaranPendapatan() {
            return this.pendapatan.reduce((sum, i) => sum + i.anggaran, 0);
        },
        get totalRealisasiPendapatan() {
            return this.pendapatan.reduce((sum, i) => sum + i.realisasi, 0);
        },
    
    }">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Laporan APBDes</h1>
                <p class="text-sm text-gray-600">Anggaran Pendapatan dan Belanja Desa per tahun</p>
            </div>
            <div class="flex gap-4 flex-wrap">
                {{-- Dropdown tahun --}}
                <select x-model="tahun"
                    class="pl-4 pr-4 py-2 rounded-full border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <template x-for="item in {{ Js::from($tahun) }}" :key="item">
                        <option :value="item.tahun" x-text="item.tahun"></option>
                    </template>
                </select>


                {{-- Tombol unduh --}}
                <a :href="`/apbdes/export?tahun=${tahunDipilih}`"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Unduh Excel
                </a>
            </div>
        </div>

        {{-- Konten --}}
        <div class="space-y-6">
            {{-- Pendapatan --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="bg-blue-100 px-4 py-3 font-semibold text-blue-900">
                    Pendapatan
                </div>
                <div class="overflow-x-auto">
                    <x-table class="min-w-full text-sm text-left border-t">
                        <x-slot name="head" class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">Sumber</th>
                                <th class="px-4 py-2 border">Anggaran</th>
                                <th class="px-4 py-2 border">Realisasi</th>
                            </tr>
                        </x-slot>
                        <x-slot name="body">
                            <template x-for="item in pendapatan" :key="item.id_rincian">
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 border" x-text="item.judul"></td>
                                    <td class="px-4 py-2 border" x-text="item.anggaran"></td>
                                    <td class="px-4 py-2 border" x-text="item.realisasi"></td>
                                </tr>
                            </template>
                            <template x-if="pendapatan.length === 0">
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-gray-500">Data kosong</td>
                                </tr>
                            </template>
                        </x-slot>
                        <x-slot name="footer">
                            <tr>
                                <td class="px-4 py-2 border font-bold text-right" colspan="1">Total pendapatan desa
                                    kambat utara tahun anggaran <strong x-model="tahun"></strong> </td>
                                <td class="px-4 py-2 border font-bold" x-text="totalAnggaranPendapatan"></td>
                                <td class="px-4 py-2 border font-bold" x-text="totalRealisasiPendapatan"></td>
                            </tr>
                        </x-slot>
                    </x-table>
                </div>
            </div>

            {{-- Belanja --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="bg-red-100 px-4 py-3 font-semibold text-red-900">
                    Belanja
                </div>
                <div class="overflow-x-auto">
                    <x-table class="min-w-full text-sm text-left border-t">
                        <x-slot name="head" class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">Sumber</th>
                                <th class="px-4 py-2 border">Anggaran</th>
                                <th class="px-4 py-2 border">Realisasi</th>
                            </tr>
                        </x-slot>
                        <x-slot name="body">
                            <template x-for="item in belanja" :key="item.id_rincian">
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 border" x-text="item.judul"></td>
                                    <td class="px-4 py-2 border" x-text="item.anggaran"></td>
                                    <td class="px-4 py-2 border" x-text="item.realisasi"></td>
                                </tr>
                            </template>
                            <template x-if="belanja.length === 0">
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-gray-500">Data kosong</td>
                                </tr>
                            </template>
                        </x-slot>
                        <x-slot name="footer">
                            <tr>
                                <td class="px-4 py-2 border font-bold text-right" colspan="1">Total pendapatan desa
                                    kambat utara tahun anggaran <strong x-model="tahun"></strong> </td>
                                <td class="px-4 py-2 border font-bold" x-text="totalAnggaranPendapatan"></td>
                                <td class="px-4 py-2 border font-bold" x-text="totalRealisasiPendapatan"></td>
                            </tr>
                        </x-slot>
                    </x-table>
                </div>
            </div>

            {{-- Pembiayaan --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="bg-yellow-100 px-4 py-3 font-semibold text-yellow-900">
                    Pembiayaan
                </div>
                <div class="overflow-x-auto">
                    <x-table class="min-w-full text-sm text-left border-t">
                        <x-slot name="head" class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">Sumber</th>
                                <th class="px-4 py-2 border">Anggaran</th>
                                <th class="px-4 py-2 border">Realisasi</th>
                            </tr>
                        </x-slot>
                        <x-slot name="body">
                            <template x-for="item in pembiayaan" :key="item.id_rincian">
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 border" x-text="item.judul"></td>
                                    <td class="px-4 py-2 border" x-text="item.anggaran"></td>
                                    <td class="px-4 py-2 border" x-text="item.realisasi"></td>
                                </tr>
                            </template>
                            <template x-if="pembiayaan.length === 0">
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-gray-500">Data kosong</td>
                                </tr>
                            </template>
                        </x-slot>
                        <x-slot name="footer">
                            <tr>
                                <td class="px-4 py-2 border font-bold text-right" colspan="1">Total pendapatan desa
                                    kambat utara tahun anggaran <strong x-model="tahun"></strong> </td>
                                <td class="px-4 py-2 border font-bold" x-text="totalAnggaranPendapatan"></td>
                                <td class="px-4 py-2 border font-bold" x-text="totalRealisasiPendapatan"></td>
                            </tr>
                        </x-slot>
                    </x-table>
                </div>
            </div>
        </div>
    </section>


</x-layout>
