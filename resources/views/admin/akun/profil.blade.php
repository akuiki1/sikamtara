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
            preview: '{{ asset('storage/' . Auth::user()->foto) }}',
            originalEmail: '{{ Auth::user()->email }}',
            email: '{{ Auth::user()->email }}',
            originalNama: '{{ Auth::user()->nama }}',
            nama: '{{ Auth::user()->nama }}',
            password: '',
            fotoChanged: false,
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
                this.preview = '{{ asset('storage/' . Auth::user()->foto) }}';
                this.fotoChanged = false;
            }
        }" action="{{ route('admin.profil.update') }}" method="POST"
            enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Foto Profil --}}
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
                                    preview = URL.createObjectURL($event.target.files[0]);
                                    fotoChanged = true;
                                ">
                        </label>
                    </label>
                    <p class="text-xs text-gray-400">We support PNGs, JPEGs and GIFs under 2MB</p>
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
                    <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <div class="relative">
                        <div class="space-y-2">
                            <input type="password" name="password" x-model="password" :readonly="!editPassword"
                                :class="editPassword ? 'bg-white text-gray-900 ring-2 ring-indigo-400' :
                                    'bg-gray-100 text-gray-500'"
                                placeholder="**************"
                                class="px-4 py-2 pr-24 border border-gray-300 rounded-lg shadow-sm focus:outline-none transition w-full">

                            <template x-if="editPassword">
                                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                                    class="px-4 py-2 pr-24 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none w-full">
                            </template>
                        </div>
                        <div class="absolute top-2 right-3 flex gap-2">
                            <template x-if="editPassword">
                                <button @click.prevent="editPassword = false; password = ''"
                                    class="text-sm text-gray-600 hover:text-red-500">Batal</button>
                            </template>
                            <template x-if="!editPassword">
                                <button @click.prevent="editPassword = true"
                                    class="text-sm text-indigo-600 hover:underline">Ganti password</button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Simpan dan Batal --}}
            <div class="flex justify-end pt-4 gap-2" x-show="isChanged()">
                <x-button variant="secondary" @click.prevent="resetChanges()">Batal</x-button>
                <x-button type="submit" variant="primary">Simpan Perubahan</x-button>
            </div>
        </form>

        {{-- Google Account --}}
        <div class="pt-6 border-t">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Google Account</h2>
            <div class="flex flex-col sm:flex-row items-center gap-4">
                @if (Auth::user()->google_id)
                    <span class="text-green-600 text-sm">Akun Google telah terhubung.</span>
                    <form action="#" method="POST">
                    {{-- <form action="{{ route('admin.profil.google.disconnect') }}" method="POST"> --}}
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline">Putuskan Akun Google</button>
                    </form>
                @else
                    <a href="#"
                    {{-- <a href="{{ route('admin.profil.google.connect') }}" --}}
                        class="flex items-center bg-white border px-4 py-2 rounded-xl shadow hover:scale-105 transition">
                        <img class="h-5 w-5 mr-2"
                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/768px-Google_%22G%22_logo.svg.png"
                            alt="Google">
                        <span>Hubungkan Akun Google</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
