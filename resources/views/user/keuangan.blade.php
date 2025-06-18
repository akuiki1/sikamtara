<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-10 px-6 text-center">
    </section>


    <section class="p-6 space-y-6" x-data="{
        search: '',
        tahun: '{{ $tahunTerbaru }}',
        tahunOptions: @js($tahun),
        groupedBelanja: @js($groupedBelanja),
        apbdes: @js($detailJs),
    
        formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },
    
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
    
        get pembiayaan() {
            return this.filteredApbdes.filter(i => i.kategori === 'pembiayaan');
        },
    
        get filteredBelanja() {
            return this.groupedBelanja
                .map(group => {
                    const filteredChildren = group.children.filter(item => item.tahun.toString() === this.tahun);
                    return {
                        ...group,
                        children: filteredChildren
                    };
                })
                .filter(group => group.children.length > 0);
        },
    
        get totalAnggaranPendapatan() {
            return this.pendapatan.reduce((sum, i) => sum + i.anggaran, 0);
        },
    
        get totalRealisasiPendapatan() {
            return this.pendapatan.reduce((sum, i) => sum + i.realisasi, 0);
        },
    
        get totalAnggaranBelanja() {
            return this.filteredBelanja.reduce((sum, g) => sum + g.children.reduce((s, i) => s + i.anggaran, 0), 0);
        },
    
        get totalRealisasiBelanja() {
            return this.filteredBelanja.reduce((sum, g) => sum + g.children.reduce((s, i) => s + i.realisasi, 0), 0);
        },
    
        get totalAnggaranPembiayaan() {
            return this.pembiayaan.reduce((sum, i) => sum + i.anggaran, 0);
        },
    
        get totalRealisasiPembiayaan() {
            return this.pembiayaan.reduce((sum, i) => sum + i.realisasi, 0);
        }
    }">



        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Laporan APBDes</h1>
                <p class="text-gray-500 text-sm">Anggaran Pendapatan dan Belanja Desa per Tahun</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <select x-model="tahun"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <template x-for="item in tahunOptions" :key="item.id_apbdes">
                        <option :value="item.tahun" x-text="item.tahun"></option>
                    </template>
                </select>
                <form action="{{ route('apbdes.export') }}" method="GET" x-ref="exportForm">
                    <input type="hidden" name="tahun" :value="tahun">
                    <x-button type="submit"
                        class="bg-green-600 hover:bg-green-700 transition px-4 py-2 rounded-lg text-white text-sm font-medium">
                        Export Excel
                    </x-button>
                </form>
            </div>
        </div>

        <!-- Ringkasan Card -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <template
                x-for="card in [
        { title: 'Pendapatan', tooltip: 'Dana masuk desa', icon: 'cash', color: 'blue', anggaran: totalAnggaranPendapatan, realisasi: totalRealisasiPendapatan },
        { title: 'Belanja', tooltip: 'Pengeluaran desa', icon: 'receipt-refund', color: 'red', anggaran: totalAnggaranBelanja, realisasi: totalRealisasiBelanja },
        { title: 'Pembiayaan', tooltip: 'Penerimaan atau pengeluaran pembiayaan', icon: 'credit-card', color: 'yellow', anggaran: totalAnggaranPembiayaan, realisasi: totalRealisasiPembiayaan }
    ]"
                :key="card.title">
                <div class="rounded-xl border border-gray-200 bg-white shadow hover:shadow-md transition p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <!-- Icon -->
                            <div class="p-2 bg-opacity-20 rounded-full">
                                <!-- Gunakan SVG kamu di sini -->
                                <template x-if="card.icon === 'cash'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-700"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 9V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2m2 4h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2Zm7-5a2 2 0 1 1-4 0a2 2 0 0 1 4 0Z" />
                                    </svg>
                                </template>
                                <template x-if="card.icon === 'receipt-refund'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-700" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16l-3-2l-2 2l-2-2l-2 2l-2-2l-3 2" />
                                        <path d="M15 14v-2a2 2 0 0 0-2-2H9l2-2m0 4l-2-2" />
                                    </svg>
                                </template>
                                <template x-if="card.icon === 'credit-card'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M7 15h3a1 1 0 0 0 0-2H7a1 1 0 0 0 0 2ZM19 5H5a3 3 0 0 0-3 3v9a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3Zm1 12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6h16Zm0-8H4V8a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1Z" />
                                    </svg>
                                </template>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg text-gray-800" x-text="card.title"></h3>
                                <p class="text-xs text-gray-500" x-text="card.tooltip"></p>
                            </div>
                        </div>
                        <span class="text-sm font-bold bg-gray-100 px-2 py-1 rounded" x-text="tahun"></span>
                    </div>

                    <div class="space-y-1 text-sm text-gray-600">
                        <div>Anggaran: <span class="font-medium text-gray-800"
                                x-text="formatRupiah(card.anggaran)"></span></div>
                        <div>Realisasi: <span class="font-medium text-gray-800"
                                x-text="formatRupiah(card.realisasi)"></span></div>
                        <div>Selisih: <span class="font-medium text-gray-800"
                                x-text="formatRupiah(card.anggaran - card.realisasi)"></span></div>
                    </div>

                    <div class="mt-4">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full transition-all duration-500" :class="`bg-${card.color}-500`"
                                :style="`width: ${(card.realisasi / card.anggaran * 100).toFixed(1)}%`"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1"
                            x-text="`${(card.realisasi / card.anggaran * 100).toFixed(1)}% realisasi`"></p>
                    </div>
                </div>
            </template>
        </div>

        <!-- Konten -->
        <div class="space-y-12 mt-12">
            <template
                x-for="(section, index) in [
    { title: 'Pendapatan', color: 'blue', items: pendapatan, totalAnggaran: totalAnggaranPendapatan, totalRealisasi: totalRealisasiPendapatan },
    { title: 'Belanja', color: 'red', items: filteredBelanja, totalAnggaran: totalAnggaranBelanja, totalRealisasi: totalRealisasiBelanja },
    { title: 'Pembiayaan', color: 'yellow', items: pembiayaan, totalAnggaran: totalAnggaranPembiayaan, totalRealisasi: totalRealisasiPembiayaan }
  ]"
                :key="index">

                <div
                    class="rounded-2xl overflow-hidden shadow-lg border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900 transition-all duration-300">
                    <!-- Header -->
                    <div :class="`bg-gradient-to-r from-${section.color}-100 to-${section.color}-200 dark:from-${section.color}-900 dark:to-${section.color}-800`"
                        class="px-6 py-5 flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white" x-text="section.title"></h2>
                            <p class="text-sm text-gray-500 dark:text-gray-300">
                                Laporan tahun <span x-text="tahun"></span>
                            </p>
                        </div>
                        <div
                            class="inline-flex items-center gap-2 bg-white/70 dark:bg-black/30 border border-gray-200 dark:border-gray-700 rounded-full px-4 py-1 text-sm text-gray-800 dark:text-gray-100 font-semibold shadow-sm">
                            Realisasi:
                            <span
                                :class="{
                                    'text-green-600 dark:text-green-400': section.totalRealisasi / section
                                        .totalAnggaran >= 0.85,
                                    'text-yellow-500 dark:text-yellow-400': section.totalRealisasi / section
                                        .totalAnggaran < 0.85 && section.totalRealisasi / section.totalAnggaran >= 0.6,
                                    'text-red-600 dark:text-red-400': section.totalRealisasi / section.totalAnggaran <
                                        0.6
                                }"
                                x-text="`${(section.totalRealisasi / section.totalAnggaran * 100).toFixed(1)}%`">
                            </span>
                        </div>
                    </div>

                    <!-- Tabel -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-sm text-gray-700 dark:text-gray-200">
                            <thead
                                class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 uppercase tracking-wide text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-3 text-left whitespace-nowrap">Uraian</th>
                                    <th class="px-6 py-3 text-right whitespace-nowrap">Anggaran</th>
                                    <th class="px-6 py-3 text-right whitespace-nowrap">Realisasi</th>
                                    <th class="px-6 py-3 text-right whitespace-nowrap">Selisih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-if="section.title === 'Belanja'">
                                    @include('components.belanja-table')
                                </template>


                                <!-- Untuk Pendapatan & Pembiayaan -->
                                <template x-if="section.title !== 'Belanja'">
                                    <template x-for="item in section.items" :key="item.id_rincian">
                                        <tr
                                            class="border-t border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/60 transition">
                                            <td class="px-6 py-4" x-text="item.judul"></td>
                                            <td class="px-6 py-4 text-right" x-text="formatRupiah(item.anggaran)">
                                            </td>
                                            <td class="px-6 py-4 text-right" x-text="formatRupiah(item.realisasi)">
                                            </td>
                                            <td class="px-6 py-4 text-right"
                                                :class="(item.anggaran - item.realisasi) < 0 ?
                                                    'text-red-600 dark:text-red-400' : ''"
                                                x-text="formatRupiah(item.anggaran - item.realisasi)"></td>
                                        </tr>
                                    </template>
                                </template>


                                <!-- Empty State -->
                                <template x-if="section.items.length === 0">
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-6 text-center text-gray-400 italic dark:text-gray-500">
                                            Data tidak tersedia
                                        </td>
                                    </tr>
                                </template>
                            </tbody>

                            <!-- Footer Total -->
                            <tfoot class="bg-gray-50 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-100">
                                <tr>
                                    <td class="px-6 py-4 text-right" colspan="1">
                                        Total <span x-text="section.title.toLowerCase()"></span>
                                    </td>
                                    <td class="px-6 py-4 text-right" x-text="formatRupiah(section.totalAnggaran)">
                                    </td>
                                    <td class="px-6 py-4 text-right" x-text="formatRupiah(section.totalRealisasi)">
                                    </td>
                                    <td class="px-6 py-4 text-right"
                                        x-text="formatRupiah(section.totalAnggaran - section.totalRealisasi)"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </template>
        </div>
    </section>
</x-layout>
