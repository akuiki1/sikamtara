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
                            <span
                                class="text-gray-500">[{{ ucfirst($item->statusTerakhir->status ?? 'Belum Ada Status') }}]</span>
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

    <section id="riwayatLayanan" class="md:col-span-4 bg-white p-5 rounded-2xl shadow mt-6" x-data="{
        search: '{{ request('search_riwayat') }}',
        filterStatus: '',
        showDetailModal: false,
        showEditModal: false,
        showDeleteModal: false,
        selectedPengajuanAdministrasi: null,
        pengajuanAdministrasi: @js($pengajuanAdministrasi),
        get filteredAdministrasi() {
            return this.pengajuanAdministrasi
                .filter(item => {
                    const nama = item?.nama_administrasi?.toLowerCase() || '';
                    const matchesSearch = nama.includes(this.search.toLowerCase());
                    const matchesStatus = this.filterStatus === '' || item?.status_pengajuan === this.filterStatus;
                    return matchesSearch && matchesStatus;
                })
                .sort((a, b) => new Date(b?.updated_at) - new Date(a?.updated_at));
        }
    }">
        {{-- container tabel Riwayat Layanan --}}
        <div class="">
            <h2 class="text-lg font-semibold mb-4">Layanan milik saya</h2>

            {{-- filter --}}
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
                <div class="flex flex-wrap items-center gap-2">

                    {{-- SEARCH FORM --}}
                    <form method="GET" class="relative w-full md:w-80">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            {{-- Search Icon --}}
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </span>
                        <input type="text" name="search_riwayat" placeholder="Cari Layanan..."
                            value="{{ request('search_riwayat') }}"
                            class="pl-10 pr-24 py-2 w-full rounded-full border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                            @keydown.enter="$event.target.form.submit()">
                        <x-button type="submit"
                            class="absolute right-1 top-1 bottom-1 bg-indigo-400 hover:bg-indigo-600 text-white px-4 py-1 rounded-full text-sm">
                            Cari
                        </x-button>
                    </form>

                    {{-- FILTER DROPDOWN --}}
                    @php
                        $filterAktif = collect([
                            'search_riwayat' => request('search_riwayat'),
                            'status_pengajuan' => request('status_pengajuan'),
                        ])
                            ->filter()
                            ->count();
                    @endphp

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" type="button"
                            class="relative flex items-center gap-2 px-4 py-2 rounded-full border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            aria-expanded="true" aria-haspopup="true">
                            <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                            </svg>
                            Filter
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>

                            @if ($filterAktif > 0)
                                <span
                                    class="absolute top-0 right-0 -mt-1 -mr-1 min-w-[1rem] h-auto px-1 text-xs bg-indigo-500 text-white font-bold rounded-full ring-2 ring-white flex items-center justify-center">
                                    {{ $filterAktif }}
                                </span>
                            @endif
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition.opacity.scale.origin.top.right
                            class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-10 z-50 p-4">
                            <form method="GET" class="space-y-4">
                                <input type="hidden" name="search_riwayat" value="{{ request('search_riwayat') }}">
                                <div>
                                    <label for="status_pengajuan"
                                        class="block text-sm font-medium text-gray-700">Status Pengajuan</label>
                                    <select id="status_pengajuan" name="status_pengajuan"
                                        class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Semua Status</option>
                                        <option value="baru"
                                            {{ request('status_pengajuan') == 'baru' ? 'selected' : '' }}>Baru</option>
                                        <option value="ditinjau"
                                            {{ request('status_pengajuan') == 'ditinjau' ? 'selected' : '' }}>Ditinjau
                                        </option>
                                        <option value="diproses"
                                            {{ request('status_pengajuan') == 'diproses' ? 'selected' : '' }}>Diproses
                                        </option>
                                        <option value="ditolak"
                                            {{ request('status_pengajuan') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                        </option>
                                        <option value="selesai"
                                            {{ request('status_pengajuan') == 'selesai' ? 'selected' : '' }}>Selesai
                                        </option>
                                    </select>
                                </div>
                                <x-button type="submit" class="w-full justify-center">Terapkan Filter</x-button>
                            </form>
                        </div>
                    </div>

                    @if (request()->has('search_riwayat') || request()->has('status_pengajuan'))
                        <a href="{{ url()->current() }}"
                            class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-400 text-gray-600 rounded-full">
                            Tampilkan Semua
                        </a>
                    @endif
                </div>
            </div>

            {{-- body --}}
            <div class="w-full h-80 relative">
                <x-table>
                    <x-slot name="head">
                        <tr>
                            <th class="px-4 py-3 text-center">Nama Layanan</th>
                            <th class="px-4 py-3 text-center">Di ajukan pada</th>
                            <th class="px-4 py-3 text-center">status terbaru</th>
                            <th class="px-4 py-3 text-center">di update pada</th>
                            <th class="px-4 py-3 text-center">aksi</th>
                        </tr>
                    </x-slot>
                    <x-slot name="body">
                        <tr x-show="filteredAdministrasi.length === 0">
                            <td colspan="5" class="text-center text-gray-500 py-6">Layanan Administrasi tidak
                                ditemukan.</td>
                        </tr>
                        <template x-for="item in filteredAdministrasi" :key="item.id_pengajuan_administrasi">
                            <tr class="even:bg-gray-50 hover:bg-gray-100">
                                <td class="px-4 py-3 text-gray-800 font-medium" x-text="item.nama_administrasi"></td>
                                <td class="px-4 py-3 text-gray-600 text-center" x-text="item.tanggal_pengajuan"></td>
                                <td class="px-4 py-3 text-gray-600 text-center" x-text="item.status_pengajuan"></td>
                                <td class="px-4 py-3 text-gray-600 text-center" x-text="item.updated_at"></td>
                                <td class="px-4 py-3 text-gray-600 text-center">
                                    <!-- Tombol aksi seperti Lihat / Edit -->
                                    <x-button @click="selectedPengajuanAdministrasi = item; showDetailModal = true"
                                        size="sm">Detail</x-button>
                                    <template x-if="item.status_pengajuan === 'baru'">
                                        <div>
                                            <x-button
                                                @click="selectedPengajuanAdministrasi = item; showEditModal = true"
                                                size="sm" variant="warning">Edit</x-button>
                                            <x-button
                                                @click="selectedPengajuanAdministrasi = item; showDeleteModal = true"
                                                size="sm" variant="danger">Hapus</x-button>
                                        </div>
                                    </template>
                                    <template x-if="item.status_pengajuan === 'ditolak'">
                                        <x-button @click="selectedPengajuanAdministrasi = item; showDeleteModal = true"
                                            size="sm" variant="danger">Hapus</x-button>
                                    </template>
                                    <template x-if="item.status_pengajuan === 'selesai' && item.surat_final">
                                        <a :href="`{{ route('surat.final.download', '') }}/${item.id_pengajuan_administrasi}`"
                                            target="_blank"
                                            class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out hover:scale-105 bg-green-400 hover:bg-green-500 text-white text-xs px-2 py-1 sm:px-3 sm:py-1.5 md:px-4 md:py-2">
                                            Unduh Surat Final
                                        </a>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </x-slot>
                </x-table>
            </div>
        </div>

        {{-- modal detail --}}
        <x-modal show="showDetailModal">
            <!-- Header -->

            <div class="mb-6 space-y-1">
                <h2 class="text-2xl font-bold text-gray-900">
                    Detail pengajuan <span x-text="selectedPengajuanAdministrasi.nama_administrasi"></span>
                </h2>
                <p class="text-sm text-gray-500">Lihat informasi lengkap dari pengajuan layanan administrasi anda.</p>
            </div>

            <!-- Konten Utama -->
            <div class="space-y-6">
                <!-- Tombol Unduh -->
                <div class="">
                    <a :href="'/storage/' + selectedPengajuanAdministrasi.form" download
                        class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out bg-indigo-400 hover:bg-indigo-600 text-white text-sm px-4 py-2 hover:scale-105">
                        <!-- Icon Download -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                        Unduh formulir&nbsp;<span x-text="selectedPengajuanAdministrasi.nama_administrasi"></span>
                    </a>
                </div>
                <!-- Deskripsi -->
                <div>
                    <h3 class="text-sm font-normal text-gray-500 mb-1">Diajukan pada
                        <span class="text-gray-800 font-semibold leading-relaxed"
                            x-text="selectedPengajuanAdministrasi.tanggal_pengajuan"></span>
                    </h3>

                    <h3 class="text-sm font-normal text-gray-500 mb-1">Terakhir diperbarui
                        <span class="text-gray-800 font-semibold leading-relaxed"
                            x-text="selectedPengajuanAdministrasi.updated_at"></span>
                    </h3>
                    <h3 class="text-sm font-normal text-gray-500 mb-1">Status Pengajuan
                        <span class="text-gray-800 font-semibold leading-relaxed"
                            x-text="selectedPengajuanAdministrasi.status_pengajuan">
                        </span>
                    </h3>
                </div>
            </div>
            <div class="my-4">
                <h2 class="mb-1 text-gray-700 ">Form yang dikirim</h2>
                <a :href="`{{ asset('storage') }}/${selectedPengajuanAdministrasi.form}`" target="_blank"
                    class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out bg-indigo-400 hover:bg-indigo-600 text-white text-sm px-4 py-2 hover:scale-105">
                    <!-- Icon Download -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                    &nbsp;<span x-text="selectedPengajuanAdministrasi.form_name"></span>
                </a>
            </div>
            <div class="">
                <h2 class="mb-1 text-gray-700 ">Lampiran yang dikirim</h2>
                <a :href="`{{ asset('storage') }}/${selectedPengajuanAdministrasi.lampiran}`" target="_blank"
                    class="inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out bg-indigo-400 hover:bg-indigo-600 text-white text-sm px-4 py-2 hover:scale-105">
                    <!-- Icon Download -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                    &nbsp;<span x-text="selectedPengajuanAdministrasi.lampiran_name"></span>
                </a>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                <x-button type="button" @click="showDetailModal = false" variant="secondary" size="md">
                    Tutup
                </x-button>
            </div>
        </x-modal>

        {{-- modal hapus --}}
        <x-modal show="showDeleteModal">
            <div class="mb-4">
                <h2 class="text-xl font-bold text-gray-900">
                    Hapus Pengajuan
                </h2>
                <p class="text-sm text-gray-500">
                    Apakah kamu yakin ingin menghapus layanan "<span
                        x-text="selectedPengajuanAdministrasi.nama_administrasi"></span>"?
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                <x-button type="button" @click="showDeleteModal = false" variant="secondary" size="md">
                    Batal
                </x-button>
                <form
                    x-bind:action="'{{ rtrim(route('admin.pengajuan.destroy', ''), '/') }}/' + selectedPengajuanAdministrasi
                        .id_pengajuan_administrasi"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="danger" size="md">Hapus</x-button>
                </form>
            </div>
        </x-modal>

        {{-- modal edit --}}
        <x-modal show="showEditModal">
            <form method="POST" x-data="fileValidationForm"
                x-bind:action="'{{ rtrim(route('admin.pengajuan.update', ''), '/') }}/' + selectedPengajuanAdministrasi
                    .id_pengajuan_administrasi"
                enctype="multipart/form-data" @submit.prevent="validateBeforeSubmit($el)">
                @csrf
                @method('PUT')

                <div class="mb-6 space-y-1">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Edit Pengajuan: <span x-text="selectedPengajuanAdministrasi.nama_administrasi"></span>
                    </h2>
                    <p class="text-sm text-gray-500">Perbarui formulir dan lampiran Anda jika diperlukan.</p>
                </div>

                <div class="space-y-6">
                    <!-- Formulir -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Formulir
                            <small class="block text-gray-400 text-xs">Format: PDF, DOC, DOCX. Maks 2MB.</small>
                        </label>
                        <input type="file" name="form" accept=".pdf,.doc,.docx"
                            @change="validateFile($event, 'form')"
                            class="mt-1 block w-full border rounded-md shadow-sm"
                            :class="!validForm ? 'border-red-500' : 'border-gray-300'" />
                        <template x-if="!validForm">
                            <p class="text-xs text-red-500 mt-1">File tidak valid atau melebihi 2MB.</p>
                        </template>
                        <p class="text-xs text-gray-400">File sebelumnya: <span
                                x-text="selectedPengajuanAdministrasi.form_name"></span></p>
                    </div>

                    <!-- Lampiran -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Lampiran
                            <small class="block text-gray-400 text-xs">Format: PDF, DOC, DOCX. Maks 2MB.</small>
                        </label>
                        <input type="file" name="lampiran" accept=".pdf,.doc,.docx"
                            @change="validateFile($event, 'lampiran')"
                            class="mt-1 block w-full border rounded-md shadow-sm"
                            :class="!validLampiran ? 'border-red-500' : 'border-gray-300'" />
                        <template x-if="!validLampiran">
                            <p class="text-xs text-red-500 mt-1">File tidak valid atau melebihi 2MB.</p>
                        </template>
                        <p class="text-xs text-gray-400">File sebelumnya: <span
                                x-text="selectedPengajuanAdministrasi.lampiran_name"></span></p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                    <x-button type="button" @click="showEditModal = false" variant="secondary"
                        size="md">Batal</x-button>
                    <x-button type="submit" variant="primary" size="md">Simpan Perubahan</x-button>
                </div>
            </form>
        </x-modal>
    </section>

    <script>
        function formatPersyaratan(textarea) {
            let lines = textarea.value.split('\n');
            let formatted = lines.map(line => {
                line = line.trimStart();
                if (line === '') return '';
                return line.startsWith('-') ? line : `- ${line}`;
            }).join('\n');
            textarea.value = formatted;
        }
    </script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('fileValidationForm', () => ({
                validForm: true,
                validLampiran: true,

                validateFile(event, type) {
                    const file = event.target.files[0];
                    const allowedTypes = [
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ];
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    const isValid = file ? allowedTypes.includes(file.type) && file.size <= maxSize :
                        true;

                    if (type === 'form') this.validForm = isValid;
                    if (type === 'lampiran') this.validLampiran = isValid;
                },

                validateBeforeSubmit(formElement) {
                    if (!this.validForm || !this.validLampiran) {
                        // Optional: Add toast here
                        return;
                    }
                    formElement.submit();
                }
            }));
        });
    </script>
</x-admin-layout>
