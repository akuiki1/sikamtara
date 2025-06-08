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
    class="fixed top-0 w-full z-50 transition-all duration-500 ease-in-out px-6 py-3">


    <div class="flex justify-between items-center">
        <!-- Logo -->
        <a href="/">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/LogoHST.png') }}" alt="Logo" class="h-14">
                <span class="font-semibold text-lg hidden md:inline text-white">SIKAMTARA</span>
            </div>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-6 font-semibold text-sm">
            <x-nav-link href="/" :active="request()->is('/')">BERANDA</x-nav-link>
            <x-nav-link href="/profil-desa" :active="request()->is('profil-desa')">PROFIL DESA</x-nav-link>

            <x-nav-link :dropdown="true" :active="request()->is('layanan/*')" label="LAYANAN ONLINE" :items="[
                ['label' => 'Administrasi', 'href' => '/layanan/administrasi'],
                ['label' => 'Pengaduan', 'href' => '/layanan/pengaduan'],
            ]" />

            <x-nav-link :dropdown="true" :active="request()->is('informasi/*')" label="INFORMASI" :items="[
                ['label' => 'Pengumuman', 'href' => '/informasi/pengumuman'],
                ['label' => 'Berita Desa', 'href' => '/informasi/berita'],
                ['label' => 'APBDes', 'href' => '/informasi/apbdes'],
                ['label' => 'Kependudukan', 'href' => '/informasi/kependudukan'],
            ]" />
        </div>

        <!-- Auth Button -->
        @auth
            <div x-data="{ open: false }" class="relative hidden md:block">
                <!-- Tombol Avatar/Profile -->
                <button @click="open = !open" @click.away="open = false"
                    class="flex items-center space-x-2 px-3 py-2 rounded-lg shadow text-white focus:outline-none hover:shadow">
                    <img src="{{ Auth::user()->foto }}" class="w-8 h-8 rounded-full">
                    <span class="font-medium">{{ Auth::user()->username }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-up-icon lucide-chevron-up transition-transform duration-300"
                        :class="{ '-rotate-180': open }">
                        <path d="m18 15-6-6-6 6" />
                    </svg>
                </button>


                <!-- Dropdown Menu -->
                <div x-show="open" x-transition
                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                    <!-- Edit Profil -->
                    <a href="/profile/edit" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        Edit Profil
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 hover:text-red-800">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Login Button -->
            <form method="GET" action="/login" class="hidden md:block">
                <x-button variant="warning" size="lg"
                    class="bg-yellow-300 hover:bg-yellow-400 text-black font-semibold px-4 py-2 shadow-lg">
                    Login
                </x-button>
            </form>
        @endauth


        <!-- Mobile Toggle -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-xl focus:outline-none">
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
        <a href="/layanan/administrasi" class="block hover:text-yellow-500 transition">Administrasi</a>
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
            <a href="/login" class="block bg-yellow-400 hover:bg-yellow-500 text-black text-center py-2 rounded">Login</a>
        @endauth
    </div>
</nav>
