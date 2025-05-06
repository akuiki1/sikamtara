{{-- resources/views/penduduk/index.blade.php --}}
<x-layout>
    <section class="bg-gray-100 py-8">
        <div class="container mx-auto px-4" x-data="pendudukData()">
            <h1 class="text-2xl font-bold mb-2">Penduduk Desa Kambat Utara</h1>
            <p class="text-gray-600 mb-8">Statistik jumlah penduduk berdasarkan jenis kelamin dan usia.</p>

            {{-- Statistik Jumlah Penduduk --}}
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                @foreach ([
                    ['label' => 'Total Penduduk', 'value' => '1.653 Jiwa'],
                    ['label' => 'Kepala Keluarga', 'value' => '603 Jiwa'],
                    ['label' => 'Laki-laki', 'value' => '838 Jiwa'],
                    ['label' => 'Perempuan', 'value' => '815 Jiwa'],
                ] as $stat)
                    <div class="bg-white rounded-2xl shadow hover:shadow-lg transition-transform transform hover:-translate-y-1 p-4 flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full mb-4 flex items-center justify-center text-blue-500">
                            <i class="fas fa-users text-2xl"></i> {{-- Pakai FontAwesome kalau mau --}}
                        </div>
                        <h3 class="text-lg font-semibold">{{ $stat['label'] }}</h3>
                        <p class="text-gray-700">{{ $stat['value'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Berdasarkan Kelompok Umur --}}
            <div class="bg-white rounded-2xl shadow p-6 mb-12">
                <h2 class="text-xl font-semibold mb-6 text-center">Berdasarkan Kelompok Umur</h2>
                <div class="flex justify-center">
                    <canvas id="umurChart" class="w-full max-w-3xl"></canvas>
                </div>
                <div class="mt-4 text-sm text-gray-600 space-y-2">
                    <p>Untuk laki-laki, kelompok umur <span class="font-semibold">20-24</span> tertinggi: <span class="font-semibold">98 orang (15.43%)</span>.</p>
                    <p>Untuk perempuan, kelompok umur <span class="font-semibold">20-24</span> tertinggi: <span class="font-semibold">69 orang (9.91%)</span>.</p>
                </div>
            </div>

            {{-- Berdasarkan Kelompok Dusun --}}
            <div class="bg-white rounded-2xl shadow p-6 mb-12">
                <h2 class="text-xl font-semibold mb-6 text-center">Berdasarkan Kelompok Dusun</h2>
                <div class="flex justify-center">
                    <canvas id="dusunChart" class="w-full max-w-md"></canvas>
                </div>
            </div>

            {{-- Berdasarkan Pendidikan --}}
            <div class="bg-white rounded-2xl shadow p-6 mb-12">
                <h2 class="text-xl font-semibold mb-6 text-center">Berdasarkan Pendidikan</h2>
                <div class="flex justify-center">
                    <canvas id="pendidikanChart" class="w-full max-w-3xl"></canvas>
                </div>
            </div>

            {{-- Berdasarkan Pekerjaan --}}
            <div class="bg-white rounded-2xl shadow p-6 mb-12">
                <h2 class="text-xl font-semibold mb-6 text-center">Berdasarkan Pekerjaan</h2>
                <div class="flex justify-center">
                    <canvas id="pekerjaanChart" class="w-full max-w-3xl"></canvas>
                </div>
            </div>

            {{-- Berdasarkan Perkawinan --}}
            <div class="bg-white rounded-2xl shadow p-6 mb-12">
                <h2 class="text-xl font-semibold mb-6 text-center">Berdasarkan Perkawinan</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6 text-center">
                    @foreach ([
                        ['status' => 'Belum Kawin', 'jumlah' => 1308],
                        ['status' => 'Kawin', 'jumlah' => 20],
                        ['status' => 'Cerai Mati', 'jumlah' => 1],
                        ['status' => 'Cerai Hidup', 'jumlah' => 0],
                        ['status' => 'Kawin Tercatat', 'jumlah' => 0],
                        ['status' => 'Kawin Tidak Tercatat', 'jumlah' => 0],
                    ] as $marital)
                        <div class="flex flex-col items-center p-4 bg-gray-100 rounded-lg hover:shadow-lg transition-transform transform hover:-translate-y-1">
                            <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-heart text-green-500"></i>
                            </div>
                            <h3 class="font-bold">{{ $marital['jumlah'] }}</h3>
                            <p class="text-gray-600 text-sm">{{ $marital['status'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Berdasarkan Agama --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-xl font-semibold mb-6 text-center">Berdasarkan Agama</h2>
                <div class="flex justify-center">
                    <canvas id="agamaChart" class="w-full max-w-3xl"></canvas>
                </div>
            </div>
        </div>
    </section>

    {{-- Script Chart.js & Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script>
        function pendudukData() {
            return {
                init() {
                    const umurChart = new Chart(document.getElementById('umurChart'), {
                        type: 'bar',
                        data: {
                            labels: ['0-4', '5-9', '10-14', '15-19', '20-24', '25-29'],
                            datasets: [
                                {
                                    label: 'Laki-laki',
                                    backgroundColor: '#3b82f6',
                                    data: [4, 8, 12, 76, 98, 52],
                                },
                                {
                                    label: 'Perempuan',
                                    backgroundColor: '#ec4899',
                                    data: [1, 7, 10, 59, 69, 44],
                                }
                            ]
                        },
                        options: { responsive: true, maintainAspectRatio: false }
                    });

                    const dusunChart = new Chart(document.getElementById('dusunChart'), {
                        type: 'pie',
                        data: {
                            labels: ['Betumukti', 'Nilipo'],
                            datasets: [{
                                backgroundColor: ['#34d399', '#60a5fa'],
                                data: [1062, 267]
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false }
                    });

                    const pendidikanChart = new Chart(document.getElementById('pendidikanChart'), {
                        type: 'bar',
                        data: {
                            labels: ['Tidak sekolah', 'SD', 'SMP', 'SMA', 'Perguruan Tinggi'],
                            datasets: [{
                                backgroundColor: '#facc15',
                                data: [20, 400, 350, 300, 50]
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false }
                    });

                    const pekerjaanChart = new Chart(document.getElementById('pekerjaanChart'), {
                        type: 'horizontalBar',
                        data: {
                            labels: ['Petani', 'Ibu Rumah Tangga', 'Pelajar', 'Tidak Bekerja', 'Pembantu', 'Guru'],
                            datasets: [{
                                backgroundColor: '#818cf8',
                                data: [404, 378, 336, 117, 71, 8]
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false }
                    });

                    const agamaChart = new Chart(document.getElementById('agamaChart'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Kristen', 'Katolik', 'Kepercayaan', 'Budha', 'Konghucu', 'Islam', 'Hindu'],
                            datasets: [{
                                backgroundColor: ['#f87171', '#fbbf24', '#34d399', '#60a5fa', '#a78bfa', '#f472b6', '#c084fc'],
                                data: [1298, 21, 10, 0, 0, 0, 0]
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false }
                    });
                }
            }
        }
    </script>
</x-layout>
