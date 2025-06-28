<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-9 px-6 text-center">
    </section>

    <section class="bg-gray-100 py-8">
        <div class="container mx-auto px-4" x-data="pendudukData()">

            {{-- header --}}
            <div class="bg-white p-6 rounded-xl mb-4 shadow-md">
                <h1 class="text-2xl font-bold">Penduduk Desa Kambat Utara</h1>
                <p class="text-gray-600">Statistik jumlah penduduk berdasarkan jenis kelamin dan usia.</p>
            </div>

            {{-- Statistik Jumlah Penduduk --}}
            <div
                class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-4 bg-white rounded-xl p-4 sm:p-6 shadow-md">

                {{-- Total Penduduk --}}
                <div class="border shadow rounded-xl p-4 sm:p-6 text-center">
                    <div class="w-12 sm:w-16 h-12 sm:h-16 mx-auto">
                        <svg class="w-full h-full text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Total Penduduk</h3>
                    <p class="text-sm text-gray-500">{{ number_format($total) }} Jiwa</p>
                </div>

                {{-- Total Keluarga --}}
                <div class="border shadow rounded-xl p-4 sm:p-6 text-center">
                    <div class="w-12 sm:w-16 h-12 sm:h-16 mx-auto">
                        <svg class="w-full h-full text-emerald-600" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Total Keluarga</h3>
                    <p class="text-sm text-gray-500">{{ number_format($keluarga) }} Keluarga</p>
                </div>

                {{-- Laki-laki --}}
                <div class="border shadow rounded-xl p-4 sm:p-6 text-center">
                    <div class="w-12 sm:w-16 h-12 sm:h-16 mx-auto">
                        <svg class="w-full h-full text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Laki-laki</h3>
                    <p class="text-sm text-gray-500">{{ number_format($laki) }} Jiwa</p>
                </div>

                {{-- Perempuan --}}
                <div class="border shadow rounded-xl p-4 sm:p-6 text-center">
                    <div class="w-12 sm:w-16 h-12 sm:h-16 mx-auto">
                        <svg class="w-full h-full text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Perempuan</h3>
                    <p class="text-sm text-gray-500">{{ number_format($perempuan) }} Jiwa</p>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                {{-- Kelompok Umur --}}
                <div class="bg-white rounded-xl shadow-md p-4 space-y-4">
                    <h2 class="text-sm sm:text-base font-semibold text-center">Kelompok Umur</h2>

                    <div class="h-56">
                        <canvas id="umurChart" class="w-full h-full"></canvas>
                    </div>

                    <div class="text-xs sm:text-sm text-gray-600 grid grid-cols-2 gap-2 text-center px-2">
                        <div>
                            <span class="font-medium text-blue-600">Laki-laki:</span>
                            Umur <span class="font-semibold">{{ $tertinggi['L']['label'] }}</span>,
                            <span class="font-semibold">{{ $tertinggi['L']['jumlah'] }} org</span>
                            ({{ $tertinggi['L']['persentase'] }}%)
                        </div>
                        <div>
                            <span class="font-medium text-pink-600">Perempuan:</span>
                            Umur <span class="font-semibold">{{ $tertinggi['P']['label'] }}</span>,
                            <span class="font-semibold">{{ $tertinggi['P']['jumlah'] }} org</span>
                            ({{ $tertinggi['P']['persentase'] }}%)
                        </div>
                    </div>
                </div>

                {{-- Berdasarkan Pendidikan --}}
                <div class="bg-white rounded-xl shadow-md p-4 space-y-4">
                    <h2 class="text-sm sm:text-base font-semibold text-center">Pendidikan</h2>

                    <div class="h-64">
                        <canvas id="pendidikanChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                {{-- Berdasarkan Pekerjaan --}}
                <div class="bg-white rounded-xl shadow-md p-4 space-y-4">
                    <h2 class="text-sm sm:text-base font-semibold text-center">Pekerjaan</h2>

                    <div class="h-64">
                        <canvas id="pekerjaanChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                {{-- Berdasarkan Perkawinan --}}
                <div class="bg-white rounded-xl shadow-md p-4 space-y-4">
                    <h2 class="text-sm sm:text-base font-semibold text-center">Status Perkawinan</h2>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-center text-xs sm:text-sm px-2">
                        @foreach ([['status' => 'Belum Kawin', 'jumlah' => 1308], ['status' => 'Kawin', 'jumlah' => 20], ['status' => 'Cerai Mati', 'jumlah' => 1], ['status' => 'Cerai Hidup', 'jumlah' => 0], ['status' => 'Kawin Tercatat', 'jumlah' => 0], ['status' => 'Kawin Tidak Tercatat', 'jumlah' => 0]] as $marital)
                            <div
                                class="flex flex-col items-center p-3 bg-gray-100 rounded-lg hover:shadow transition-transform transform hover:-translate-y-0.5">
                                <div class="w-9 h-9 bg-green-100 rounded-full flex items-center justify-center mb-1">
                                    <i class="fas fa-heart text-green-500 text-sm"></i>
                                </div>
                                <h3 class="font-bold">{{ $marital['jumlah'] }}</h3>
                                <p class="text-gray-600 text-[10px] sm:text-xs">{{ $marital['status'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            {{-- Berdasarkan Agama --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Chart Agama --}}
                <div class="bg-white rounded-xl shadow-md p-4 space-y-4">
                    <h2 class="text-base sm:text-lg font-semibold text-center">Agama</h2>

                    <div class="grid md:grid-cols-2 gap-6 items-center">
                        {{-- CHART --}}
                        <div class="flex justify-center">
                            <div class="h-52 w-52">
                                <canvas id="agamaChart" class="w-full h-full"></canvas>
                            </div>
                        </div>

                        {{-- DETAIL KARTU --}}
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @php
                                $colors = [
                                    'Islam' => '#34d399',
                                    'Protestan' => '#fbbf24',
                                    'Katolik' => '#fbbf24',
                                    'Hindu' => '#f87171',
                                    'Budha' => '#60a5fa',
                                    'Konghucu' => '#a78bfa',
                                    'Lainnya' => '#a78bfa',
                                ];
                            @endphp
                            @foreach ($agamaData as $agama => $jumlah)
                                @php
                                    $persen = $totalAgama > 0 ? round(($jumlah / $totalAgama) * 100, 2) : 0;
                                    $bgColor = $colors[$agama] ?? '#e5e7eb';
                                @endphp
                                <div class="rounded-xl p-4 shadow-md text-center border"
                                    style="background-color: {{ $bgColor }}20"> {{-- transparansi warna --}}
                                    <p class="text-xs text-gray-600">{{ $agama }}</p>
                                    <p class="text-lg font-bold text-gray-800">{{ $jumlah }} orang</p>
                                    <p class="text-xs text-gray-500">{{ $persen }}%</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                {{-- Detail Agama --}}
                <div class="bg-white rounded-xl shadow-md p-4 space-y-3">
                    <h2 class="text-sm sm:text-base font-semibold text-center">Golongan Darah</h2>


                </div>
            </div>
        </div>
    </section>

    {{-- Script Chart.js & Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script>
        const umurLabels = {!! json_encode(array_keys($umurData['L'])) !!};
        const dataL = {!! json_encode(array_values($umurData['L'])) !!};
        const dataP = {!! json_encode(array_values($umurData['P'])) !!};
        const agamaLabels = {!! json_encode(array_keys($agamaData)) !!};
        const agamaValues = {!! json_encode(array_values($agamaData)) !!};

        function pendudukData() {
            return {
                init() {
                    // UMUR CHART (Dapatkan data dari Blade jika ingin dinamis)
                    const umurChart = new Chart(document.getElementById('umurChart'), {
                        type: 'bar',
                        data: {
                            labels: umurLabels,
                            datasets: [{
                                    label: 'Laki-laki',
                                    backgroundColor: '#3b82f6',
                                    data: dataL,
                                    borderRadius: 6
                                },
                                {
                                    label: 'Perempuan',
                                    backgroundColor: '#ec4899',
                                    data: dataP,
                                    borderRadius: 6
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // PENDIDIKAN CHART
                    const pendidikanChart = new Chart(document.getElementById('pendidikanChart'), {
                        type: 'bar',
                        data: {
                            labels: ['Tidak sekolah', 'SD', 'SMP', 'SMA', 'Perguruan Tinggi'],
                            datasets: [{
                                backgroundColor: '#facc15',
                                data: [20, 400, 350, 300, 50],
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // PEKERJAAN CHART (Ganti horizontalBar -> bar + indexAxis: 'y')
                    const pekerjaanChart = new Chart(document.getElementById('pekerjaanChart'), {
                        type: 'bar',
                        data: {
                            labels: ['Petani', 'Ibu Rumah Tangga', 'Pelajar', 'Tidak Bekerja', 'Pembantu', 'Guru'],
                            datasets: [{
                                backgroundColor: '#818cf8',
                                data: [404, 378, 336, 117, 71, 8],
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            indexAxis: 'y',
                            scales: {
                                x: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // AGAMA CHART
                    const agamaChart = new Chart(document.getElementById('agamaChart'), {
                        type: 'doughnut',
                        data: {
                            labels: agamaLabels,
                            datasets: [{
                                backgroundColor: ['#f87171', '#fbbf24', '#34d399', '#60a5fa', '#a78bfa',
                                    '#f472b6', '#c084fc'
                                ],
                                data: agamaValues
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                }
            }
        }
    </script>

</x-layout>
