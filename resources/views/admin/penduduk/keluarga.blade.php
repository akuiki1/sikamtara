<x-admin-layout>
    <x-slot:title>{{ 'Kelola Data Keluarga' }}</x-slot>

    <div class="p-6" x-data="keluargaApp()">
        <script>
            function keluargaApp() {
                return {
                    keluargaList: @json($keluargas),
                    search: '',
                    filterRt: '',
                    filterRw: '',
                    modalData: {},
                    modalMode: 'create',
                    showModal: false,
                    openModal(mode, data = null) {
                        this.modalMode = mode;
                        this.modalData = mode === 'edit' ? {
                            ...data
                        } : {
                            kode_keluarga: '',
                            kepala_keluarga: '',
                            alamat: '',
                            dusun: '',
                            rt: '',
                            rw: ''
                        };
                        this.showModal = true;
                    },
                    get filteredKeluarga() {
                        return this.keluargaList.filter(k => {
                            return (!this.filterRt || k.rt == this.filterRt) &&
                                (!this.filterRw || k.rw == this.filterRw) &&
                                (!this.search || k.kepala_keluarga.toLowerCase().includes(this.search.toLowerCase()));
                        });
                    },
                    submitForm() {
                        this.$refs.form.submit();
                    },
                    hapusKeluarga(kode_keluarga) {
                        if (confirm('Yakin ingin menghapus data keluarga ini?')) {
                            fetch(`/keluarga/${kode_keluarga}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    _method: 'DELETE'
                                })
                            }).then(() => location.reload());
                        }
                    }
                }
            }
        </script>

        <div class="flex justify-between items-center mb-4">
            <div class="flex gap-2">
                <input type="text" placeholder="Cari keluarga..." x-model="search"
                    class="border rounded-full px-4 py-2 w-60">
                <select x-model="filterRt" class="border rounded-full px-4 py-2">
                    <option value="">Semua RT</option>
                    @foreach (array_unique(array_column($keluargas->toArray(), 'rt')) as $rt)
                        <option value="{{ $rt }}">RT {{ $rt }}</option>
                    @endforeach
                </select>
                <select x-model="filterRw" class="border rounded-full px-4 py-2">
                    <option value="">Semua RW</option>
                    @foreach (array_unique(array_column($keluargas->toArray(), 'rw')) as $rw)
                        <option value="{{ $rw }}">RW {{ $rw }}</option>
                    @endforeach
                </select>
            </div>
            <button @click="openModal('create')" class="bg-blue-600 text-white px-4 py-2 rounded-full">
                + Tambah KK
            </button>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Kode Keluarga</th>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Alamat</th>
                        <th class="px-4 py-2 text-left">RT</th>
                        <th class="px-4 py-2 text-left">RW</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($keluargas as $index => $keluarga)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $keluarga->kode_keluarga }}</td>
                            <td class="px-4 py-2">{{ $keluarga->kepala_keluarga }}</td>
                            <td class="px-4 py-2">{{ $keluarga->alamat }}</td>
                            <td class="px-4 py-2">{{ $keluarga->rt }}</td>
                            <td class="px-4 py-2">{{ $keluarga->rw }}</td>
                            <td class="px-4 py-2">
                                <!-- Aksi edit / hapus -->
                                <button @click="editKeluarga({{ $keluarga->kode_keluarga }})"
                                    class="text-blue-500 hover:underline">Edit</button>
                                <button @click="hapusKeluarga({{ $keluarga->kode_keluarga }})"
                                    class="text-red-500 hover:underline ml-2">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data keluarga</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div x-show="showModal" @click.away="showModal = false"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg w-96 p-6">
                <h2 class="text-lg font-semibold mb-4"
                    x-text="modalMode === 'edit' ? 'Edit Keluarga' : 'Tambah Keluarga'"></h2>
                <form x-ref="form" :action="modalMode === 'edit' ? `/keluarga/${modalData.id}` : '/admin/keluarga'"
                    method="POST">
                    @csrf
                    <template x-if="modalMode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <input type="text" name="kode_keluarga" class="w-full mb-2 border rounded px-3 py-2"
                        placeholder="Kode Keluarga" x-model="modalData.kode_keluarga">
                    <input type="text" name="kepala_keluarga" class="w-full mb-2 border rounded px-3 py-2" placeholder="nama kepala keluarga"
                        x-model="modalData.kepala_keluarga">
                    <input type="text" name="alamat" class="w-full mb-2 border rounded px-3 py-2"
                        placeholder="Alamat" x-model="modalData.alamat">
                    <input type="text" name="dusun" class="w-full mb-2 border rounded px-3 py-2"
                        placeholder="Dusun" x-model="modalData.dusun">
                    <input type="text" name="rt" class="w-full mb-2 border rounded px-3 py-2" placeholder="RT"
                        x-model="modalData.rt">
                    <input type="text" name="rw" class="w-full mb-2 border rounded px-3 py-2" placeholder="RW"
                        x-model="modalData.rw">
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="showModal = false"
                            class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
