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
                ['label' => 'Administrasi', 'href' => route('administrasi')],
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
                    <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('default-avatar.png') }}"
                        class="w-8 h-8 rounded-full object-cover" alt="Foto Profil">
                    <span class="font-medium">{{ Auth::user()->username }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-up transition-transform duration-300" :class="{ '-rotate-180': open }">
                        <path d="m18 15-6-6-6 6" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-transition
                    class="absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-50 p-4">

                    <!-- Profil Detail -->
                    <div class="flex flex-col items-center border-b border-gray-200 pb-4 mb-4">
                        <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('default-avatar.png') }}"
                            class="w-20 h-20 rounded-full object-cover mb-3" alt="Foto Profil Besar">
                        <h3 class="text-lg font-semibold">{{ Auth::user()->username }}</h3>
                        <p class="text-sm text-gray-600 truncate max-w-full">{{ Auth::user()->email }}</p>
                    </div>

                    <!-- Tombol Edit Profil -->
                    <a href="{{ route('profil.edit') }}"
                        class="block w-full text-center bg-blue-600 text-white font-semibold py-2 rounded-full hover:bg-blue-700 hover:scale-105 transition">
                        Edit Profil
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="/logout" class="mt-3">
                        @csrf
                        <button type="submit"
                            class="w-full text-center text-red-600 border border-red-600 font-semibold py-2 rounded-full hover:bg-red-600 hover:text-white hover:scale-105 transition">
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
            <a href="/login" class="block bg-yellow-400 hover:bg-yellow-500 text-black text-center py-2 rounded">Login</a>
        @endauth
    </div>
</nav>
