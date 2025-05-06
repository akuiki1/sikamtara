<x-layout>
    <div class="p-10">
        <div x-data="apbdesApp()" x-init="init()">
            <!-- Header: Judul + Dropdown Tahun -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 px-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Realisasi APBDes Kambat Utara</h1>
                    <p class="text-gray-600 text-sm">Sesuai peraturan desa nomor 1 tahun 2025</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="text-gray-600 text-sm">
                        Tampilkan data tahun
                    </div>
                    <select x-model="selectedYear" @change="loadData"
                        class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                        <template x-for="year in years" :key="year">
                            <option :value="year" x-text="year"></option>
                        </template>
                    </select>
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 px-6">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <h2 class="text-gray-500">Pendapatan</h2>
                    <p class="text-2xl font-bold text-green-600" x-text="formatCurrency(summary.pendapatan)"></p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <h2 class="text-gray-500">Belanja</h2>
                    <p class="text-2xl font-bold text-red-600" x-text="formatCurrency(summary.belanja)"></p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <h2 class="text-gray-500">Selisih</h2>
                    <p class="text-2xl font-bold text-blue-600" x-text="formatCurrency(summary.selisih)"></p>
                </div>
            </div>

            <!-- Chart -->
            <div class="bg-white rounded-lg shadow p-6 mb-8 px-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Distribusi Realisasi Belanja Tahun <span
                            x-text="selectedYear"></span></h2>
                    <button @click="downloadReport"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                        Unduh Laporan
                    </button>
                </div>
                <div class="w-full flex justify-center">
                    <canvas id="belanjaChart" class="max-w-sm w-full"></canvas>
                </div>
            </div>

            <!-- container lain-lain -->
            <div x-data="lainLainData({!! json_encode($data) !!}, {{ $totalAnggaran }}, {{ $totalRealisasi }})" class="bg-white rounded-lg shadow p-4 mb-4 border">
                <!-- Toggle -->
                <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                    <span class="font-semibold text-lg text-gray-800">Lain-Lain Pendapatan Desa
                        {{ $tahun }}</span>
                    <svg x-bind:class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Progress bar -->
                <div class="mt-3" x-show="!open">
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-400 h-3 rounded-full" :style="`width: ${persentase.toFixed(2)}%`"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">
                        Realisasi: <span x-text="formatRupiah(totalRealisasi)"></span>
                        dari Anggaran: <span x-text="formatRupiah(totalAnggaran)"></span>
                    </p>
                </div>

                <!-- Tabel -->
                <div x-show="open" x-transition class="mt-3">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="px-4 py-2">Sub Kegiatan</th>
                                <th class="px-4 py-2">Anggaran</th>
                                <th class="px-4 py-2">Realisasi</th>
                                <th class="px-4 py-2">Selisih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in data" :key="index">
                                <tr class="border-b">
                                    <td class="px-4 py-2" x-text="item.nama"></td>
                                    <td class="px-4 py-2" x-text="formatRupiah(item.anggaran)"></td>
                                    <td class="px-4 py-2" x-text="formatRupiah(item.realisasi)"></td>
                                    <td class="px-4 py-2" x-text="formatRupiah(item.realisasi - item.anggaran)"></td>
                                </tr>
                            </template>
                        </tbody>
                        <tfoot class="bg-gray-100 text-gray-600 font-semibold">
                            <tr>
                                <th class="px-4 py-2">TOTAL</th>
                                <th class="px-4 py-2" x-text="formatRupiah(totalAnggaran)"></th>
                                <th class="px-4 py-2" x-text="formatRupiah(totalRealisasi)"></th>
                                <th class="px-4 py-2" x-text="formatRupiah(totalRealisasi - totalAnggaran)"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Script Alpine.js di bawah -->
    <script>
        function apbdesApp() {
            return {
                years: [2022, 2023, 2024, 2025],
                selectedYear: new Date().getFullYear(),
                summary: {
                    pendapatan: 0,
                    belanja: 0,
                    selisih: 0
                },
                detailPendapatan: [],
                detailBelanja: [],
                detailPembiayaan: [],
                chart: null,

                init() {
                    this.loadData();
                },

                loadData() {
                    loadData() {
                        fetch(`/informasi/apbdes/${this.selectedYear}`)
                            .then(response => response.json())
                            .then(data => {
                                this.summary = data.summary;
                                this.detailPendapatan = data.detailPendapatan;
                                this.detailBelanja = data.detailBelanja;
                                this.detailPembiayaan = data.detailPembiayaan;
                                this.renderChart();
                            })
                            .catch(error => {
                                console.error('Gagal memuat data APBDes:', error);
                            });
                    }
                },

                formatCurrency(amount) {
                    return 'Rp ' + amount.toLocaleString('id-ID');
                },

                renderChart() {
                    const ctx = document.getElementById('belanjaChart').getContext('2d');
                    if (this.chart) {
                        this.chart.destroy();
                    }
                    this.chart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: this.detailBelanja.map(item => item.nama),
                            datasets: [{
                                data: this.detailBelanja.map(item => item.nilai),
                                backgroundColor: ['#f87171', '#60a5fa', '#34d399', '#fbbf24'],
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                        }
                    });
                },

                downloadReport() {
                    alert('Fitur Unduh Laporan belum dibuat.');
                }
            }
        }
    </script>

    <!-- Chart.js load CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- script alpine.js container lain-lain --}}
    <script>
        function lainLainData(dataFromBackend, totalAnggaranFromBackend, totalRealisasiFromBackend) {
            return {
                open: false,
                data: dataFromBackend.map(item => ({
                    nama: item.sub_judul,
                    anggaran: parseFloat(item.anggaran),
                    realisasi: parseFloat(item.realisasi)
                })),
                totalAnggaran: totalAnggaranFromBackend,
                totalRealisasi: totalRealisasiFromBackend,
                get persentase() {
                    return this.totalAnggaran > 0 ? (this.totalRealisasi / this.totalAnggaran) * 100 : 0;
                },
                formatRupiah(angka) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(angka);
                }
            }
        }
    </script>


</x-layout>
