<nav x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 bg-gradient-to-r from-[#0E1524] via-[#1A2238] to-[#0E1524] py-4 px-6 flex items-center justify-between shadow-md">
    <!-- Logo -->
    <div class="flex items-center">
        <img src="img/LogoHST.png" alt="Logo" class="h-10">
    </div>

    <!-- Desktop Menu -->
    <div class="hidden md:flex items-center space-x-8 text-white font-semibold text-sm">
        <x-nav-link href="/" :active="request()->is('/')">BERANDA</x-nav-link>
    
        <x-nav-link href="/profil-desa" :active="request()->is('profil-desa')">PROFIL DESA</x-nav-link>
    
        <x-nav-link
            :dropdown="true"
            :active="request()->is('layanan/*')"
            label="LAYANAN ONLINE"
            :items="[
                ['label' => 'Administrasi', 'href' => '/layanan/administrasi'],
                ['label' => 'Pengaduan', 'href' => '/layanan/pengaduan']
            ]"
        />
    
        <x-nav-link
            :dropdown="true"
            :active="request()->is('informasi/*')"
            label="INFORMASI"
            :items="[
                ['label' => 'Pengumuman', 'href' => '/informasi/pengumuman'],
                ['label' => 'Berita Desa', 'href' => '/informasi/berita'],
                ['label' => 'APBDes', 'href' => '/informasi/apbdes'],
                ['label' => 'Kependudukan', 'href' => '/informasi/kependudukan'],
            ]"
        />
    </div>
    
    <!-- Mobile Hamburger -->
    <div class="md:hidden flex items-center">
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white focus:outline-none">
            <svg x-show="!mobileMenuOpen" x-transition class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="mobileMenuOpen" x-transition class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Login Button -->
    <div class="hidden md:block">
        <a href="/login" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded-lg transition duration-300 shadow hover:shadow-lg">
            LOGIN
        </a>
    </div>
</nav>

<!-- Mobile Menu -->
<div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="md:hidden bg-gradient-to-r from-[#0E1524] via-[#1A2238] to-[#0E1524] text-white font-semibold text-sm space-y-4 px-6 py-4">
    <a href="/" class="block hover:text-yellow-300 hover:underline underline-offset-4 transition duration-300">BERANDA</a>
    <a href="/profil-desa" class="block hover:text-yellow-300 hover:underline underline-offset-4 transition duration-300">PROFIL DESA</a>
    <a href="/layanan/administrasi" class="block hover:text-yellow-300 hover:underline underline-offset-4 transition duration-300">Administrasi</a>
    <a href="/layanan/pengaduan" class="block hover:text-yellow-300 hover:underline underline-offset-4 transition duration-300">Pengaduan</a>
    <a href="/informasi/berita-desa" class="block hover:text-yellow-300 hover:underline underline-offset-4 transition duration-300">Berita Desa</a>
    <a href="/informasi/apbdes" class="block hover:text-yellow-300 hover:underline underline-offset-4 transition duration-300">APBDes</a>
    <a href="/informasi/kependudukan" class="block hover:text-yellow-300 hover:underline underline-offset-4 transition duration-300">Kependudukan</a>
    <a href="/login" class="block bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded-lg transition duration-300 text-center">
        LOGIN
    </a>
</div>

<!-- Bottom Navbar (Mobile Only) -->
<div class="fixed bottom-0 left-0 right-0 bg-gradient-to-r from-[#0E1524] via-[#1A2238] to-[#0E1524] text-white flex justify-around items-center py-2 md:hidden z-50 border-t border-gray-700">
    <a href="/" class="flex flex-col items-center text-xs hover:text-yellow-300">
        <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9v8a2 2 0 01-2 2h-4a2 2 0 01-2-2v-6H9v6a2 2 0 01-2 2H3z" />
        </svg>
        Beranda
    </a>
    <a href="/layanan/administrasi" class="flex flex-col items-center text-xs hover:text-yellow-300">
        <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6M9 12h13M9 7h13M9 17h13" />
        </svg>
        Layanan
    </a>
    <a href="/informasi/berita-desa" class="flex flex-col items-center text-xs hover:text-yellow-300">
        <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 3H5a2 2 0 00-2 2v14l7-3 7 3V5a2 2 0 00-2-2z" />
        </svg>
        Informasi
    </a>
    <a href="/login" class="flex flex-col items-center text-xs hover:text-yellow-300">
        <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17l5-5m0 0l-5-5m5 5H10a4 4 0 00-4 4v4" />
        </svg>
        Login
    </a>
</div>
