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
                ['label' => 'Pengumuman', 'href' => '/informasi/pengumuman'],
                ['label' => 'Berita Desa', 'href' => '/informasi/berita'],
                ['label' => 'APBDes', 'href' => route('user.keuangan')],
                ['label' => 'Kependudukan', 'href' => '/informasi/kependudukan'],
            ]" />
        </div>


        <!-- Auth Button -->
        @auth
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
        @else
            <!-- Login Button -->
            <form method="GET" action="/login" class="hidden md:block">
                <x-button variant="warning" size="lg"
                    class="bg-yellow-300 hover:bg-yellow-400 text-black font-semibold px-4 py-2 shadow-lg hover:scale-105">
                    Login
                </x-button>
            </form>
        @endauth




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

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition
        class="md:hidden mt-4 bg-white/90 text-black font-semibold space-y-4 py-4 px-4 rounded shadow">
        <a href="/" class="block hover:text-yellow-500 transition">Beranda</a>
        <a href="/profil-desa" class="block hover:text-yellow-500 transition">Profil Desa</a>
        <a href="{{ route('administrasi') }}" class="block hover:text-yellow-500 transition">Administrasi</a>
        <a href="/layanan/pengaduan" class="block hover:text-yellow-500 transition">Pengaduan</a>
        <a href="/informasi/berita-desa" class="block hover:text-yellow-500 transition">Berita Desa</a>
        <a href="/informasi/apbdes" class="block hover:text-yellow-500 transition">APBDes</a>
        <a href="/informasi/kependudukan" class="block hover:text-yellow-500 transition">Kependudukan</a>
        @auth
            <form method="POST" action="/logout">
                @csrf
                <button class="block w-full bg-red-500 text-white py-2 rounded">Logout</button>
            </form>
        @else
            <a href="/login"
                class="block bg-yellow-400 hover:bg-yellow-500 text-black text-center py-2 rounded">Login</a>
        @endauth
    </div>
</nav>
