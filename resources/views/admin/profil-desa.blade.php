<x-admin-layout>
    <x-slot:title>Profil Desa</x-slot:title>

    {{-- Sejarah Desa --}}
    <section id="sejarah" x-data="{
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
                <x-button type="submit"
                    @click.prevent="
                        if (editedSejarah.trim() === '') {
                            alert('Sejarah tidak boleh kosong.');
                        } else {
                            sejarah = editedSejarah;
                            editing = false;
                            $el.closest('form').submit();
                        }
                    ">
                    Simpan
                </x-button>
            </div>
        </form>
    </section>

    {{-- visi misi --}}
    <section id="visimisi" class="py-16 px-6 md:px-16" x-data="{
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
                <label class="block font-semibold text-gray-700 mb-1">Visi<span class="text-red-600">*</span></label>
                <textarea name="visi" rows="3" class="w-full border rounded p-2" required x-text="visi"></textarea>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Misi<span class="text-red-600">*</span> <span
                        class="text-gray-400 text-xs font-normal">(Pisahkan dengan Enter)</span></label>
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

    {{-- Struktur Pemerintahan --}}
    <section id="struktur" class="py-16 px-6 md:px-16 bg-gray-100" x-data="{
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
                        <img src="{{ optional($p->user)->foto ? asset('storage/' . $p->user->foto) : asset('img/default-avatar.jpg') }}"
                            alt="{{ $p->user->penduduk->nama }}"
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
                        <img :src="selectedStruktur.user.foto ?
                            `/storage/${selectedStruktur.user.foto}` :
                            '/img/default-avatar.jpg'"
                            alt=""
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
                    <label for="user_nama" class="block text-sm font-medium text-gray-700">Pilih Warga<span
                            class="text-red-600">*</span></label>
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
                    <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan<span
                            class="text-red-600">*</span></label>
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
                    <label for="user_nama_edit" class="block text-sm font-medium text-gray-700">Pilih Warga<span
                            class="text-red-600">*</span></label>
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
                    <label for="jabatan_edit" class="block text-sm font-medium text-gray-700">Jabatan<span
                            class="text-red-600">*</span></label>
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
    <section id="program" class="py-16 px-6 md:px-16 bg-gray-50" x-data="{ showAdd: false, showDetail: false, showEdit: false, showDelete: false, selectedProgram: null }">
        <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Program Pembangunan Desa</h2>
        @if ($programs->count())
            <div class="text-center mb-8">
                <x-button @click="showAdd = true">Tambah Program Pembangunan</x-button>
            </div>
        @endif

        @if ($programs->isEmpty())
            <p class="text-center text-gray-600">Belum ada program pembangunan yang tercatat.</p>
            <div class="text-center mt-4">
                <x-button @click="showAdd = true">Tambah Program Pembangunan</x-button>
            </div>
        @else
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($programs as $program)
                        <div @click="selectedProgram = {{ $program->toJson() }}; showDetail = true"
                            class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 hover:scale-[1.02] cursor-pointer p-5 overflow-hidden">

                            {{-- Header --}}
                            <div class="flex items-start justify-between mb-3">
                                <div class="w-3/4">
                                    <h3
                                        class="text-lg font-bold text-green-700 leading-tight line-clamp-2 break-words">
                                        {{ $program->nama_program }}
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-1 truncate">
                                        {{ $program->jenis_program }} &mdash; {{ $program->lokasi }}
                                    </p>
                                </div>
                                <span
                                    class="text-[10px] px-2 py-1 rounded-full font-medium whitespace-nowrap
                                            {{ $program->status === 'selesai'
                                                ? 'bg-green-100 text-green-700'
                                                : ($program->status === 'pelaksanaan'
                                                    ? 'bg-yellow-100 text-yellow-700'
                                                    : ($program->status === 'batal'
                                                        ? 'bg-red-100 text-red-700'
                                                        : 'bg-gray-100 text-gray-700')) }}">
                                    {{ ucfirst($program->status) }}
                                </span>
                            </div>

                            {{-- Info --}}
                            <div class="text-xs text-gray-600 space-y-1">
                                <p><span class="font-semibold">Periode:</span><br>
                                    {{ \Carbon\Carbon::parse($program->tanggal_mulai)->format('d M Y') }} –
                                    {{ \Carbon\Carbon::parse($program->tanggal_selesai)->format('d M Y') }}
                                </p>
                                <p><span class="font-semibold">Anggaran:</span><br>
                                    Rp{{ number_format($program->anggaran, 0, ',', '.') }}
                                </p>
                                <p><span class="font-semibold">Sumber Dana:</span><br>{{ $program->sumber_dana }}</p>
                                <p><span class="font-semibold">PJ:</span> {{ $program->penanggung_jawab }}</p>
                            </div>

                            {{-- Deskripsi --}}
                            @if ($program->deskripsi)
                                <p class="mt-3 text-gray-700 text-sm leading-snug line-clamp-3 break-words">
                                    {{ $program->deskripsi }}
                                </p>
                            @endif

                            {{-- Foto --}}
                            @if ($program->foto_dokumentasi)
                                <div class="mt-3">
                                    <img src="{{ asset('storage/' . $program->foto_dokumentasi) }}"
                                        alt="Foto Program" class="rounded-md shadow-sm w-full h-32 object-cover">
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <!-- Modal Tambah Program -->
                    <x-modal show="showAdd" title="Tambah Program Pembangunan">
                        <form action="{{ route('admin.program.store') }}" method="POST"
                            enctype="multipart/form-data" x-data="{
                                previewFile: null,
                                fileTooLarge: false,
                                updatePreview(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        this.fileTooLarge = file.size > 2 * 1024 * 1024;
                                        if (!this.fileTooLarge) {
                                            this.previewFile = URL.createObjectURL(file);
                                        } else {
                                            this.previewFile = null;
                                        }
                                    }
                                },
                                handleSubmit(event) {
                                    if (this.fileTooLarge) {
                                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                                        event.preventDefault();
                                    }
                                }
                            }" @submit="handleSubmit($event)"
                            class="space-y-4">
                            @csrf

                            {{-- Form Inputs --}}
                            <div>
                                <label for="nama_program" class="block text-sm font-medium text-gray-700">Nama
                                    Program<span class="text-red-600">*</span></label>
                                <input type="text" name="nama_program" id="nama_program" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            </div>

                            <div>
                                <label for="jenis_program" class="block text-sm font-medium text-gray-700">Jenis
                                    Program<span class="text-red-600">*</span></label>
                                <input type="text" name="jenis_program" id="jenis_program" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            </div>

                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi<span
                                        class="text-red-600">*</span></label>
                                <input type="text" name="lokasi" id="lokasi" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal
                                        Mulai<span class="text-red-600">*</span></label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                </div>
                                <div>
                                    <label for="tanggal_selesai"
                                        class="block text-sm font-medium text-gray-700">Tanggal
                                        Selesai</label>
                                    <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                </div>
                            </div>

                            <div>
                                <label for="anggaran" class="block text-sm font-medium text-gray-700">Anggaran
                                    (Rp)<span class="text-red-600">*</span></label>
                                <input type="number" name="anggaran" id="anggaran" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            </div>

                            <div>
                                <label for="sumber_dana" class="block text-sm font-medium text-gray-700">Sumber
                                    Dana<span class="text-red-600">*</span></label>
                                <input type="text" name="sumber_dana" id="sumber_dana" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            </div>

                            <div>
                                <label for="penanggung_jawab"
                                    class="block text-sm font-medium text-gray-700">Penanggung
                                    Jawab<span class="text-red-600">*</span></label>
                                <input type="text" name="penanggung_jawab" id="penanggung_jawab" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status<span
                                        class="text-red-600">*</span></label>
                                <select name="status" id="status" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                    <option value="perencanaan">Perencanaan</option>
                                    <option value="pelaksanaan">Pelaksanaan</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="batal">Batal</option>
                                </select>
                            </div>

                            <div>
                                <label for="deskripsi"
                                    class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
                            </div>

                            <div>
                                <label for="foto_dokumentasi" class="block text-sm font-medium text-gray-700">Foto
                                    Dokumentasi
                                    <small class="block text-xs text-gray-400 font-normal">Hanya gambar. Maks
                                        2MB.</small>
                                </label>
                                <input type="file" name="foto_dokumentasi" id="foto_dokumentasi" accept="image/*"
                                    @change="updatePreview"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">

                                <!-- Preview -->
                                <template x-if="previewFile">
                                    <img :src="previewFile" alt="Preview"
                                        class="mt-2 h-40 object-contain rounded border">
                                </template>

                                <template x-if="fileTooLarge">
                                    <p class="text-sm text-red-600 mt-2">Ukuran file terlalu besar. Maksimal 2MB.</p>
                                </template>
                            </div>

                            <div class="flex justify-end space-x-2 pt-4 border-t">
                                <x-button type="button" @click="showAdd = false"
                                    variant="secondary">Batal</x-button>
                                <x-button type="submit">Simpan</x-button>
                            </div>
                        </form>
                    </x-modal>

                    <!-- Modal Detail Program -->
                    <x-modal show="showDetail" title="Detail Program Pembangunan">
                        <div class="">
                            <template x-if="selectedProgram">
                                <div class="space-y-4 text-left">
                                    <!-- Judul -->
                                    <div>
                                        <h3 class="text-2xl font-semibold text-green-700"
                                            x-text="selectedProgram.nama_program">
                                        </h3>
                                        <p class="text-sm text-gray-500"
                                            x-text="`${selectedProgram.jenis_program} — ${selectedProgram.lokasi}`">
                                        </p>
                                    </div>

                                    <!-- Info Utama -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                                        <p><span class="font-semibold text-gray-600">Periode:</span><br>
                                            <span
                                                x-text="`${new Date(selectedProgram.tanggal_mulai).toLocaleDateString()} - ${new Date(selectedProgram.tanggal_selesai).toLocaleDateString()}`"></span>
                                        </p>
                                        <p><span class="font-semibold text-gray-600">Anggaran:</span><br>
                                            <span x-text="`Rp${selectedProgram.anggaran.toLocaleString()}`"></span>
                                        </p>
                                        <p><span class="font-semibold text-gray-600">Sumber Dana:</span><br>
                                            <span x-text="selectedProgram.sumber_dana"></span>
                                        </p>
                                        <p><span class="font-semibold text-gray-600">Penanggung Jawab:</span><br>
                                            <span x-text="selectedProgram.penanggung_jawab"></span>
                                        </p>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div x-show="selectedProgram.deskripsi" class="text-sm text-gray-700">
                                        <span class="font-semibold text-gray-600">Deskripsi:</span>
                                        <p class="mt-1 leading-snug line-clamp-3 break-words"
                                            x-text="selectedProgram.deskripsi">
                                        </p>
                                    </div>

                                    <!-- Foto Dokumentasi -->
                                    <template x-if="selectedProgram.foto_dokumentasi">
                                        <div>
                                            <img :src="`/storage/${selectedProgram.foto_dokumentasi}`"
                                                alt="Foto Program"
                                                class="w-full max-h-64 object-cover rounded-lg shadow mt-2 border">
                                        </div>
                                    </template>

                                    <!-- Tombol Aksi -->
                                    <div class="pt-4 border-t flex justify-end gap-3">
                                        <x-button @click="showDetail = false" variant="secondary">Tutup</x-button>
                                        <x-button @click="showEdit = true; showDetail = false"
                                            variant="warning">Edit</x-button>
                                        <x-button @click="showDelete = true; showDetail = false"
                                            variant="danger">Hapus</x-button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </x-modal>

                    <!-- Modal Edit Program -->
                    <x-modal show="showEdit" title="Edit Program Pembangunan">
                        <form :action="'{{ url('/admin/program') }}/' + selectedProgram.id" method="POST"
                            enctype="multipart/form-data" x-data="{
                                previewFile: null,
                                fileTooLarge: false,
                                updatePreview(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        this.fileTooLarge = file.size > 2 * 1024 * 1024;
                                        if (!this.fileTooLarge) {
                                            this.previewFile = URL.createObjectURL(file);
                                        } else {
                                            this.previewFile = null;
                                        }
                                    }
                                },
                                handleSubmit(event) {
                                    if (this.fileTooLarge) {
                                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                                        event.preventDefault();
                                    }
                                }
                            }" @submit="handleSubmit($event)"
                            class="space-y-4">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="redirect_to"
                                value="{{ route('profildesa.index') . '#program' }}">

                            {{-- Nama Program --}}
                            <div>
                                <label for="edit_nama_program" class="block text-sm font-medium text-gray-700">Nama
                                    Program</label>
                                <input type="text" name="nama_program" id="edit_nama_program"
                                    x-model="selectedProgram.nama_program"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            </div>

                            {{-- Jenis Program --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Program</label>
                                <input type="text" name="jenis_program" x-model="selectedProgram.jenis_program"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            {{-- Lokasi --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                                <input type="text" name="lokasi" x-model="selectedProgram.lokasi"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            {{-- Tanggal --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" :value="selectedProgram.tanggal_mulai"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai"
                                        :value="selectedProgram.tanggal_selesai"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>

                            {{-- Anggaran --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Anggaran (Rp)</label>
                                <input type="number" name="anggaran" x-model="selectedProgram.anggaran"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            {{-- Sumber Dana --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Sumber Dana</label>
                                <input type="text" name="sumber_dana" x-model="selectedProgram.sumber_dana"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            {{-- Penanggung Jawab --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                                <input type="text" name="penanggung_jawab"
                                    x-model="selectedProgram.penanggung_jawab"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            {{-- Status --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" x-model="selectedProgram.status"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="perencanaan">Perencanaan</option>
                                    <option value="pelaksanaan">Pelaksanaan</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="batal">Batal</option>
                                </select>
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="deskripsi" rows="3" x-model="selectedProgram.deskripsi"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                            </div>

                            {{-- Foto Dokumentasi --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ganti Foto (Opsional)
                                    <small class="block text-xs text-gray-400 font-normal">Hanya gambar. Maks
                                        2MB.</small>
                                </label>
                                <input type="file" name="foto_dokumentasi" accept="image/*"
                                    @change="updatePreview"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">

                                <template x-if="previewFile">
                                    <img :src="previewFile" alt="Preview"
                                        class="mt-2 h-40 object-contain rounded border">
                                </template>

                                <template x-if="fileTooLarge">
                                    <p class="text-sm text-red-600 mt-2">Ukuran file terlalu besar. Maksimal 2MB.</p>
                                </template>
                            </div>

                            {{-- Tombol --}}
                            <div class="flex justify-end space-x-2 pt-4 border-t">
                                <x-button type="button" @click="showEdit = false"
                                    variant="secondary">Batal</x-button>
                                <x-button type="submit">Perbarui</x-button>
                            </div>
                        </form>
                    </x-modal>

                    <!-- Modal Konfirmasi Hapus -->
                    <x-modal show="showDelete" title="Hapus Program Pembangunan">
                        <form action="{{ route('admin.program.destroy', $program->id) }}" method="POST"
                            class="space-y-4">
                            @csrf
                            @method('DELETE')

                            <p>Apakah Anda yakin ingin menghapus program <strong>{{ $program->nama_program }}</strong>?
                            </p>

                            <div class="flex justify-end space-x-2 pt-4 border-t">
                                <x-button type="button" @click="showDelete = false"
                                    variant="secondary">Batal</x-button>
                                <x-button type="submit" variant="danger">Hapus</x-button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            </div>
        @endif
    </section>
</x-admin-layout>
