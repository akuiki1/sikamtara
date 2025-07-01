<header class="bg-gray-100 px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between shadow-sm">
    <!-- Kiri: Sapaan dan Judul -->
    <div class="px-0 py-0 text-gray-400">
        {{-- <p class="text-sm text-gray-500">Selamat Datang, Admin</p> --}}
        <div class="text-xs font-regular">Halaman</div>
        <div class="text-lg font-regular">{{ $slot }}</div>
    </div>

    <!-- Kanan: Ikon -->
    <!-- Tengah: Search Bar -->
    {{-- <div class="flex-1 max-w-lg mx-6 hidden md:block" x-data="{ query: '', results: [], dummyData: [
        'Beranda',
        'Sejarah Desa',
        'Demografi',
        'Visi & Misi',
        'Struktur Pemerintahan',
        'Infrastruktur Desa',
        'Wilayah Administrasi',
        'Layanan Administrasi',
        'Pengaduan Masyarakat',
        'Berita Desa',
        'Pengumuman',
        'Profil',
        'Kelola Akun Warga',
        'Kependudukan',
        'APBDes',
        'Logout'
      ]
      , showResults: false }" @click.away="showResults = false">
        <div class="relative">
            <input
                type="text"
                placeholder="Cari data warga, surat, info desa..."
                class="w-full pl-11 pr-4 py-2 rounded-full bg-gray-100 focus:bg-white border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm text-gray-700 shadow-sm"
                x-model="query"
                @input="
                    results = dummyData.filter(item => item.toLowerCase().includes(query.toLowerCase()));
                    showResults = query.length > 0 && results.length > 0;
                "
            />
            <div class="absolute inset-y-0 left-4 flex items-center text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </div>
    
            <!-- Hasil pencarian -->
            <div x-show="showResults" class="absolute z-50 w-full bg-white mt-2 rounded-xl shadow-lg border border-gray-200 max-h-60 overflow-y-auto">
                <template x-for="(result, index) in results" :key="index">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition" x-text="result"></a>
                </template>
                <div x-show="results.length === 0" class="px-4 py-2 text-sm text-gray-500">Tidak ada hasil ditemukan.</div>
            </div>
        </div>
    </div> --}}
    <x-search></x-search>

    <!-- Kanan: Notif + User -->
    <div class="flex items-center space-x-5">
        <!-- Notifikasi -->
        <button class="relative text-gray-600 hover:text-blue-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 17h5l-1.4-1.4A2.1 2.1 0 0118 14.1V11a6 6 0 00-4-5.7V4a2 2 0 10-4 0v1.3A6 6 0 006 11v3.1c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span
                class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center border-2 border-white">3</span>
        </button>

        <!-- Profil Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="flex items-center space-x-2 hover:text-blue-600 px-3 py-1.5 rounded-full transition">
                <img src="{{ Auth::check() && Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('default-avatar.png') }}"
                    alt="User Avatar" class="w-8 h-8 rounded-full object-cover border border-gray-300" />
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-chevron-up-icon lucide-chevron-up transition-transform duration-300"
                    :class="{ '-rotate-180': open }">
                    <path d="m18 15-6-6-6 6" />
                </svg>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50"
                x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-user-round-icon lucide-user-round">
                        <circle cx="12" cy="8" r="5" />
                        <path d="M20 21a8 8 0 0 0-16 0" />
                    </svg>
                    Profil
                </a>

                {{-- <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Pengaturan
                </a> --}}

                <div class="border-t my-1 "></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div class="text-red-600 hover:bg-red-50">
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 text-sm ">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                            </svg>
                            Keluar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
