<x-layout>
    <div class="bg-gray-100">
        <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-9 px-6 text-center">
        </section>

        <section class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-10">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl px-10 py-10 transition-all duration-300">
                <a href="{{ route('Beranda') }}" class="flex items-center text-gray-500 hover:underline mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Beranda
                </a>

                <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Edit Profil</h2>

                <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-8">
                    @csrf

                    {{-- Avatar --}}
                    <div x-data="{ preview: '{{ $user->foto ? asset('storage/' . $user->foto) : '' }}' }" class="flex flex-col items-center mb-8">
                        <div class="relative w-28 h-28 mb-3">
                            <label class="cursor-pointer block w-full h-full">
                                <template x-if="preview">
                                    <img :src="preview" alt="Foto Profil"
                                        class="w-28 h-28 rounded-full object-cover border border-gray-300 shadow-sm transition hover:scale-105" />
                                </template>
                                <input type="file" name="foto" accept="image/*"
                                    @change="preview = URL.createObjectURL($event.target.files[0])"
                                    class="absolute inset-0 w-full h-full opacity-0 rounded-full" />
                                <div class="absolute bottom-0 right-0 bg-blue-600 p-1 rounded-full shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 20h4L18.5 9.5a2.828 2.828 0 1 0-4-4L4 16v4m9.5-13.5l4 4" />
                                    </svg>
                                </div>
                            </label>
                        </div>
                        <p class="text-lg font-semibold">{{ $user->penduduk->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $user->penduduk->pekerjaan }}</p>
                    </div>

                    {{-- Grid Fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:border-blue-500 transition bg-white">
                        </div>

                        {{-- Username --}}
                        <div x-data="{ usernameValid: '{{ $user->nama }}'.length > 2 }">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <div
                                class="flex items-center border border-gray-300 px-3 py-2 bg-white rounded-md focus-within:border-blue-500 transition">
                                <span class="text-gray-400 mr-1">@</span>
                                <input type="text" name="nama" value="{{ old('username', $user->nama) }}"
                                    class="w-full focus:outline-none bg-transparent"
                                    @input="usernameValid = $event.target.value.length > 2">
                                <template x-if="usernameValid">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div x-data="{ editing: false, password: '', confirm: '', valid: false, match: true, show: false }" class="space-y-2">
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
                                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.574-4.337M6.7 6.7A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.978 9.978 0 01-4.292 5.03M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Validasi password -->
                                <p class="text-xs mt-1 flex items-center gap-1" x-show="password.length > 0"
                                    :class="valid ? 'text-green-500' : 'text-red-500'">
                                    <svg x-show="valid" xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <svg x-show="!valid" xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span
                                        x-text="valid ? 'Password memenuhi syarat' : 'Password minimal 8 karakter'"></span>
                                </p>

                                <!-- Konfirmasi password -->
                                <div class="relative">
                                    <input :type="show ? 'text' : 'password'" name="password_confirmation"
                                        x-model="confirm" @input="match = password === confirm"
                                        class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:border-blue-500 transition bg-white"
                                        placeholder="Konfirmasi password">

                                    <!-- SVG mata -->
                                    <button type="button" @click="show = !show"
                                        class="absolute top-2.5 right-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.574-4.337M6.7 6.7A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.978 9.978 0 01-4.292 5.03M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Validasi konfirmasi -->
                                <p class="text-xs mt-1 flex items-center gap-1" x-show="confirm.length > 0"
                                    :class="match ? 'text-green-500' : 'text-red-500'">
                                    <svg x-show="match" xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <svg x-show="!match" xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span x-text="match ? 'Password sesuai' : 'Password harus sesuai'"></span>
                                </p>

                                <button type="button"
                                    @click="editing = false; show = false; valid = false; password=''; confirm='';"
                                    class="text-xs text-gray-500 hover:underline">
                                    Batal
                                </button>
                            </div>
                        </template>

                        <!-- Mode Non-Edit -->
                        <template x-if="!editing">
                            <div class="flex justify-between items-center">
                                <p class="text-gray-500 italic">••••••••</p>
                                <button type="button" @click="editing = true"
                                    class="text-sm text-blue-600 hover:underline focus:outline-none">
                                    Edit Password
                                </button>
                            </div>
                        </template>
                    </div>

                    {{-- Submit --}}
                    <div class="text-center pt-6">
                        <x-button type="submit">
                            Save Changes
                        </x-button>
                    </div>
                </form>
                <div class="mt-10 border-t pt-6">
                    <div>
                        <h3 class="text-3xl font-semibold text-gray-800">Data Diri</h3>
                        <p class="text-sm text-gray-600">Jika ada kesalahan, silakan hubungi admin untuk bantuan lebih
                            lanjut.</p>
                    </div>
                    <div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">NIK: {{ $user->penduduk->nik }}</p>
                            <p class="text-sm text-gray-600">Nama: {{ $user->penduduk->nama }}</p>
                            <p class="text-sm text-gray-600">Tempat Lahir: {{ $user->penduduk->tempat_lahir }}</p>
                            <p class="text-sm text-gray-600">Tanggal Lahir: {{ $user->penduduk->tanggal_lahir }}</p>
                            <p class="text-sm text-gray-600">Jenis Kelamin: {{ $user->penduduk->jenis_kelamin }}</p>
                            <p class="text-sm text-gray-600">Pekerjaan: {{ $user->penduduk->pekerjaan }}</p>
                        </div>

                    </div>

                </div>
            </div>
            <x-modalstatus />
        </section>
    </div>
</x-layout>
