<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <section class="p-6 md:col-span-4 bg-white rounded-2xl shadow mt-4" x-data="{
        search: '',
        tahun: '',
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 rounded-xl">
            <template x-if="filteredApbdes.length === 0">
                <div class="col-span-full text-center text-gray-500 py-6">
                    Tidak ada data APBDes ditemukan.
                </div>
            </template>

            <template x-for="item in filteredApbdes" :key="item.id_tahun_anggaran">
                <div @click="selectedApbdes = item; showDetailModal = true"
                    class="cursor-pointer hover:scale-105 bg-white rounded-2xl hover:shadow-lg transition-all border border-black/10 p-6 flex flex-col justify-between h-full">
                    <div class="text-center text-lg font-semibold text-gray-800">
                        APBDes Tahun <span x-text="item.tahun"></span>
                    </div>
                </div>
            </template>
        </div>


        {{-- pagination --}}
        <div class="mt-4">
            {{ $apbdes->links() }}
        </div>


        <!-- Modal Detail -->
        <x-modal show="showDetailModal" title="Detail APBDes">
            {{-- isi --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Ringkasan APBDes Tahun <span
                        x-text="selectedApbdes.tahun"></span></h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-100 rounded-xl p-4">
                        <div class="text-sm text-gray-500">Total Pendapatan</div>
                        <div class="text-xl font-bold text-green-600"
                            x-text="formatCurrency(selectedApbdes.total_pendapatan || 0)"></div>
                    </div>
                    <div class="bg-gray-100 rounded-xl p-4">
                        <div class="text-sm text-gray-500">Total Belanja</div>
                        <div class="text-xl font-bold text-red-600"
                            x-text="formatCurrency(selectedApbdes.total_belanja || 0)"></div>
                    </div>
                    <div class="bg-gray-100 rounded-xl p-4">
                        <div class="text-sm text-gray-500">Total Pembiayaan</div>
                        <div class="text-xl font-bold text-blue-600"
                            x-text="formatCurrency(selectedApbdes.total_pembiayaan || 0)"></div>
                    </div>
                    <div class="bg-gray-100 rounded-xl p-4">
                        <div class="text-sm text-gray-500">Surplus / Defisit</div>
                        <div class="text-xl font-bold text-indigo-600"
                            x-text="formatCurrency((selectedApbdes.total_pendapatan || 0) - (selectedApbdes.total_belanja || 0))">
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 pt-4">
                    <a :href="`/admin/apbdes/${selectedApbdes.id_tahun_anggaran}/pendapatan`"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Pendapatan</a>
                    <a :href="`/admin/apbdes/${selectedApbdes.id_tahun_anggaran}/belanja`"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Belanja</a>
                    <a :href="`/admin/apbdes/${selectedApbdes.id_tahun_anggaran}/pembiayaan`"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Pembiayaan</a>
                </div>
            </div>


            {{-- button --}}
            <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                <x-button type="button" @click="showDetailModal = false" variant="secondary">Tutup</x-button>
                <x-button type="button" @click="showDetailModal = false; showEditModal = true"
                    variant="primary">Edit</x-button>
                <x-button type="button" @click="showDetailModal = false; showDeleteModal = true"
                    variant="danger">Hapus</x-button>
            </div>
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
            <form :action="`{{ url('/admin/apbdes/update') }}/${selectedApbdes.id_apbdes}`" method="POST">
                @csrf
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
                    <x-button type="submit">Tambah</x-button>
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

                <form :action="`{{ url('/admin/apbdes/delete') }}/${selectedApbdes.id_apbdes}`" method="POST"
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

        {{-- modal status --}}
        <div x-data="{ showSuccess: {{ session('success') ? 'true' : 'false' }}, showError: {{ session('error') ? 'true' : 'false' }} }" x-init="setTimeout(() => {
            showSuccess = false;
            showError = false
        }, 3000)" class="fixed top-5 right-5 z-50 space-y-2">

            <!-- Berhasil -->
            <div x-show="showSuccess" x-transition
                class="flex items-center gap-3 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>

            <!-- Gagal -->
            <div x-show="showError" x-transition
                class="flex items-center gap-3 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    </section>
    <section>
        🔘 Detail Tahun Anggaran (ketika tahun diklik)

        Ringkasan: Total Pendapatan, Belanja, Pembiayaan, Surplus/Defisit

    </section>
    <div>
        Akses ke sub halaman:
        Pendapatan
        Belanja
        Pembiayaan
    </div>
</x-admin-layout>
