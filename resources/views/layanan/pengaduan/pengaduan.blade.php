<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-10 px-6 text-center">
    </section>
    
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Form Pengaduan -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-xl rounded-2xl p-8 space-y-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Pengaduan Baru
                    </h2>
                    <form class="space-y-6">
                        <!-- Input form disini (judul, kategori, isi, lampiran) sama persis kaya sebelumnya -->

                        <div>
                            <label class="block text-sm font-medium mb-1" for="judul">Judul Pengaduan</label>
                            <input type="text" id="judul" name="judul"
                                class="w-full pl-3 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Masukkan judul">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1" for="kategori">Kategori Pengaduan</label>
                            <select id="kategori" name="kategori"
                                class="w-full pl-3 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                                <option>Pilih Kategori</option>
                                <option>Pelayanan</option>
                                <option>Infrastruktur</option>
                                <option>Administrasi</option>
                                <option>Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1" for="isi">Isi Pengaduan</label>
                            <textarea id="isi" name="isi" rows="4"
                                class="w-full p-4 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Tulis isi pengaduan..."></textarea>
                        </div>

                        <div x-data="uploadLampiran()" class="space-y-4">
                            <label class="block text-sm font-medium mb-1 text-gray-700">Lampiran *(JPG, PNG,
                                WebP)</label>

                            <!-- Input Upload -->
                            <input type="file" id="lampiran" accept="image/jpeg,image/jpg,image/png,image/webp"
                                multiple class="hidden" x-ref="fileInput" @change="handleFiles">

                            <!-- Tombol Upload -->
                            <button type="button" @click="$refs.fileInput.click()"
                                class="flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl shadow transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Pilih Foto
                            </button>

                            <!-- Preview Area -->
                            <div class="flex gap-4 overflow-x-auto mt-4" x-show="files.length">
                                <template x-for="(file, index) in files" :key="index">
                                    <div class="relative rounded-lg overflow-hidden shadow-md group flex-shrink-0 w-32">
                                        <img :src="file.url" alt="Preview" class="object-cover w-full h-32">

                                        <!-- Tombol Hapus -->
                                        <button type="button" @click="removeFile(index)"
                                            class="absolute top-1 right-1 bg-red-500 text-white text-xs rounded-full p-1 hover:bg-red-600 transition"
                                            title="Hapus">
                                            &times;
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <!-- Hidden input files untuk submit -->
                            <template x-for="(file, index) in files" :key="'input-' + index">
                                <input type="hidden" :name="'lampiran_base64[]'" :value="file.base64">
                            </template>
                        </div>

                        <script>
                            function uploadLampiran() {
                                return {
                                    files: [],
                                    handleFiles(event) {
                                        const selectedFiles = event.target.files;
                                        for (const file of selectedFiles) {
                                            if (!file.type.startsWith('image/')) {
                                                alert(`File "${file.name}" bukan gambar yang diperbolehkan.`);
                                                continue;
                                            }
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                this.files.push({
                                                    url: e.target.result,
                                                    base64: e.target.result,
                                                    name: file.name,
                                                    type: file.type
                                                });
                                            };
                                            reader.readAsDataURL(file);
                                        }
                                        this.$refs.fileInput.value = '';
                                    },
                                    removeFile(index) {
                                        this.files.splice(index, 1);
                                    }
                                }
                            }
                        </script>



                        <div class="text-right">
                            <button type="submit"
                                class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-6 rounded-xl shadow-lg transition transform hover:scale-105">
                                Kirim Pengaduan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Riwayat Pengaduan -->
            <div x-data="{ open: false }" class="space-y-6">
                <div class="bg-white shadow-xl rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 20h9"></path>
                            <path d="M12 4h9"></path>
                            <path d="M4 9h16v6H4z"></path>
                        </svg>
                        Riwayat Pengaduan
                    </h3>

                    <div class="space-y-4">
                        <!-- Card Riwayat -->
                        <div class="p-4 bg-gray-50 rounded-xl shadow hover:shadow-md transition">
                            <div class="flex items-center justify-between mt-3">
                                <h4 class="font-semibold text-gray-900">Judul Pengaduan 1</h4>
                                <span
                                    class="text-center text-xs font-medium bg-blue-100 rounded-full p-1 w-20 text-blue-700">Terkirim</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1 line-clamp-2">Deskripsi singkat pengaduan...</p>
                            <div class="flex items-center justify-between mt-3">
                                <button @click="open = true"
                                    class="bg-emerald-500 w-24 p-1 rounded-full font-semibold text-green-50 hover:auto text-sm">Lihat
                                    Detail</button>
                            </div>
                        </div>

                        <!-- Modal Detail -->
                        <div x-show="open" x-data="{
                            editMode: false,
                            updated: false,
                            status: 'terkirim',
                            judul: 'Judul Laporan Pengaduan',
                            isi: 'Isi laporan pengaduan yang dikirimkan...',
                            lampiranUrl: '/path/to/lampiran.jpg',
                            terkirimPada: '2025-04-28 10:30',
                        }" x-transition
                            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                            <div @click.away="open = false"
                                class="bg-white rounded-2xl p-8 w-full max-w-2xl space-y-6 shadow-2xl overflow-y-auto max-h-[90vh]">

                                <!-- Tombol Kembali -->
                                <button @click="open = false"
                                    class="text-gray-500 hover:text-gray-700 text-sm font-semibold flex items-center gap-1 mb-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Kembali
                                </button>

                                <!-- Judul Laporan -->
                                <h2 class="text-2xl font-bold text-gray-800 mb-2" x-text="judul"></h2>

                                <!-- Lampiran Foto -->
                                <div class="rounded-xl overflow-hidden shadow-lg">
                                    <img :src="lampiranUrl" alt="Lampiran" class="object-cover w-full h-64">
                                </div>

                                <!-- Terkirim Pada -->
                                <p class="text-gray-500 text-sm mt-2">
                                    <strong>Laporan Terkirim Pada:</strong> <span x-text="terkirimPada"></span>
                                </p>

                                <!-- Form Edit -->
                                <div class="space-y-4 mt-6">

                                    <!-- Edit Judul -->
                                    <div>
                                        <label class="text-sm font-semibold text-gray-700">Judul</label>
                                        <input type="text" x-model="judul" :readonly="status !== 'terkirim'"
                                            @input="updated = true"
                                            class="w-full p-3 rounded-lg border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                                    </div>

                                    <!-- Edit Isi -->
                                    <div>
                                        <label class="text-sm font-semibold text-gray-700">Isi Pengaduan</label>
                                        <textarea x-model="isi" :readonly="status !== 'terkirim'" @input="updated = true" rows="5"
                                            class="w-full p-3 rounded-lg border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                                    </div>

                                </div>

                                <!-- Tombol Aksi -->
                                <div class="flex justify-end gap-4 mt-6">
                                    <template x-if="status === 'terkirim'">
                                        <button x-show="updated"
                                            class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-6 rounded-xl transition">
                                            Simpan
                                        </button>
                                    </template>

                                    <template x-if="!updated || status !== 'terkirim'">
                                        <button @click="open = false"
                                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-xl transition">
                                            Kembali
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
