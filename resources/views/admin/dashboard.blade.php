<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    {{-- stat card --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <x-stat-card label="Jumlah Penduduk" :value="$jumlahPenduduk" color="text-indigo-600">
            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                class='lucide lucide-users'>
                <path d='M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2' />
                <path d='M16 3.128a4 4 0 0 1 0 7.744' />
                <path d='M22 21v-2a4 4 0 0 0-3-3.87' />
                <circle cx='9' cy='7' r='4' />
            </svg>
        </x-stat-card>

        <x-stat-card label="Akun Terverifikasi" :value="$akunTerverifikasi" color="text-green-600">
            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                class='lucide lucide-badge-check'>
                <path
                    d='M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z' />
                <path d='m9 12 2 2 4-4' />
            </svg>
        </x-stat-card>

        <x-stat-card label="Layanan Masuk" :value="$layananMenunggu" color="text-yellow-600">
            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                class='lucide lucide-file-clock'>
                <path d='M16 22h2a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3' />
                <path d='M14 2v4a2 2 0 0 0 2 2h4' />
                <circle cx='8' cy='16' r='6' />
                <path d='M9.5 17.5 8 16.25V14' />
            </svg>
        </x-stat-card>

        <x-stat-card label="Pengaduan Masuk" :value="$pengaduanMasuk" color="text-orange-600">
            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                class='lucide lucide-message-circle-warning'>
                <path d='M7.9 20A9 9 0 1 0 4 16.1L2 22Z' />
                <path d='M12 8v4' />
                <path d='M12 16h.01' />
            </svg>
        </x-stat-card>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6 items-start">

        {{-- Statistik Penduduk --}}
        <div class="bg-white p-5 rounded-2xl shadow md:col-span-1" x-data="{
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
                            legend: { display: false }
                        }
                    }
                });
            }
        }" x-init="renderChart">
            <h2 class="text-lg font-semibold mb-4 text-center">Statistik Penduduk</h2>

            <div class="mx-auto w-40 aspect-square">
                <canvas id="pieChart" class="w-full h-full"></canvas>
            </div>

            <div class="mt-4 text-sm text-gray-600 space-y-2 text-center">
                <div class="flex items-center justify-center gap-2">
                    <span class="w-3 h-3 bg-blue-500 rounded-sm"></span>
                    <span>Laki-laki: <strong class="text-gray-800">{{ $statistik_penduduk['laki'] }}</strong></span>
                </div>
                <div class="flex items-center justify-center gap-2">
                    <span class="w-3 h-3 bg-pink-400 rounded-sm"></span>
                    <span>Perempuan: <strong
                            class="text-gray-800">{{ $statistik_penduduk['perempuan'] }}</strong></span>
                </div>
            </div>
        </div>

        {{-- Aktivitas --}}
        <div class="bg-white p-5 rounded-2xl shadow md:col-span-3">
            <h2 class="text-lg font-semibold mb-4">Aktivitas</h2>
            <div class="space-y-3 text-sm text-gray-700 max-h-[350px] overflow-y-auto pr-1">
                @forelse($aktivitas as $item)
                    <div class="border-b pb-2 last:border-0 last:pb-0">
                        @if ($item instanceof \App\Models\PengajuanAdministrasi)
                            Pengajuan administrasi oleh {{ $item->user->penduduk->nama ?? 'Warga' }}
                            <span class="text-gray-500">[{{ ucfirst($item->status_pengajuan) }}]</span>
                            · <a href="{{ route('adminadministrasi.index') . '#pengajuanMasuk' }}"
                                class="text-indigo-600 hover:underline">Lihat detail</a>
                        @elseif ($item instanceof \App\Models\Pengaduan)
                            Pengaduan dari {{ $item->user->penduduk->nama ?? 'Warga' }}
                            <span class="text-gray-500">[{{ ucfirst($item->statusTerakhir->status ?? 'Belum Ada Status') }}]</span>
                            · <a href="{{ route('admin.pengaduan.index') . '#pengajuanMasuk' }}"
                                class="text-indigo-600 hover:underline">Lihat detail</a>
                        @endif
                        <div class="text-xs text-gray-400">
                            {{ $item->created_at->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada aktivitas terbaru.</p>
                @endforelse
                <div class="pt-4">
                    {{ $aktivitas->links() }}
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
