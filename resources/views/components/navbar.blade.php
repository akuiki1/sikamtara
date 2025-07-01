<nav x-data="{
    mobileMenuOpen: false,
    scrolled: false,
    onBeranda: window.location.pathname === '/',
}" x-init="window.addEventListener('scroll', () => {
    scrolled = window.scrollY > 50;
});"
    :class="(onBeranda && !scrolled) ?
    'bg-transparent text-white' :
    'bg-gradient-to-r from-blue-700/90 to-blue-900/90 backdrop-blur shadow-md text-gray-900'"
    class="fixed top-0 w-full z-50 transition-all duration-500 ease-in-out px-6 py-4">


    <div class="flex justify-between items-center">
        <!-- Logo -->
        <a href="/">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/LogoHST.png') }}" alt="Logo" class="h-10">
                <span class="font-semibold text-lg hidden md:inline text-white">SIKAMTARA</span>
            </div>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-6 font-semibold text-sm">
            <x-nav-link href="/" :active="request()->is('/')">BERANDA</x-nav-link>

            <x-nav-link href="/profil-desa" :active="request()->is('profil-desa')">PROFIL DESA</x-nav-link>

            <x-nav-link :dropdown="true" :active="request()->is('user/layanan/*') ||
                request()->routeIs('administrasi') ||
                request()->routeIs('pengaduan')" label="LAYANAN ONLINE" :items="[
                ['label' => 'Administrasi', 'href' => route('administrasi')],
                ['label' => 'Pengaduan', 'href' => route('pengaduan')],
            ]" />

            <x-nav-link :dropdown="true" :active="request()->is('informasi/*') || request()->routeIs('user.keuangan')" label="INFORMASI" :items="[
                ['label' => 'Pengumuman', 'href' => route('public.pengumuman')],
                ['label' => 'Berita Desa', 'href' => route('berita.index')],
                ['label' => 'APBDes', 'href' => route('user.keuangan')],
                ['label' => 'Kependudukan', 'href' => route('user.kependudukan')],
            ]" />
        </div>


        <!-- Auth Button -->
        @auth

            {{-- dekstop --}}
            <div x-data="{ open: false }" class="relative hidden md:block">
                <!-- Tombol Avatar/Profile -->
                <button @click="open = !open" @click.away="open = false"
                    class="flex items-center space-x-2 px-3 py-2 rounded-lg text-white focus:outline-none">
                    <img src="{{ optional(Auth::user())->foto ? asset('storage/' . Auth::user()->foto) : asset('default-avatar.png') }}"
                        class="w-8 h-8 rounded-full object-cover" alt="Foto Profil">
                    <span class="font-medium">{{ Auth::user()->nama }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-up transition-transform duration-300" :class="{ '-rotate-180': open }">
                        <path d="m18 15-6-6-6 6" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-transition
                    class="absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-50 p-4">

                    <!-- Profil Ringkas -->
                    <div class="flex flex-col border-b border-gray-200 mb-4 pb-4 relative">
                        <!-- Foto profil -->
                        <div class="flex justify-center mb-2">
                            <img src="{{ optional(Auth::user())->foto ? asset('storage/' . Auth::user()->foto) : asset('default-avatar.png') }}"
                                class="w-20 h-20 rounded-full object-cover" alt="Foto Profil">
                        </div>

                        <!-- Nama dan Email -->
                        <h3 class="text-lg font-semibold text-gray-800 text-center">{{ Auth::user()->nama }}</h3>
                        <p class="text-sm text-gray-600 text-center truncate">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="mb-3">
                        <!-- Edit Profil -->
                        <a href="{{ route('profil.edit') }}"
                            class="flex items-center gap-2 text-sm w-full text-left py-2 px-3 text-gray-700 hover:bg-gray-100 rounded-xl transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0-8 0M6 21v-2a4 4 0 0 1 4-4h3.5m4.92.61a2.1 2.1 0 0 1 2.97 2.97L18 22h-3v-3l3.42-3.39z" />
                            </svg>

                            Edit Profil
                        </a>
                        <!-- Verifikasi Akun -->
                        <a href="{{ route('profil.edit') }}"
                            class="flex items-center gap-2 text-sm w-full text-left py-2 px-3 text-gray-700 hover:bg-gray-100 rounded-xl transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path
                                        d="M10.521 2.624a2 2 0 0 1 2.958 0l1.02 1.12a2 2 0 0 0 1.572.651l1.513-.07a2 2 0 0 1 2.092 2.09l-.071 1.514a2 2 0 0 0 .651 1.572l1.12 1.02a2 2 0 0 1 0 2.958l-1.12 1.02a2 2 0 0 0-.651 1.572l.07 1.513a2 2 0 0 1-2.09 2.092l-1.514-.071a2 2 0 0 0-1.572.651l-1.02 1.12a2 2 0 0 1-2.958 0l-1.02-1.12a2 2 0 0 0-1.572-.651l-1.513.07a2 2 0 0 1-2.092-2.09l.071-1.514a2 2 0 0 0-.651-1.572l-1.12-1.02a2 2 0 0 1 0-2.958l1.12-1.02a2 2 0 0 0 .651-1.572l-.07-1.513a2 2 0 0 1 2.09-2.092l1.514.071a2 2 0 0 0 1.572-.651l1.02-1.12Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 12l2 2l4-4" />
                                </g>
                            </svg>
                            Verifikasi Akun
                        </a>
                    </div>
                    <!-- Link Riwayat Pengajuan -->
                    <a href="{{ route('administrasi') }}#riwayatLayanan"
                        class="flex items-center gap-2 text-sm w-full text-left py-2 px-3 text-gray-700 hover:bg-gray-100 rounded-xl transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 15 15">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M3 2.5a.5.5 0 0 1 .5-.5h5.586a.5.5 0 0 1 .353.146l2.415 2.415a.5.5 0 0 1 .146.353V12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-10ZM3.5 1A1.5 1.5 0 0 0 2 2.5v10A1.5 1.5 0 0 0 3.5 14h8a1.5 1.5 0 0 0 1.5-1.5V4.914a1.5 1.5 0 0 0-.44-1.06l-2.414-2.415A1.5 1.5 0 0 0 9.086 1H3.5Zm1 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1h-6Zm0 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1h-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        Riwayat Administrasi
                    </a>


                    <!-- Link Riwayat Pengaduan -->
                    <a href="{{ route('pengaduan') }}#riwayatPengaduan"
                        class="flex items-center gap-2 text-sm w-full text-left py-2 px-3 text-gray-700 hover:bg-gray-100 rounded-xl transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2zM8 10h.01M12 10h.01M16 10h.01" />
                        </svg>

                        Riwayat Pengaduan Online
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="/logout" class="mt-3">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 text-sm w-full text-left py-2 px-3 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-xl transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M5.615 20q-.69 0-1.152-.462Q4 19.075 4 18.385V5.615q0-.69.463-1.152Q4.925 4 5.615 4h6.404v1H5.615q-.23 0-.423.192Q5 5.385 5 5.615v12.77q0 .23.192.423q.193.192.423.192h6.404v1H5.615Zm10.847-4.462l-.702-.719l2.319-2.319H9.192v-1h8.887l-2.32-2.32l.703-.718L20 12l-3.538 3.538Z" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tombol Avatar untuk Mobile -->
            <div class="flex gap-8 md:hidden">
                <div x-data="{ openMobileProfile: false }" class="md:hidden relative ml-4">
                    <button @click="openMobileProfile = !openMobileProfile" @click.away="openMobileProfile = false"
                        class="flex items-center gap-2 text-white focus:outline-none">
                        <img src="{{ optional(Auth::user())->foto ? asset('storage/' . Auth::user()->foto) : asset('default-avatar.png') }}"
                            class="w-8 h-8 rounded-full object-cover" alt="Foto Profil">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevron-up transition-transform duration-300"
                            :class="{ '-rotate-180': openMobileProfile }">
                            <path d="m18 15-6-6-6 6" />
                        </svg>
                    </button>

                    <!-- Dropdown Profil Mobile -->
                    <div x-show="openMobileProfile" x-transition
                        class="absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-50 p-4">
                        <div class="text-center border-b pb-3 mb-3">
                            <img src="{{ optional(Auth::user())->foto ? asset('storage/' . Auth::user()->foto) : asset('default-avatar.png') }}"
                                class="w-16 h-16 rounded-full mx-auto object-cover" alt="Foto Profil">
                            <h3 class="font-semibold mt-2 text-gray-800 ">{{ Auth::user()->nama }}</h3>
                            <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="mb-3">
                            <!-- Edit Profil -->
                            <a href="{{ route('profil.edit') }}"
                                class="flex items-center gap-2 text-sm w-full text-left py-2 px-3 text-gray-700 hover:bg-gray-100 rounded-xl transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                    viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0-8 0M6 21v-2a4 4 0 0 1 4-4h3.5m4.92.61a2.1 2.1 0 0 1 2.97 2.97L18 22h-3v-3l3.42-3.39z" />
                                </svg>

                                Edit Profil
                            </a>
                            <!-- Verifikasi Akun -->
                            <a href="{{ route('profil.edit') }}"
                                class="flex items-center gap-2 text-sm w-full text-left py-2 px-3 text-gray-700 hover:bg-gray-100 rounded-xl transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                    viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path
                                            d="M10.521 2.624a2 2 0 0 1 2.958 0l1.02 1.12a2 2 0 0 0 1.572.651l1.513-.07a2 2 0 0 1 2.092 2.09l-.071 1.514a2 2 0 0 0 .651 1.572l1.12 1.02a2 2 0 0 1 0 2.958l-1.12 1.02a2 2 0 0 0-.651 1.572l.07 1.513a2 2 0 0 1-2.09 2.092l-1.514-.071a2 2 0 0 0-1.572.651l-1.02 1.12a2 2 0 0 1-2.958 0l-1.02-1.12a2 2 0 0 0-1.572-.651l-1.513.07a2 2 0 0 1-2.092-2.09l.071-1.514a2 2 0 0 0-.651-1.572l-1.12-1.02a2 2 0 0 1 0-2.958l1.12-1.02a2 2 0 0 0 .651-1.572l-.07-1.513a2 2 0 0 1 2.09-2.092l1.514.071a2 2 0 0 0 1.572-.651l1.02-1.12Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 12l2 2l4-4" />
                                    </g>
                                </svg>
                                Verifikasi Akun
                            </a>
                        </div>
                        <!-- Link Riwayat Pengajuan -->
                        <a href="{{ route('administrasi') }}#riwayatLayanan"
                            class="flex items-center gap-2 text-sm w-full text-left py-2 px-3 text-gray-700 hover:bg-gray-100 rounded-xl transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 15 15">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M3 2.5a.5.5 0 0 1 .5-.5h5.586a.5.5 0 0 1 .353.146l2.415 2.415a.5.5 0 0 1 .146.353V12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-10ZM3.5 1A1.5 1.5 0 0 0 2 2.5v10A1.5 1.5 0 0 0 3.5 14h8a1.5 1.5 0 0 0 1.5-1.5V4.914a1.5 1.5 0 0 0-.44-1.06l-2.414-2.415A1.5 1.5 0 0 0 9.086 1H3.5Zm1 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1h-6Zm0 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1h-6Z"
                                    clip-rule="evenodd" />
                            </svg>
                            Riwayat Administrasi
                        </a>


                        <!-- Link Riwayat Pengaduan -->
                        <a href="{{ route('pengaduan') }}#riwayatPengaduan"
                            class="flex items-center gap-2 text-sm w-full text-left py-2 px-3 text-gray-700 hover:bg-gray-100 rounded-xl transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2zM8 10h.01M12 10h.01M16 10h.01" />
                            </svg>

                            Riwayat Pengaduan Online
                        </a>

                        <!-- Logout -->
                        <form method="POST" action="/logout" class="mt-3">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 text-sm w-full text-left py-2 px-3 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-xl transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M5.615 20q-.69 0-1.152-.462Q4 19.075 4 18.385V5.615q0-.69.463-1.152Q4.925 4 5.615 4h6.404v1H5.615q-.23 0-.423.192Q5 5.385 5 5.615v12.77q0 .23.192.423q.193.192.423.192h6.404v1H5.615Zm10.847-4.462l-.702-.719l2.319-2.319H9.192v-1h8.887l-2.32-2.32l.703-.718L20 12l-3.538 3.538Z" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Mobile -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-xl focus:outline-none text-white">
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @else
            <!-- Login Button -->
            <form method="GET" action="/login" class="hidden md:block">
                <x-button variant="warning" size="lg"
                    class="bg-yellow-300 hover:bg-yellow-400 text-black font-semibold px-4 py-2 shadow-lg hover:scale-105">
                    Login
                </x-button>
            </form>

            <!-- Mobile -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-xl focus:outline-none text-white">
                <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endauth
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition
        class="absolute right-4 top-14 z-50 md:hidden bg-white text-gray-800 rounded shadow divide-y divide-gray-200 transition w-fit">

        <!-- NAVIGASI UTAMA -->
        <div class="py-3 px-4 space-y-2 text-sm">
            <a href="/" class="flex items-center gap-2 hover:bg-gray-100 p-2 rounded-xl transition">
                <!-- Home -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.5"
                        d="M15.29 20.663h3.017a2.194 2.194 0 0 0 2.193-2.194v-6.454a3.3 3.3 0 0 0-1.13-2.48l-5.93-5.166a2.194 2.194 0 0 0-2.88 0L4.63 9.534a3.3 3.3 0 0 0-1.13 2.481v6.454c0 1.212.982 2.194 2.194 2.194h3.29m6.306 0v-6.581c0-.908-.736-1.645-1.645-1.645H10.63c-.909 0-1.645.737-1.645 1.645v6.581m6.306 0H8.984" />
                </svg>
                Beranda
            </a>

            <a href="{{ route('public.profil.desa') }}"
                class="flex items-center gap-2 hover:bg-gray-100 p-2 rounded-xl transition">
                <!-- Info -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-width="2" />
                        <path stroke-width="3" d="M12 8h.01v.01H12z" />
                        <path stroke-linecap="round" stroke-width="2" d="M12 12v4" />
                    </g>
                </svg>
                Profil Desa
            </a>

            <a href="{{ route('administrasi') }}"
                class="flex items-center gap-2 hover:bg-gray-100 p-2 rounded-xl transition">
                <!-- Document -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m-7.5 4.5h9A1.5 1.5 0 0020 19.5v-15A1.5 1.5 0 0018.5 3h-13A1.5 1.5 0 004 4.5v15A1.5 1.5 0 005.5 21z" />
                </svg>
                Administrasi
            </a>

            <a href="{{ route('pengaduan') }}"
                class="flex items-center gap-2 hover:bg-gray-100 p-2 rounded-xl transition">
                <!-- Chat -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M8.625 9.75a.375.375 0 1 1-.75 0a.375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0a.375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0a.375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227c1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332a48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                </svg>
                Pengaduan
            </a>

            <a href="{{ route('public.pengumuman') }}"
                class="flex items-center gap-2 hover:bg-gray-100 p-2 rounded-xl transition">
                <!-- Newspaper -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 20 20">
                    <g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd">
                        <path
                            d="M6.4 4.882v4.436l7.6 2.073V2.809L6.4 4.882Zm-1 4.436a1 1 0 0 0 .737.965l7.6 2.072A1 1 0 0 0 15 11.391V2.809a1 1 0 0 0-1.263-.965l-7.6 2.073a1 1 0 0 0-.737.965v4.436Z" />
                        <path
                            d="M3.456 9.3H5.5V4.9H3.453a3.422 3.422 0 0 0 .003 4.4Zm2.044 1a1 1 0 0 0 1-1V4.9a1 1 0 0 0-1-1H3.253a.55.55 0 0 0-.4.172c-1.602 1.691-1.595 4.353-.002 6.052a.555.555 0 0 0 .405.176H5.5Z" />
                        <path
                            d="m7.269 10.87l-2.51-.28l-.978 3.91h2.636l.852-3.63Zm-2.4-1.273a1 1 0 0 0-1.081.75l-.977 3.91a1 1 0 0 0 .97 1.243h2.636a1 1 0 0 0 .974-.772l.852-3.63a1 1 0 0 0-.864-1.223l-2.51-.278Zm13.747-6.374a.5.5 0 0 1-.139.693l-1.5 1a.5.5 0 1 1-.554-.832l1.5-1a.5.5 0 0 1 .693.139ZM16.2 7.1a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1h-1.5a.5.5 0 0 1-.5-.5Zm.117 2.23a.5.5 0 0 1 .705-.06l1.38 1.159a.5.5 0 0 1-.643.765l-1.38-1.16a.5.5 0 0 1-.062-.704Z" />
                    </g>
                </svg>
                Pengumuman Desa
            </a>

            <a href="{{ route('berita.index') }}"
                class="flex items-center gap-2 hover:bg-gray-100 p-2 rounded-xl transition">
                <!-- Newspaper -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                </svg>
                Berita Desa
            </a>

            <a href="{{ route('user.keuangan') }}"
                class="flex items-center gap-2 hover:bg-gray-100 p-2 rounded-xl transition">
                <!-- Chart -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M4.5 20.25a.76.76 0 0 1-.75-.75v-15a.75.75 0 0 1 1.5 0v15a.76.76 0 0 1-.75.75Z" />
                    <path fill="currentColor"
                        d="M19.5 20.25h-15a.75.75 0 0 1 0-1.5h15a.75.75 0 0 1 0 1.5ZM8 16.75a.76.76 0 0 1-.75-.75v-4a.75.75 0 0 1 1.5 0v4a.76.76 0 0 1-.75.75Zm3.5 0a.76.76 0 0 1-.75-.75V8a.75.75 0 0 1 1.5 0v8a.76.76 0 0 1-.75.75Zm3.5 0a.76.76 0 0 1-.75-.75v-4a.75.75 0 0 1 1.5 0v4a.76.76 0 0 1-.75.75Zm3.5 0a.76.76 0 0 1-.75-.75V8a.75.75 0 0 1 1.5 0v8a.76.76 0 0 1-.75.75Z" />
                </svg>
                APBDes
            </a>

            <a href="{{ route('user.kependudukan') }}"
                class="flex items-center gap-2 hover:bg-gray-100 p-2 rounded-xl transition">
                <!-- Users -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 640 512">
                    <path fill="currentColor"
                        d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6c40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32S208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z" />
                </svg>
                Kependudukan
            </a>
        </div>

        <!-- MENU USER -->
        <div class="py-3 px-4">
            @auth
                <form method="POST" action="/logout">
                    @csrf
                    <button class="flex items-center gap-2 w-full text-sm text-red-600 hover:text-red-800 transition">
                        <!-- Icon Logout -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 16l4-4m0 0l-4-4m4 4H9m4 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            @else
                <a href="/login"
                    class="flex items-center gap-2 text-sm bg-yellow-400 hover:bg-yellow-500 text-black py-2 px-4 rounded justify-center transition">
                    <!-- Icon Login -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 12H3m0 0l4-4m-4 4l4 4m5-4V4a1 1 0 011-1h6a1 1 0 011 1v16a1 1 0 01-1 1h-6a1 1 0 01-1-1v-8" />
                    </svg>
                    Login
                </a>
            @endauth
        </div>
    </div>
</nav>
