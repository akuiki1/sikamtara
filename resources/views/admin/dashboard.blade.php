<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>
    <x-admin-nav-link />

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
        <!-- Card 1: Statistik Penduduk -->
        <div class="md:col-span-1 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-lg font-semibold">Statistik Penduduk</h2>
            <div class="w-60 h-60 relative items-center">
                <canvas id="pieChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>

        {{-- Card 2: keuangan dari tahun ke tahun --}}
        <div class="md:col-span-3 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-lg font-semibold mb-4">Anggaran vs Realisasi Keuangan</h2>
            <div class="w-full h-80 relative">
                <canvas id="keuanganChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>
        
        <!-- Card 1: full width -->
        {{-- <div class="md:col-span-4 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-lg font-semibold">Statistik Penduduk</h2>
            <div class="w-60 h-60 relative">
                <canvas id="pieChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div> --}}


        <!-- Card 2 & 3: 1/2 lebar -->
        <div class="md:col-span-2 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-sm font-medium text-gray-600">Permohonan Terbaru</h2>
            <p class="text-xl font-bold text-gray-800">128</p>
        </div>

        <div class="md:col-span-2 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-sm font-medium text-gray-600">Akun Warga Aktif</h2>
            <p class="text-xl font-bold text-green-600">642</p>
        </div>

        <!-- Card 4: 1 kolom -->
        <div class="md:col-span-1 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-sm font-medium text-gray-600">Pengaduan Masuk</h2>
            <p class="text-xl font-bold text-orange-600">5</p>
        </div>

        <!-- Card 5: 3 kolom -->
        <div class="md:col-span-3 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-sm font-medium text-gray-600">Agenda Desa</h2>
            <ul class="mt-2 space-y-1 text-sm text-gray-700">
                <li>📌 Rapat RT - 10 Mei</li>
                <li>📌 Gotong Royong - 12 Mei</li>
            </ul>
        </div>
    </div>


    {{-- 📈 Script pie Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('pieChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    label: 'Penduduk',
                    data: [1200, 1141],
                    backgroundColor: ['#60A5FA', '#F472B6'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

    {{-- script bar keuangan --}}
    <script>
        const ctx = document.getElementById('keuanganChart').getContext('2d');
    
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['2021', '2022', '2023', '2024'],
                datasets: [
                    {
                        label: 'Anggaran',
                        data: [800, 950, 1000, 1200],
                        backgroundColor: '#60A5FA' // biru
                    },
                    {
                        label: 'Realisasi',
                        data: [750, 900, 980, 1100],
                        backgroundColor: '#34D399' // hijau
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah (juta)'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' juta';
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-admin-layout>
