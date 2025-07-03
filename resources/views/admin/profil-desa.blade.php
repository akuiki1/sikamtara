<x-admin-layout>
    <x-slot:title>Profil Desa</x-slot:title>

    {{-- Sejarah Desa --}}
    <section x-data="{
        editing: false,
        sejarah: @js($sejarah->sejarah ?? ''),
        editedSejarah: @js($sejarah->sejarah ?? '')
    }" class="py-16 px-6 md:px-16 bg-gray-50">
        <div class="max-w-xl mx-auto text-center">
            {{-- judul --}}
            <h2 class="text-2xl md:text-3xl font-semibold mb-8">Sejarah Desa</h2>

            {{-- isi --}}
            <div x-show="!sejarah && !editing" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" class="rounded-lg p-6 text-center">

                <p class="text-gray-700 mb-4">Belum ada sejarah desa</p>
                <x-button @click="editing = true">
                    Tambahkan sejarah
                </x-button>
            </div>
        </div>


        <!-- Jika ada sejarah dan tidak sedang mengedit -->
        <div x-show="sejarah && !editing" class="max-w-3xl mx-auto text-justify text-gray-700 leading-relaxed">
            <p x-text="sejarah"></p>
            <button @click="editing = true" class="text-blue-600 hover:underline text-sm">Edit</button>
        </div>

        <!-- Form edit sejarah -->
        <form x-show="editing" x-transition method="POST" action="{{ route('sejarah.update') }}"
            class="max-w-3xl mx-auto space-y-4 mt-4">
            @csrf
            @method('PUT')
            <textarea name="sejarah" x-model="editedSejarah" rows="10"
                class="w-full p-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200 text-gray-800"
                placeholder="Tulis sejarah desa di sini..."></textarea>

            <div class="flex justify-end space-x-4">
                <x-button type="button" @click="editing = false; editedSejarah = sejarah" variant="secondary">
                    Batal
                </x-button>
                <x-button type="submit" @click="sejarah = editedSejarah; editing = false">
                    Simpan
                </x-button>
            </div>
        </form>
    </section>

    <section class="py-16 px-6 md:px-16" x-data="{
        editing: false,
        visi: @js($visimisi->visi ?? ''),
        misi: @js($visimisi->misi ?? '')
    }">
        <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Visi & Misi</h2>

        <!-- Tampilan Awal -->
        <template x-if="!editing">
            <div>
                @if ($visimisi)
                    <div class="grid md:grid-cols-2 gap-8 mb-6">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-xl font-bold mb-4 text-green-600">Visi</h3>
                            <p class="text-gray-700" x-text="visi"></p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-xl font-bold mb-4 text-green-600">Misi</h3>
                            <ul class="list-disc list-inside text-gray-700 space-y-2">
                                <template x-for="item in misi.split('\n')" :key="item">
                                    <li x-text="item"></li>
                                </template>
                            </ul>
                        </div>
                    </div>
                @else
                    <p class="text-center text-gray-600 mb-4">Belum ada visi-misi desa.</p>
                @endif

                <div class="flex justify-center">
                    <x-button @click="editing = true">
                        {{ $visimisi ? 'Edit Visi & Misi' : 'Tambah Visi & Misi' }}
                    </x-button>
                </div>
            </div>
        </template>

        <!-- Form Edit/Tambah -->
        <form method="POST" action="{{ route('visimisi.update') }}"
            class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 mt-8 space-y-4" x-show="editing">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Visi</label>
                <textarea name="visi" rows="3" class="w-full border rounded p-2" required x-text="visi"></textarea>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Misi (Pisahkan dengan Enter)</label>
                <textarea name="misi" rows="5" class="w-full border rounded p-2" required x-text="misi"></textarea>
            </div>

            <div class="flex justify-end gap-4">
                <x-button type="button" variant="secondary" @click="editing = false">
                    Batal
                </x-button>
                <x-button type="submit">
                    Simpan
                </x-button>
            </div>
        </form>
    </section>


    {{-- Data Wilayah --}}
    <section x-data="{
        luas: '',
        penduduk: '',
        rt: '',
        rw: '',
        editing: false,
        original: {},
        startEdit() {
            this.original = { luas: this.luas, penduduk: this.penduduk, rt: this.rt, rw: this.rw };
            this.editing = true;
        },
        cancelEdit() {
            Object.assign(this, this.original);
            this.editing = false;
        },
        saveEdit() {
            // kirim ke server pake fetch/ajax di sini kalau mau
            this.editing = false;
        },
        tambahData() {
            this.luas = '';
            this.penduduk = '';
            this.rt = '';
            this.rw = '';
            this.editing = true;
        }
    }" class="py-16 px-6 md:px-16 bg-gray-50">
        <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Data Wilayah</h2>

        <template x-if="luas || penduduk || rt || rw">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-5xl mx-auto">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="luas" @input="startEdit()"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full" />
                    <div class="text-gray-600 mt-2">Luas Wilayah</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="penduduk" @input="startEdit()"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full" />
                    <div class="text-gray-600 mt-2">Jumlah Penduduk</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="rt" @input="startEdit()"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full" />
                    <div class="text-gray-600 mt-2">Jumlah RT</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="rw" @input="startEdit()"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full" />
                    <div class="text-gray-600 mt-2">Jumlah RW</div>
                </div>
            </div>
        </template>

        <!-- Form Input Baru saat Data Masih Kosong -->
        <div class="max-w-5xl mx-auto" x-show="editing && !(luas || penduduk || rt || rw)">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="luas"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full"
                        placeholder="Isi luas" />
                    <div class="text-gray-600 mt-2">Luas Wilayah</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="penduduk"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full"
                        placeholder="Isi jumlah penduduk" />
                    <div class="text-gray-600 mt-2">Jumlah Penduduk</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="rt"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full"
                        placeholder="Isi RT" />
                    <div class="text-gray-600 mt-2">Jumlah RT</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <input x-model="rw"
                        class="text-3xl font-bold text-green-600 text-center bg-transparent focus:outline-none w-full"
                        placeholder="Isi RW" />
                    <div class="text-gray-600 mt-2">Jumlah RW</div>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan / Batal -->
        <div class="text-center mt-8" x-show="editing">
            <x-button @click="saveEdit()">Simpan</x-button>
            <x-button @click="cancelEdit()" variant="secondary">Batal</x-button>
        </div>

        <!-- Kalau Belum Ada Data, tampilkan tombol Tambah -->
        <template x-if="!luas && !penduduk && !rt && !rw && !editing">
            <div class="text-center mt-8">
                <p class="text-gray-500 mb-4">Belum ada data wilayah</p>
                <x-button @click="tambahData()">Tambah</x-button>
            </div>
        </template>
    </section>

    {{-- Struktur Pemerintahan --}}
    <section class="py-16 px-6 md:px-16 bg-gray-100" x-data="{
        showDetailModal: false,
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        selectedStruktur: null,
    }">

        <!-- Judul & Penjelasan -->
        <div class="max-w-5xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-4">Struktur Pemerintahan Desa</h2>
        </div>

        <!-- Tombol Tambah -->
        @if ($strukturPemerintahan->count())
            <div class="text-center mb-8">
                <x-button @click="showAddModal = true">Tambah Struktur Pemerintahan</x-button>
            </div>
        @endif

        <!-- Kartu Struktur -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @forelse ($strukturPemerintahan as $p)
                <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center cursor-pointer hover:shadow-lg transition"
                    @click="selectedStruktur = {{ $p }}; showDetailModal = true">
                    <div class="w-32 h-32 mb-4">
                        <img src="{{ asset('storage/' . $p->user->foto) }}" alt="{{ $p->user->penduduk->nama }}"
                            class="w-full h-full object-cover rounded-full border-2 border-green-500">
                    </div>
                    <h3 class="text-lg font-bold text-green-600 mb-1">{{ $p->user->penduduk->nama }}</h3>
                    <p class="text-gray-600 text-sm">{{ $p->jabatan }}</p>
                </div>
            @empty
                <div class="col-span-full p-4 text-center">
                    <p class="text-gray-500 mb-4">Belum ada struktur pemerintahan.</p>
                    <x-button @click="showAddModal = true">Tambah Struktur Pemerintahan</x-button>
                </div>
            @endforelse
        </div>

        <!-- Modal Detail -->
        <x-modal show="showDetailModal">
            <div class="p-6 text-center">
                <template x-if="selectedStruktur">
                    <div>
                        <img :src="`/storage/${selectedStruktur.user.foto}`" alt=""
                            class="w-52 h-52 object-cover rounded-xl mx-auto mb-4 border-2 border-green-500">
                        <h3 class="text-lg font-bold text-green-600" x-text="selectedStruktur.user.penduduk.nama">
                        </h3>
                        <p class="text-gray-700 font-semibold mt-2" x-text="selectedStruktur.jabatan"></p>
                        <p class="text-gray-600 mt-2 text-sm justify-items-start" x-text="selectedStruktur.deskripsi">
                        </p>

                        <div class="mt-6 flex justify-center space-x-2 border-t pt-4">
                            <x-button @click="showDetailModal = false" variant="secondary">Tutup</x-button>
                            <x-button @click="showEditModal = true; showDetailModal = false"
                                variant="warning">Edit</x-button>
                            <x-button @click="showDeleteModal = true; showDetailModal = false"
                                variant="danger">Hapus</x-button>
                        </div>
                    </div>
                </template>
            </div>
        </x-modal>

        <!-- Modal Tambah -->
        <x-modal show="showAddModal">
            <form action="{{ route('admin.struktur.create') }}" method="POST" class="space-y-4">
                @csrf
                <h3 class="text-xl font-semibold text-center text-green-600 mb-4">Tambah Struktur Pemerintahan</h3>

                <!-- Input Nama -->
                <div>
                    <label for="user_nama" class="block text-sm font-medium text-gray-700">Pilih Warga</label>
                    <input list="namaList" id="user_nama" name="user_nama"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                        placeholder="Ketik nama warga..." autocomplete="off" required>
                    <input type="hidden" id="id_user" name="id_user">
                    <datalist id="namaList">
                        @foreach ($users as $user)
                            <option data-id="{{ $user->id_user }}" value="{{ $user->penduduk->nama }}"></option>
                        @endforeach
                    </datalist>
                    <p id="namaError" class="text-sm text-red-500 hidden mt-1">Warga tidak ditemukan.</p>
                </div>

                <!-- Jabatan -->
                <div>
                    <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Kontak / Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-2 pt-4 border-t">
                    <x-button type="button" @click="showAddModal = false" variant="secondary">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        <!-- Modal Edit Struktur Pemerintahan -->
        <x-modal show="showEditModal">
            <form :action="`/admin/struktur/${selectedStruktur?.id}/update`" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <h3 class="text-xl font-semibold text-center text-green-600 mb-4">Edit Struktur Pemerintahan</h3>

                <!-- Pilih Warga -->
                <div>
                    <label for="user_nama_edit" class="block text-sm font-medium text-gray-700">Pilih Warga</label>
                    <input list="namaListEdit" id="user_nama_edit" name="user_nama"
                        x-model="selectedStruktur?.user?.penduduk?.nama"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                        placeholder="Ketik nama warga..." autocomplete="off" required>
                    <input type="hidden" id="id_user_edit" name="id_user" :value="selectedStruktur?.user?.id_user">
                    <datalist id="namaListEdit">
                        @foreach ($users as $user)
                            <option data-id="{{ $user->id_user }}" value="{{ $user->penduduk->nama }}"></option>
                        @endforeach
                    </datalist>
                    <p id="namaErrorEdit" class="text-sm text-red-500 hidden mt-1">Warga tidak ditemukan.</p>
                </div>

                <!-- Jabatan -->
                <div>
                    <label for="jabatan_edit" class="block text-sm font-medium text-gray-700">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan_edit" x-model="selectedStruktur?.jabatan"
                        required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi_edit" class="block text-sm font-medium text-gray-700">Deskripsi /
                        Kontak</label>
                    <textarea name="deskripsi" id="deskripsi_edit" rows="3" x-text="selectedStruktur?.deskripsi"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-2 pt-4 border-t">
                    <x-button type="button" @click="showEditModal = false" variant="secondary">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        <!-- Modal Hapus -->
        <x-modal show="showDeleteModal">
            <form :action="`/admin/struktur/${selectedStruktur?.id}/delete`" method="POST" class="text-center p-6">
                @csrf
                @method('DELETE')
                <h3 class="text-lg font-semibold text-red-600 mb-4">Hapus Struktur Pemerintahan</h3>
                <p class="text-gray-700 mb-4">Yakin ingin menghapus data ini?</p>
                <div class="flex justify-center space-x-4">
                    <x-button type="button" @click="showDeleteModal = false" variant="secondary">Batal</x-button>
                    <x-button type="submit" variant="danger">Hapus</x-button>
                </div>
            </form>
        </x-modal>

        <!-- Validasi Nama JS -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const validateNama = (inputId, datalistId, hiddenId, errorId) => {
                    const input = document.getElementById(inputId);
                    const datalist = document.getElementById(datalistId);
                    const hidden = document.getElementById(hiddenId);
                    const error = document.getElementById(errorId);

                    input?.addEventListener('change', function() {
                        const entered = input.value.trim();
                        const match = [...datalist.options].find(opt => opt.value === entered);

                        if (match) {
                            hidden.value = match.dataset.id;
                            error.classList.add('hidden');
                            input.classList.remove('border-red-500', 'ring-red-500');
                        } else {
                            hidden.value = '';
                            error.classList.remove('hidden');
                            input.classList.add('border-red-500', 'ring-red-500');
                        }
                    });
                };

                validateNama('user_nama', 'namaList', 'id_user', 'namaError');
            });
        </script>
    </section>

    {{-- Program Pembangunan Desa --}}
    <section class="py-16 px-6 md:px-16 bg-gray-50">
        <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Program Pembangunan Desa</h2>
        <div class="space-y-6 max-w-3xl mx-auto text-justify">
            <ul class="list-disc list-inside text-gray-700">
                <li>Pembangunan jalan desa untuk meningkatkan akses transportasi.</li>
                <li>Peningkatan fasilitas pendidikan dan kesehatan di desa.</li>
                <li>Program pemberdayaan ekonomi lokal melalui pelatihan keterampilan.</li>
                <li>Penanaman pohon dan pemeliharaan lingkungan untuk menjaga kelestarian alam.</li>
            </ul>
        </div>
    </section>
</x-admin-layout>
