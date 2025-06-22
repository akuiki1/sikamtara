<div x-data="{ collapsed: false }" :class="collapsed ? 'w-20' : 'w-64'"
    class="h-auto bg-white border-r transition-all duration-300 flex flex-col">

    <!-- Logo & Collapse Button -->
    <div class="flex items-center justify-between px-4 py-4 border-b">
        <img src="{{ asset('img/LogoHST.png') }}" alt="Logo" class="h-10 w-auto" x-show="!collapsed">

        {{-- <button @click="collapsed = !collapsed" class="text-gray-500 hover:text-gray-700">
            <svg class="w-5 h-5 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg"
                :class="collapsed ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="none">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m15 19-7-7 7-7" />
            </svg> --}}

        </button>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-3 py-4 space-y-2 text-gray-800 text-sm font-medium">

        <!-- Beranda -->
        <a href="{{ route('dashboard.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all
          hover:bg-gray-100
          {{ request()->routeIs('dashboard.index') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-house-icon lucide-house">
                <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                <path
                    d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            </svg>

            <span x-show="!collapsed" class="transition-opacity duration-200">Beranda</span>
        </a>

        <!-- Profil Desa -->
        <a href="{{ route('profildesa.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('profildesa.index') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-landmark-icon lucide-landmark">
                <line x1="3" x2="21" y1="22" y2="22" />
                <line x1="6" x2="6" y1="18" y2="11" />
                <line x1="10" x2="10" y1="18" y2="11" />
                <line x1="14" x2="14" y1="18" y2="11" />
                <line x1="18" x2="18" y1="18" y2="11" />
                <polygon points="12 2 20 7 4 7" />
            </svg>

            <span x-show="!collapsed" class="transition-opacity duration-200">Profil Desa</span>
        </a>

        <!-- Layanan -->
        <div x-data="{ open: {{ request()->routeIs('adminadministrasi.*') || request()->is('admin/layanan/pengaduan') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-3 py-2 hover:bg-gray-100 rounded-lg transition-all">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-globe-icon lucide-globe">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                        <path d="M2 12h20" />
                    </svg>
                    <span x-show="!collapsed">Kelola Layanan Online</span>
                </div>
                <svg x-show="!collapsed" :class="open ? 'rotate-90' : ''"
                    class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div x-show="open" x-collapse x-cloak class="space-y-1 pl-10 mt-1">
                <a href="{{ route('adminadministrasi.index') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg transition-all
          hover:bg-gray-100
          {{ request()->routeIs('adminadministrasi.*') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-file-plus2-icon lucide-file-plus-2">
                        <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                        <path d="M3 15h6" />
                        <path d="M6 12v6" />
                    </svg>
                    <span>Layanan Administrasi</span>
                </a>
                <a href="/admin/layanan/pengaduan"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-message-circle-warning-icon lucide-message-circle-warning">
                        <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                        <path d="M12 8v4" />
                        <path d="M12 16h.01" />
                    </svg>
                    <span>Pengaduan Masyarakat</span>
                </a>
            </div>
        </div>

        <!-- Berita & Pengumuman -->
        <div x-data="{ open: {{ request()->routeIs('adminberita.*') || request()->routeIs('adminpengumuman.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-3 py-2 hover:bg-gray-100 rounded-lg transition-all">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-newspaper-icon lucide-newspaper">
                        <path d="M15 18h-5" />
                        <path d="M18 14h-8" />
                        <path
                            d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2" />
                        <rect width="8" height="4" x="10" y="6" rx="1" />
                    </svg>
                    <span x-show="!collapsed">Berita & Pengumuman</span>
                </div>
                <svg x-show="!collapsed" :class="open ? 'rotate-90' : ''"
                    class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div x-show="open" x-collapse x-cloak class="space-y-1 pl-10 mt-1">
                <a href="{{ route('adminberita.index') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('adminberita.*') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-newspaper-icon lucide-newspaper">
                        <path d="M15 18h-5" />
                        <path d="M18 14h-8" />
                        <path
                            d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2" />
                        <rect width="8" height="4" x="10" y="6" rx="1" />
                    </svg>
                    <span>Berita Desa</span>
                </a>
                <a href="{{ route('adminpengumuman.index') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('adminpengumuman.*') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-megaphone-icon lucide-megaphone">
                        <path d="m3 11 18-5v12L3 14v-3z" />
                        <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6" />
                    </svg>
                    <span>Pengumuman</span>
                </a>
            </div>
        </div>

        <!-- Kelola Akun -->
        <div x-data="{ open: {{ request()->routeIs('profile.*') || request()->routeIs('user.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-3 py-2 hover:bg-gray-100 rounded-lg transition-all">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-user-round-cog-icon lucide-user-round-cog">
                        <path d="m14.305 19.53.923-.382" />
                        <path d="m15.228 16.852-.923-.383" />
                        <path d="m16.852 15.228-.383-.923" />
                        <path d="m16.852 20.772-.383.924" />
                        <path d="m19.148 15.228.383-.923" />
                        <path d="m19.53 21.696-.382-.924" />
                        <path d="M2 21a8 8 0 0 1 10.434-7.62" />
                        <path d="m20.772 16.852.924-.383" />
                        <path d="m20.772 19.148.924.383" />
                        <circle cx="10" cy="8" r="5" />
                        <circle cx="18" cy="18" r="3" />
                    </svg>
                    <span x-show="!collapsed">Kelola Akun</span>
                </div>
                <svg x-show="!collapsed" :class="open ? 'rotate-90' : ''"
                    class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div x-show="open" x-collapse x-cloak class="space-y-1 pl-10 mt-1">
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('profile.*') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-user-round-cog-icon lucide-user-round-cog">
                        <path d="m14.305 19.53.923-.382" />
                        <path d="m15.228 16.852-.923-.383" />
                        <path d="m16.852 15.228-.383-.923" />
                        <path d="m16.852 20.772-.383.924" />
                        <path d="m19.148 15.228.383-.923" />
                        <path d="m19.53 21.696-.382-.924" />
                        <path d="M2 21a8 8 0 0 1 10.434-7.62" />
                        <path d="m20.772 16.852.924-.383" />
                        <path d="m20.772 19.148.924.383" />
                        <circle cx="10" cy="8" r="5" />
                        <circle cx="18" cy="18" r="3" />
                    </svg>
                    <span>Profil</span>
                </a>
                <a href="{{ route('user.index') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('user.*') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-user-round-pen-icon lucide-user-round-pen">
                        <path d="M2 21a8 8 0 0 1 10.821-7.487" />
                        <path
                            d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                        <circle cx="10" cy="8" r="5" />
                    </svg>

                    <span>Kelola Akun Warga</span>
                </a>
            </div>
        </div>

        <!-- Kependudukan -->
        <div x-data="{ open: {{ request()->routeIs('keluarga.*') || request()->routeIs('penduduk.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-3 py-2 hover:bg-gray-100 rounded-lg transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="1"
                            d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                    </svg>
                    <span x-show="!collapsed">Kependudukan</span>
                </div>
                <svg x-show="!collapsed" :class="open ? 'rotate-90' : ''"
                    class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div x-show="open" x-collapse x-cloak class="space-y-1 pl-10 mt-1">
                <a href="{{ route('keluarga.index') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('keluarga.*') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-users-round-icon lucide-users-round">
                        <path d="M18 21a8 8 0 0 0-16 0" />
                        <circle cx="10" cy="8" r="5" />
                        <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                    </svg>
                    <span>Keluarga</span>


                </a>
                <a href="{{ route('penduduk.index') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('penduduk.*') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-user-round-icon lucide-user-round">
                        <circle cx="12" cy="8" r="5" />
                        <path d="M20 21a8 8 0 0 0-16 0" />
                    </svg>
                    <span>Penduduk</span>
                </a>
            </div>
        </div>

        <!-- APBDes -->
       <div x-data="{ open: {{ request()->routeIs('adminapbdes.*') || request()->routeIs('admin.apbdes.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-3 py-2 hover:bg-gray-100 rounded-lg transition-all">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="1"
                            d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                    <span x-show="!collapsed">APBDes</span>
                </div>
                <svg x-show="!collapsed" :class="open ? 'rotate-90' : ''"
                    class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div x-show="open" x-collapse x-cloak class="space-y-1 pl-10 mt-1">
                <a href="{{ route('adminapbdes.dataAnggaran') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('adminapbdes.dataAnggaran') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M5.5 21h13M12 21V7m0 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm2-1.8c3.073.661 2.467 2.8 5 2.8M5 8c3.359 0 2.192-2.115 5.012-2.793M7 9.556V7.75m0 1.806-1.95 4.393a.773.773 0 0 0 .37.962.785.785 0 0 0 .362.089h2.436a.785.785 0 0 0 .643-.335.776.776 0 0 0 .09-.716L7 9.556Zm10 0V7.313m0 2.243-1.95 4.393a.773.773 0 0 0 .37.962.786.786 0 0 0 .362.089h2.436a.785.785 0 0 0 .643-.335.775.775 0 0 0 .09-.716L17 9.556Z" />
                    </svg>

                    <span>Data Anggaran</span>


                </a>
                <a href="{{ route('admin.apbdes.pendapatan.latest') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('admin.apbdes.pendapatan*') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M5.5 21h13M12 21V7m0 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm2-1.8c3.073.661 2.467 2.8 5 2.8M5 8c3.359 0 2.192-2.115 5.012-2.793M7 9.556V7.75m0 1.806-1.95 4.393a.773.773 0 0 0 .37.962.785.785 0 0 0 .362.089h2.436a.785.785 0 0 0 .643-.335.776.776 0 0 0 .09-.716L7 9.556Zm10 0V7.313m0 2.243-1.95 4.393a.773.773 0 0 0 .37.962.786.786 0 0 0 .362.089h2.436a.785.785 0 0 0 .643-.335.775.775 0 0 0 .09-.716L17 9.556Z" />
                    </svg>

                    <span>Pendapatan</span>


                </a>
                <a href="{{ route('adminapbdes.belanja') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('adminapbdes.belanja') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="1"
                            d="M16.5 15v1.5m0 0V18m0-1.5H15m1.5 0H18M3 9V6a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3M3 9v6a1 1 0 0 0 1 1h5M3 9h16m0 0v1M6 12h3m12 4.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                    </svg>

                    <span>Belanja</span>
                </a>
                <a href="{{ route('adminapbdes.pembiayaan') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('adminapbdes.pembiayaan') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="1"
                            d="M16.5 15v1.5m0 0V18m0-1.5H15m1.5 0H18M3 9V6a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3M3 9v6a1 1 0 0 0 1 1h5M3 9h16m0 0v1M6 12h3m12 4.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                    </svg>

                    <span>Pembiayaan</span>
                </a>
                <a href="{{ route('adminapbdes.rekapitulasi') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('adminapbdes.rekapitulasi') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="1"
                            d="M16.5 15v1.5m0 0V18m0-1.5H15m1.5 0H18M3 9V6a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3M3 9v6a1 1 0 0 0 1 1h5M3 9h16m0 0v1M6 12h3m12 4.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                    </svg>

                    <span>Rekapitulasi</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- LogOut -->
    <div class="flex-1 px-3 py-4 space-y-2 text-gray-800 text-sm font-medium text-center border-t">
        <div class="flex items-center gap-3 px-3 py-2 rounded-lg hover:text-red-600 hover:bg-gray-100 transition-all">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" x2="9" y1="12" y2="12" />
                    </svg>
                    <span x-show="!collapsed" class="transition-opacity duration-200">Logout</span>
                </button>
            </form>
        </div>
    </div>

</div>
