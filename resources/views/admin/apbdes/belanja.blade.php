<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>
    3. Belanja
    Menampilkan struktur hierarkis:

    Bidang → Sub Bidang → Rincian
    <section>

        Isi:

        Pilih Tahun terlebih dahulu

        Accordion atau expandable list:

        Bidang (Sub Kategori) → tampilkan total

        Rincian Anggaran:

        Nama Rincian

        Anggaran, Realisasi, Selisih

        Tombol Edit / Hapus
    </section>

    <section class="md:col-span-4" x-data="{
        tahunAktif: '{{ strval($tahunAktif) }}',
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        selectedPendapatan: null,
        tahunList: @js($tahunListJs),
        pendapatan: @js($pendapatanJs),
        get filteredPendapatan() {
            return this.pendapatan.filter(item => {
                return this.tahunAktif === '' || item.tahun.toString() === this.tahunAktif.toString();
            });
        },
    
        handleTahunChange() {
            const selected = this.tahunList.find(t => t.tahun == this.tahunAktif);
            if (selected) {
                window.location.href = `/admin/apbdes/pendapatan/${selected.id}`;
            }
        },
    
        formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        }
    }">
        {{-- filter + tambah pendapatan --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
            {{-- LEFT SECTION: Filter tahun --}}
            <div class="flex items-center gap-3">
                <!-- Dropdown dengan ikon & panah berputar -->
                <div x-data="{
                    open: false,
                    selected: tahunAktif,
                    items: tahunList,
                    select(value) {
                        this.selected = value;
                        tahunAktif = value;
                        handleTahunChange();
                        this.open = false;
                    }
                }" class="relative w-64">
                    <!-- Input dengan ikon filter di kiri -->
                    <div
                        class="flex items-center bg-white border border-gray-300 rounded-xl shadow-sm px-3 py-2 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200 ease-in-out">
                        <!-- Ikon filter -->
                        <div class="mr-2 text-gray-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                            </svg>
                        </div>

                        <!-- Tombol dropdown -->
                        <button id="tahunFilter" @click="open = !open" type="button"
                            class="flex-1 text-left text-sm text-gray-800 pr-6 focus:outline-none">
                            <span x-text="selected || 'Pilih Tahun'"></span>

                            <!-- Panah dropdown -->
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none transition-transform duration-300 ease-in-out"
                                :class="open ? 'rotate-0' : 'rotate-180'">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                    </div>

                    <!-- Dropdown menu -->
                    <div x-show="open" x-transition @click.outside="open = false"
                        class="absolute mt-2 left-0 w-full z-20 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden ring-1 ring-black ring-opacity-5 max-h-60 overflow-y-auto">
                        <template x-for="item in items" :key="item.id">
                            <div @click="select(item.tahun)"
                                class="px-4 py-2 text-sm cursor-pointer transition duration-150 ease-in-out"
                                :class="selected === item.tahun ?
                                    'text-indigo-400 font-semibold' :
                                    'text-gray-700 hover:bg-gray-100'">
                                <span x-text="item.tahun"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>


            {{-- RIGHT SECTION: Tambah tahun --}}
            <div>
                <x-button @click="selectedApbdes = null; showAddModal = true">
                    {{-- Plus Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Tambah Pendapatan</span>
                </x-button>
            </div>
        </div>
        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="p-2">Nama Rincian</th>
                    <th>Anggaran</th>
                    <th>Realisasi</th>
                    <th>Selisih</th>
                    <th>Aksi</th>
                </tr>
            </x-slot>

            <x-slot name="body">
                <template x-if="filteredPendapatan.length === 0">
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 italic p-6">
                            Data pendapatan kosong
                        </td>
                    </tr>
                </template>

                <template x-for="item in filteredPendapatan" :key="item.id">
                    <tr>
                        <td x-text="item.nama"></td>
                        <td x-text="formatCurrency(item.anggaran)"></td>
                        <td x-text="formatCurrency(item.realisasi)"></td>
                        <td x-text="formatCurrency(item.selisih)"></td>
                        <td>
                            <div class="flex gap-2">
                                <button @click="selectedPendapatan = item; showEditModal = true"
                                    class="text-blue-600 hover:underline">Edit</button>
                                <button @click="selectedPendapatan = item; showDeleteModal = true"
                                    class="text-red-600 hover:underline">Hapus</button>
                            </div>
                        </td>
                    </tr>
                </template>
            </x-slot>


            <x-slot name="footer">
                <tr class="font-semibold bg-gray-100 text-sm">
                    <td class="p-2">Total Pendapatan tahun {{ $tahun }}</td>
                    <td x-text="formatCurrency(filteredPendapatan.reduce((sum, p) => sum + p.anggaran, 0))"></td>
                    <td x-text="formatCurrency(filteredPendapatan.reduce((sum, p) => sum + p.realisasi, 0))"></td>
                    <td x-text="formatCurrency(filteredPendapatan.reduce((sum, p) => sum + p.selisih, 0))"></td>
                    <td></td>
                </tr>
            </x-slot>

        </x-table>

        {{-- status crud --}}
        <x-stat-card \>

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
                            <input type="number" name="tahun" x-model="selectedApbdes.tahun"
                                :placeholder="tahun" min="1900" max="2099"
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
    </section>
</x-admin-layout>
