<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="bg-white rounded-xl px-6 py-8 shadow-md space-y-8">
        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Profil Saya</h1>
        </div>

        {{-- Form Profil --}}
        <form x-data="{
            editEmail: false,
            editPassword: false,
            preview: '{{ optional(Auth::user())->foto ? asset('storage/' . Auth::user()->foto) : asset('img/default-avatar.jpg') }}',
            originalEmail: '{{ Auth::user()->email }}',
            email: '{{ Auth::user()->email }}',
            originalNama: '{{ Auth::user()->nama }}',
            nama: '{{ Auth::user()->nama }}',
            editing: false,
            password: '',
            confirm: '',
            confirmshow: false,
            valid: false,
            match: true,
            show: false,
            fotoChanged: false,
            fotoError: '',
            isChanged() {
                return (
                    this.email !== this.originalEmail ||
                    this.nama !== this.originalNama ||
                    this.editPassword ||
                    this.fotoChanged
                );
            },
            resetChanges() {
                this.email = this.originalEmail;
                this.nama = this.originalNama;
                this.password = '';
                this.editEmail = false;
                this.editPassword = false;
                this.preview = '{{ optional(Auth::user())->foto ? asset('storage/' . Auth::user()->foto) : asset('img/default-avatar.jpg') }}';
                this.fotoChanged = false;
                this.fotoError = '';
            }
        }" action="{{ route('admin.profil.update') }}" method="POST"
            enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Foto Profil -->
            <div class="flex items-center gap-6">
                <div>
                    <img :src="preview" alt="Foto Profil"
                        class="w-20 h-20 rounded-full object-cover border shadow">
                </div>

                <div class="flex flex-col space-y-2">
                    <label class="flex items-center space-x-2">
                        <label
                            class="inline-flex items-center px-4 py-2 bg-indigo-400 text-white text-sm font-medium rounded-lg shadow cursor-pointer hover:bg-indigo-600 transition">
                            + Change Image
                            <input type="file" name="foto" class="hidden" accept=".jpg,.jpeg,.png,.gif"
                                @change="
                            const file = $event.target.files[0];
                            if (file) {
                                preview = URL.createObjectURL(file);
                                fotoChanged = true;
                                if (file.size > 2 * 1024 * 1024) {
                                    fotoError = 'Ukuran Terlalu besar. foto maksimal 2MB. silahkan pilih foto lain.';
                                } else {
                                    fotoError = '';
                                }
                            }
                        ">
                        </label>
                    </label>
                    <p class="text-xs text-gray-400">Format: jpg, jpeg, png. Maks 2Mb</p>
                    <p x-show="fotoError" class="text-sm text-red-500" x-text="fotoError"></p>
                </div>
            </div>
            {{-- Nama --}}
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="nama" id="nama" x-model="nama"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-800 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                    placeholder="Masukkan nama lengkap" required>
            </div>

            {{-- Account Security --}}
            <div class="space-y-6 pt-6 border-t">
                <h2 class="text-lg font-semibold text-gray-800">Keamanan Akun</h2>

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative">
                        <input type="email" name="email" :readonly="!editEmail" x-model="email"
                            :class="editEmail ? 'bg-white text-gray-900 ring-2 ring-indigo-400' : 'bg-gray-100 text-gray-500'"
                            class="px-4 py-2 pr-24 border border-gray-300 rounded-lg shadow-sm focus:outline-none transition w-full">
                        <div class="absolute top-1/2 right-3 transform -translate-y-1/2 flex gap-2">
                            <template x-if="editEmail">
                                <button @click.prevent="editEmail = false; email = originalEmail"
                                    class="text-sm text-gray-600 hover:text-red-500">Batal</button>
                            </template>
                            <template x-if="!editEmail">
                                <button @click.prevent="editEmail = true"
                                    class="text-sm text-indigo-600 hover:underline">Edit email</button>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>

                    <!-- Mode Edit -->
                    <template x-if="editing">
                        <div class="space-y-4">
                            <!-- Password -->
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" name="password" x-model="password"
                                    @input="valid = password.length >= 8; match = password === confirm"
                                    class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:border-blue-500 transition bg-white"
                                    placeholder="Password baru">

                                <!-- SVG mata -->
                                <button type="button" @click="show = !show"
                                    class="absolute top-2.5 right-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="M3 10a13.358 13.358 0 0 0 3 2.685M21 10a13.358 13.358 0 0 1-3 2.685m-8 1.624L9.5 16.5m.5-2.19a10.59 10.59 0 0 0 4 0m-4 0a11.275 11.275 0 0 1-4-1.625m8 1.624l.5 2.191m-.5-2.19a11.275 11.275 0 0 0 4-1.625m0 0l1.5 1.815M6 12.685L4.5 14.5" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Validasi password -->
                            <p class="text-xs mt-1 flex items-center gap-1" x-show="password.length > 0"
                                :class="valid ? 'text-green-500' : 'text-red-500'">
                                <svg x-show="valid" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <svg x-show="!valid" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span
                                    x-text="valid ? 'Password memenuhi syarat' : 'Password minimal 8 karakter'"></span>
                            </p>

                            <!-- Konfirmasi password -->
                            <div class="relative">
                                <input :type="confirmshow ? 'text' : 'password'" name="password_confirmation"
                                    x-model="confirm" @input="match = password === confirm"
                                    class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:border-blue-500 transition bg-white"
                                    placeholder="Konfirmasi password">

                                <!-- SVG mata -->
                                <button type="button" @click="confirmshow = !confirmshow"
                                    class="absolute top-2.5 right-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <svg x-show="confirmshow" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="!confirmshow" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="M3 10a13.358 13.358 0 0 0 3 2.685M21 10a13.358 13.358 0 0 1-3 2.685m-8 1.624L9.5 16.5m.5-2.19a10.59 10.59 0 0 0 4 0m-4 0a11.275 11.275 0 0 1-4-1.625m8 1.624l.5 2.191m-.5-2.19a11.275 11.275 0 0 0 4-1.625m0 0l1.5 1.815M6 12.685L4.5 14.5" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Validasi konfirmasi -->
                            <p class="text-xs mt-1 flex items-center gap-1" x-show="confirm.length > 0"
                                :class="match ? 'text-green-500' : 'text-red-500'">
                                <svg x-show="match" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <svg x-show="!match" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span x-text="match ? 'Password sesuai' : 'Password harus sesuai'"></span>
                            </p>
                            <button type="button"
                                @click="editing = false; show = false; valid = false; password=''; confirm='';"
                                class="text-sm text-gray-500 hover:text-red-600 hover:underline">
                                Batal
                            </button>
                        </div>
                    </template>

                    <!-- Mode Non-Edit -->
                    <template x-if="!editing">
                        <div class="relative">
                            <input type="password" value="********" readonly
                                class="w-full px-4 py-2 pr-24 border border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed" />
                            <div class="absolute top-1/2 right-3 transform -translate-y-1/2">
                                <button type="button" @click="editing = true"
                                    class="text-sm text-indigo-600 hover:underline focus:outline-none">
                                    Edit Password
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Tombol Simpan dan Batal --}}
            <div class="flex justify-end pt-4 gap-2" x-show="isChanged()">
                <x-button variant="secondary" @click.prevent="resetChanges()">Batal</x-button>
                <x-button type="submit" variant="primary" x-bind:disabled="fotoError"
                    x-bind:class="fotoError ? 'opacity-50 cursor-not-allowed' : ''">
                    Simpan Perubahan
                </x-button>
            </div>
        </form>
    </div>
</x-admin-layout>
