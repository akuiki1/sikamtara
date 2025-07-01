<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <section class="" x-data="{
        search: '',
        tahun: '',
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        importAPBDes: false,
        selectedApbdes: null,
        apbdes: @js($apbdesJs),
        get filteredApbdes() {
            return this.apbdes.filter(item => {
                const matchesSearch = this.search === '' || item.tahun.toString().includes(this.search);
                const matchesTahun = this.tahun === '' || item.tahun.toString() === this.tahun;
                return matchesSearch && matchesTahun;
            });
        },
        formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        }
    }">
        {{-- search bar + filter + tambah tahun --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
            {{-- LEFT SECTION: Search, Filter, Clear --}}
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
                    <input type="text" name="search" placeholder="Cari tahun..." value="{{ request('search') }}"
                        class="pl-10 pr-24 py-2 w-full rounded-full border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                        @keydown.enter="$event.target.form.submit()">
                    <x-button type="submit"
                        class="absolute right-1 top-1 bottom-1 bg-indigo-400 hover:bg-indigo-600 text-white px-4 py-1 rounded-full text-sm">
                        Cari
                    </x-button>
                </form>

                {{-- TOMBOL CLEAR FILTER (hanya muncul kalau filter aktif) --}}
                @if (request()->has('search') || request()->has('role') || request()->has('status'))
                    <a href="{{ url()->current() }}"
                        class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-400 text-gray-600 rounded-full">
                        Tampilkan Semua
                    </a>
                @endif
            </div>

            {{-- RIGHT SECTION: Tambah tahun --}}
            <div>
                <x-button type="button" @click="importAPBDes = true" variant="primary">Import Excel</x-button>
                
                <x-button @click="selectedApbdes = null; showAddModal = true">
                    {{-- Plus Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Tambah Tahun</span>
                </x-button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white p-6 rounded-xl">
            <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-3 gap-4">
                <template x-if="filteredApbdes.length === 0">
                    <div class="col-span-full text-center text-gray-400 py-6 text-sm">
                        Tidak ada data APBDes ditemukan.
                    </div>
                </template>

                <template x-for="item in filteredApbdes" :key="item.id_tahun_anggaran">
                    <div @click="selectedApbdes = item; showDetailModal = true"
                        class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between h-full cursor-pointer hover:scale-105">
                        {{-- Tahun --}}
                        <div class="mb-4 text-center">
                            <div class="text-xs uppercase tracking-wide text-gray-400">Tahun Anggaran</div>
                            <div class="text-xl font-semibold text-gray-800" x-text="item.tahun"></div>
                        </div>

                        {{-- Ringkasan --}}
                        <div class="space-y-3">
                            <!-- Pendapatan -->
                            <div class="border rounded-lg px-4 py-2 flex flex-col justify-between h-[60px]">
                                <div class="text-[11px] text-gray-500">Pendapatan</div>
                                <div class="flex justify-between items-end">
                                    <div></div> <!-- spacer biar angka tetap di kanan -->
                                    <div class="text-sm font-semibold text-green-500"
                                        x-text="formatCurrency(item.total_pendapatan || 0)"></div>
                                </div>
                            </div>

                            <!-- Belanja -->
                            <div class="border rounded-lg px-4 py-2 flex flex-col justify-between h-[60px]">
                                <div class="text-[11px] text-gray-500">Belanja</div>
                                <div class="flex justify-between items-end">
                                    <div></div>
                                    <div class="text-sm font-semibold text-red-500"
                                        x-text="formatCurrency(item.total_belanja || 0)"></div>
                                </div>
                            </div>

                            <!-- Pembiayaan -->
                            <div class="border rounded-lg px-4 py-2 flex flex-col justify-between h-[60px]">
                                <div class="text-[11px] text-gray-500">Pembiayaan</div>
                                <div class="flex justify-between items-end">
                                    <div></div>
                                    <div class="text-sm font-semibold text-blue-500"
                                        x-text="formatCurrency(item.total_pembiayaan || 0)"></div>
                                </div>
                            </div>

                            <!-- Surplus / Defisit -->
                            <div class="border rounded-lg px-4 py-3 space-y-1 ">
                                <div class="flex justify-between items-center">
                                    <div class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                        </svg>
                                        Surplus / Defisit
                                    </div>
                                    <div class="text-[10px] font-medium px-2 py-0.5 rounded-full"
                                        :class="(item.total_pendapatan - item.total_belanja) >= 0
                                            ?
                                            'bg-emerald-100 text-emerald-700' :
                                            'bg-rose-100 text-rose-700'"
                                        x-text="(item.total_pendapatan - item.total_belanja) >= 0 ? '+ Surplus' : '– Defisit'">
                                    </div>
                                </div>
                                <div class="text-sm font-semibold"
                                    :class="(item.total_pendapatan - item.total_belanja) >= 0
                                        ?
                                        'text-emerald-500' :
                                        'text-rose-500'"
                                    x-text="formatCurrency((item.total_pendapatan || 0) - (item.total_belanja || 0))">
                                </div>
                                <div class="w-full h-1.5 rounded-full bg-gray-200 overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-300"
                                        :class="(item.total_pendapatan - item.total_belanja) >= 0
                                            ?
                                            'bg-emerald-400' :
                                            'bg-rose-400'"
                                        :style="`width: ${Math.min(100, Math.abs((item.total_pendapatan - item.total_belanja) / (item.total_pendapatan || 1)) * 100)}%`">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            {{-- pagination --}}
            <div class="mt-8">
                {{ $apbdes->links() }}
            </div>
        </div>

        <!-- Modal Detail -->
        <x-modal show="showDetailModal">
            <div class="space-y-6">
                {{-- Header --}}
                <div class="flex items-center justify-between mb-4 border-b pb-1">
                    <h2 class="text-base font-semibold text-gray-900 tracking-tight flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-6h13M4 6h16M4 10h16M4 14h10M4 18h10" />
                        </svg>
                        Ringkasan APBDes <span class="text-indigo-500" x-text="`Tahun ${selectedApbdes.tahun}`"></span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    {{-- Pendapatan --}}
                    <a :href="`/admin/apbdes/pendapatan?tahun=${selectedApbdes.tahun}`"
                        class="block bg-white border border-gray-200 rounded-lg p-2 shadow-sm hover:shadow transition hover:ring-1 hover:ring-green-400">
                        <div class="text-[11px] font-medium text-gray-500 mb-0.5">Pendapatan</div>
                        <div class="text-base font-semibold text-green-500 tracking-tight"
                            x-text="formatCurrency(selectedApbdes.total_pendapatan || 0)">
                        </div>
                    </a>

                    {{-- Belanja --}}
                    <a :href="`/admin/apbdes/belanja?tahun=${selectedApbdes.tahun}`"
                        class="block bg-white border border-gray-200 rounded-lg p-2 shadow-sm hover:shadow transition hover:ring-1 hover:ring-red-400">
                        <div class="text-[11px] font-medium text-gray-500 mb-0.5">Belanja</div>
                        <div class="text-base font-semibold text-red-500 tracking-tight"
                            x-text="formatCurrency(selectedApbdes.total_belanja || 0)">
                        </div>
                    </a>

                    {{-- Pembiayaan --}}
                    <a :href="`/admin/apbdes/pembiayaan?tahun=${selectedApbdes.tahun}`"
                        class="block bg-white border border-gray-200 rounded-lg p-2 shadow-sm hover:shadow transition hover:ring-1 hover:ring-blue-400">
                        <div class="text-[11px] font-medium text-gray-500 mb-0.5">Pembiayaan</div>
                        <div class="text-base font-semibold text-blue-500 tracking-tight"
                            x-text="formatCurrency(selectedApbdes.total_pembiayaan || 0)">
                        </div>
                    </a>

                    {{-- Surplus / Defisit --}}
                    <div
                        class="bg-white border border-gray-200 rounded-lg p-2 shadow-sm hover:shadow transition-all duration-200 space-y-1">
                        <div class="flex items-center justify-between">
                            <div class="text-[11px] font-medium text-gray-500 flex items-center gap-1">
                                <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                </svg>
                                Surplus / Defisit
                            </div>

                            <div class="text-[10px] px-1.5 py-0.5 rounded font-medium"
                                :class="((selectedApbdes.total_pendapatan || 0) - (selectedApbdes.total_belanja || 0)) >= 0
                                    ?
                                    'bg-emerald-100 text-emerald-700' :
                                    'bg-rose-100 text-rose-700'"
                                x-text="((selectedApbdes.total_pendapatan || 0) - (selectedApbdes.total_belanja || 0)) >= 0
                            ? '+ Surplus' : '– Defisit'">
                            </div>
                        </div>

                        <div class="text-base font-semibold tracking-tight"
                            :class="((selectedApbdes.total_pendapatan || 0) - (selectedApbdes.total_belanja || 0)) >= 0
                                ?
                                'text-emerald-500' :
                                'text-rose-500'"
                            x-text="formatCurrency((selectedApbdes.total_pendapatan || 0) - (selectedApbdes.total_belanja || 0))">
                        </div>

                        <div class="w-full bg-gray-100 h-1 rounded-full overflow-hidden">
                            <div class="h-full transition-all duration-300"
                                :class="((selectedApbdes.total_pendapatan || 0) - (selectedApbdes.total_belanja || 0)) >= 0
                                    ?
                                    'bg-emerald-400' :
                                    'bg-rose-400'"
                                :style="`width: ${Math.min(100, Math.abs(((selectedApbdes.total_pendapatan || 0) - (selectedApbdes.total_belanja || 0)) / (selectedApbdes.total_pendapatan || 1)) * 100)}%`">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-2 pt-6 mt-6 border-t border-gray-100 text-sm">
                <x-button type="button" @click="showDetailModal = false" variant="secondary">Tutup</x-button>
                <x-button type="button" @click="showDetailModal = false; showEditModal = true"
                    variant="primary">Edit</x-button>
                <x-button type="button" @click="showDetailModal = false; showDeleteModal = true"
                    variant="danger">Hapus</x-button>
            </div>
        </x-modal>

        {{-- modal import --}}
        <x-modal show="importAPBDes">
            <form method="POST" action="{{ route('import.apbdes') }}" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <div>
                    <label class="block mb-1 font-medium">Tahun Anggaran</label>
                    <input type="number" name="tahun" required class="border p-2 rounded w-full"
                        placeholder="Contoh: 2024">
                </div>

                <div>
                    <label class="block mb-1 font-medium">File Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                        class="border p-2 rounded w-full">
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Import APBDes
                </button>
            </form>
        </x-modal>

        {{-- modal tambah --}}
        <x-modal show="showAddModal" title="Tambah APBDes Baru">
            <form action="{{ route('adminapbdes.store') }}" method="POST">
                @csrf
                <div x-data="{ tahun: new Date().getFullYear() }" class="flex items-center gap-3 w-full">
                    <!-- Ikon Kalender -->
                    <svg class="w-6 h-6 text-gray-800 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                    </svg>

                    <!-- Input + Tombol Atas Bawah -->
                    <div class="relative w-full">
                        <input type="number" name="tahun" x-model="tahun" :placeholder="tahun" min="1900"
                            max="2099"
                            class="border w-full p-2 rounded-lg pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                            required>
                    </div>
                </div>

                {{-- button --}}
                <div class="mt-6 flex justify-end gap-2">
                    <x-button type="button" @click="{{ 'showAddModal' }} = false"
                        variant="secondary">Batal</x-button>
                    <x-button type="submit">Tambah</x-button>
                </div>
            </form>
        </x-modal>

        <!-- Modal Edit -->
        <x-modal show="showEditModal" title="Edit data APBDes">
            <form :action="`{{ url('/admin/apbdes/update') }}/${selectedApbdes.id_tahun_anggaran}`" method="POST">
                @csrf
                @method('PUT')
                <div class="flex items-center gap-3 w-full">
                    <!-- Ikon Kalender -->
                    <svg class="w-6 h-6 text-gray-800 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                    </svg>

                    <!-- Input + Tombol Atas Bawah -->
                    <div class="relative w-full">
                        <input type="number" name="tahun" x-model="selectedApbdes.tahun" :placeholder="tahun"
                            min="1900" max="2099"
                            class="border w-full p-2 rounded-lg pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                            required>
                    </div>
                </div>

                {{-- button --}}
                <div class="mt-6 flex justify-end gap-2">
                    <x-button type="button" @click="showEditModal = false; showDetailModal = true"
                        variant="secondary">Kembali</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- Modal Hapus --}}
        <div x-show="showDeleteModal" @click.away="showDeleteModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-xl shadow-2xl w-96 p-6 text-center">
                <h2 class="text-xl font-semibold mb-4 text-red-600">Hapus APBDes?</h2>
                <p class="mb-4">Apakah Anda yakin ingin menghapus data APBDes tahun <strong
                        x-text="selectedApbdes.tahun"></strong>?
                </p>

                <form :action="`{{ url('/admin/apbdes/delete') }}/${selectedApbdes.id_tahun_anggaran}`" method="POST"
                    x-ref="deleteForm">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-center gap-4">
                        <x-button type="button" @click="showDeleteModal = false; showDetailModal = true"
                            variant="secondary">Kembali</x-button>
                        <x-button variant="danger" type="submit">Hapus</x-button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-admin-layout>
