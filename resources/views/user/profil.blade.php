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

                <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Edit Profil</h2>
                <div class="flex justify-center">
                    @if (Auth::user()->status_verifikasi === 'Belum Terverifikasi')
                        <div
                            class="w-fit px-4 py-2 bg-yellow-100 text-yellow-700 rounded-xl text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 1024 1024">
                                <path fill="currentColor"
                                    d="M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896zm0 832a384 384 0 0 0 0-768a384 384 0 0 0 0 768zm48-176a48 48 0 1 1-96 0a48 48 0 0 1 96 0zm-48-464a32 32 0 0 1 32 32v288a32 32 0 0 1-64 0V288a32 32 0 0 1 32-32z" />
                            </svg>
                            Akun kamu belum terverifikasi.<a href="{{ route('profil.verifikasi') }}"
                                class="hover:underline font-semibold">Verifikasi sekarang</a>
                        </div>
                    @elseif(Auth::user()->status_verifikasi === 'Menunggu Verifikasi')
                        <div
                            class="w-fit px-4 py-2 bg-yellow-100 text-yellow-700 rounded-xl text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 1024 1024">
                                <path fill="currentColor"
                                    d="M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896zm0 832a384 384 0 0 0 0-768a384 384 0 0 0 0 768zm48-176a48 48 0 1 1-96 0a48 48 0 0 1 96 0zm-48-464a32 32 0 0 1 32 32v288a32 32 0 0 1-64 0V288a32 32 0 0 1 32-32z" />
                            </svg>
                            Verifikasi Akun kamu sedang kami tinjau.<a href="{{ route('profil.verifikasi') }}"
                                class="hover:underline font-semibold">Lihat</a>
                        </div>
                    @endif
                </div>

                <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    {{-- Avatar --}}
                    <div x-data="{ preview: '{{ optional(Auth::user())->foto ? asset('storage/' . Auth::user()->foto) : asset('img/default-avatar.jpg') }}' }" class="flex flex-col items-center mb-8">
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
                        <p class="text-lg font-semibold flex items-center">
                            <span class="relative inline-block">
                                {{ $user->penduduk->nama }}

                                @if ($user->status_verifikasi === 'Terverifikasi')
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="absolute -top-1 -right-4 h-4 w-4 text-blue-600 bg-white rounded-full"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="m8.6 22.5l-1.9-3.2l-3.6-.8l.35-3.7L1 12l2.45-2.8l-.35-3.7l3.6-.8l1.9-3.2L12 2.95l3.4-1.45l1.9 3.2l3.6.8l-.35 3.7L23 12l-2.45 2.8l.35 3.7l-3.6.8l-1.9 3.2l-3.4-1.45l-3.4 1.45Zm2.35-6.95L16.6 9.9l-1.4-1.45l-4.25 4.25l-2.15-2.1L7.4 12l3.55 3.55Z" />
                                    </svg>
                                @endif
                            </span>
                        </p>
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
                    <div x-data="{ editing: false, password: '', confirm: '', confirmshow: false, valid: false, match: true, show: false }" class="space-y-2">
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
                    <div class="text-center">
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
