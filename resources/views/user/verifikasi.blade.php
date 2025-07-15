<x-layout>
    <div class="bg-gray-100">
        <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-9 px-6 text-center">
        </section>

        <section class="flex items-center justify-center bg-gray-100">
            <div
                class="bg-white rounded-2xl shadow-xl w-full max-w-2xl px-10 py-10 transition-all duration-300 mt-5 mb-5">
                <a href="{{ route('profil.edit') }}" class="flex items-center text-gray-500 hover:underline mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>

                <h2 class="text-3xl font-bold text-center text-gray-800">Verifikasi Akun</h2>
                <p class="text-gray-600 text-center mb-6">
                    Untuk mengakses fitur-fitur lengkap, silahkan verifikasi akun Anda.
                </p>

                <form x-data="{
                    changed: false,
                    previewKtp: '{{ $verifikasi?->foto_ktp ? asset('storage/' . $verifikasi->foto_ktp) : '' }}',
                    previewSelfie: '{{ $verifikasi?->selfie_ktp ? asset('storage/' . $verifikasi->selfie_ktp) : '' }}',
                    previewKk: '{{ $verifikasi?->foto_kk ? asset('storage/' . $verifikasi->foto_kk) : '' }}',
                    fileTooLarge: {
                        foto_ktp: false,
                        selfie_ktp: false,
                        foto_kk: false
                    },
                    handlePreview(event, previewKey) {
                        const file = event.target.files[0];
                        if (!file) return;
                
                        const fileName = file.name.toLowerCase();
                        const isHeic = fileName.endsWith('.heic') || file.type === 'image/heic';
                
                        if (isHeic) {
                            alert('Format file .heic tidak didukung. Harap ubah ke format JPG, PNG, atau WEBP sebelum mengunggah.');
                            this[previewKey] = null;
                            event.target.value = '';
                            return;
                        }
                
                        this.fileTooLarge[previewKey] = file.size > 2 * 1024 * 1024;
                
                        if (this.fileTooLarge[previewKey]) {
                            this[previewKey] = null;
                            alert('Ukuran file ' + previewKey.replace('_', ' ') + ' terlalu besar. Maksimal 2MB.');
                            event.target.value = '';
                        } else {
                            const reader = new FileReader();
                            reader.onload = e => {
                                this[previewKey] = e.target.result;
                                this.changed = true;
                            };
                            reader.readAsDataURL(file);
                        }
                    },
                    handleSubmit(event) {
                        if (this.fileTooLarge.foto_ktp || this.fileTooLarge.selfie_ktp || this.fileTooLarge.foto_kk) {
                            alert('Ada file yang terlalu besar. Maksimal ukuran file adalah 2MB.');
                            event.preventDefault();
                        }
                    }
                }" @submit="handleSubmit" method="POST"
                    action="{{ route('profil.verifikasi.store') }}" enctype="multipart/form-data"
                    class="w-full flex flex-col items-center justify-center gap-6 px-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-4xl justify-items-center">
                        <template
                            x-for="input in [
                    { id: 'foto_ktp', label: 'Foto KTP', preview: 'previewKtp' },
                    { id: 'selfie_ktp', label: 'Selfie dengan KTP', preview: 'previewSelfie' },
                    { id: 'foto_kk', label: 'Foto Kartu Keluarga (KK)', preview: 'previewKk' }
                ]">
                            <div class="text-center w-fit" :key="input.id">
                                <label class="block text-sm font-medium text-gray-700 mb-2"
                                    x-text="input.label"></label>

                                <label :for="input.id"
                                    class="relative inline-block w-40 h-40 rounded-xl overflow-hidden shadow cursor-pointer group transition transform hover:scale-105"
                                    :class="[
                                        $data[input.preview] ?
                                        'rounded-full border-none bg-transparent' :
                                        'flex items-center justify-center bg-gray-50 border border-dashed border-gray-400'
                                    ]">

                                    <!-- Preview jika ada -->
                                    <template x-if="$data[input.preview]">
                                        <img :src="$data[input.preview]" alt="Preview"
                                            class="w-full h-full object-cover">
                                    </template>

                                    <!-- Jika belum ada -->
                                    <template x-if="!$data[input.preview]">
                                        <div class="text-center text-gray-500">
                                            <svg class="mx-auto w-10 h-10" fill="none" stroke="currentColor"
                                                stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            <p class="text-xs mt-1">Unggah</p>
                                        </div>
                                    </template>

                                    <div
                                        class="absolute inset-0 bg-black/50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                        <span class="text-sm font-semibold">Ubah</span>
                                    </div>
                                </label>

                                <input type="file" :id="input.id" :name="input.id"
                                    accept=".jpg,.jpeg,.png,.webp" class="hidden"
                                    @change="handlePreview($event, input.preview)">

                                <!-- Notifikasi error ukuran -->
                                <template x-if="fileTooLarge[input.id]">
                                    <p class="text-red-600 text-xs mt-2">Ukuran file terlalu besar (maks. 2MB)</p>
                                </template>
                            </div>
                        </template>
                    </div>

                    <div class="text-center mt-6" x-show="changed" x-transition>
                        <x-button type="submit">
                            Kirim Verifikasi
                        </x-button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</x-layout>
