<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    {{-- stat card --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <x-stat-card label="Jumlah Penduduk" value="2.341" color="text-indigo-600">
            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                class='lucide lucide-users'>
                <path d='M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2' />
                <path d='M16 3.128a4 4 0 0 1 0 7.744' />
                <path d='M22 21v-2a4 4 0 0 0-3-3.87' />
                <circle cx='9' cy='7' r='4' />
            </svg>
        </x-stat-card>

        <x-stat-card label="Akun Warga Terverifikasi" value="642" color="text-green-600">
            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                class='lucide lucide-badge-check'>
                <path
                    d='M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z' />
                <path d='m9 12 2 2 4-4' />
            </svg>
        </x-stat-card>

        <x-stat-card label="Layanan Menunggu Konfirmasi" value="128" color="text-yellow-600">
            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                class='lucide lucide-file-clock'>
                <path d='M16 22h2a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3' />
                <path d='M14 2v4a2 2 0 0 0 2 2h4' />
                <circle cx='8' cy='16' r='6' />
                <path d='M9.5 17.5 8 16.25V14' />
            </svg>
        </x-stat-card>

        <x-stat-card label="Pengaduan Masuk" value="5 Pengaduan" color="text-orange-600">
            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                class='lucide lucide-message-circle-warning'>
                <path d='M7.9 20A9 9 0 1 0 4 16.1L2 22Z' />
                <path d='M12 8v4' />
                <path d='M12 16h.01' />
            </svg>
        </x-stat-card>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">

        <!-- Card 1: Statistik Penduduk -->
        <div class="md:col-span-1 bg-white p-5 rounded-2xl shadow" x-data="{
            chart: null,
            data: {{ json_encode($statistik_penduduk) }},
            renderChart() {
                const ctx = document.getElementById('pieChart').getContext('2d');
                this.chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Laki-laki', 'Perempuan'],
                        datasets: [{
                            data: [this.data.laki, this.data.perempuan],
                            backgroundColor: ['#3b82f6', '#f472b6'],
                            borderWidth: 1,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: false,
                        }
                    }
                });
            }
        }" x-init="renderChart">
            <h2 class="text-lg font-semibold mb-4">Statistik Penduduk</h2>

            <div class="w-full max-w-xs mx-auto">
                <canvas id="pieChart" class="!w-full !h-auto aspect-square"></canvas>
            </div>

            <div class="text-sm text-gray-600 space-y-1 mt-4 text-center">
                <div class="flex items-center justify-center gap-2">
                    <span class="inline-block w-3 h-3 rounded-sm bg-blue-500"></span>
                    <span>Laki-laki: <span
                            class="font-semibold text-gray-800">{{ $statistik_penduduk['laki'] }}</span></span>
                </div>
                <div class="flex items-center justify-center gap-2">
                    <span class="inline-block w-3 h-3 rounded-sm bg-pink-400"></span>
                    <span>Perempuan: <span
                            class="font-semibold text-gray-800">{{ $statistik_penduduk['perempuan'] }}</span></span>
                </div>
            </div>

        </div>



        {{-- Card 2: keuangan dari tahun ke tahun --}}
        <div class="md:col-span-3 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-lg font-semibold mb-4">Aktivitas</h2>
            <div class="w-full h-80 relative">
                {{-- segala macam bentuk notifikasi --}}
            </div>
        </div>

        <!-- Card 1: full width -->
        <div class="md:col-span-4 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-lg font-semibold">Statistik Penduduk</h2>
            <div class="w-full h-80 relative">
                <canvas id="keuanganChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>


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

    {{-- script bar keuangan --}}
    <script>
        const ctx = document.getElementById('keuanganChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['2021', '2022', '2023', '2024'],
                datasets: [{
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
