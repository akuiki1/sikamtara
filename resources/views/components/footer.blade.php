<footer class="bg-gradient-to-l from-blue-800 to-blue-900 text-white px-6 py-10">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-8">
        <!-- Logo dan Alamat -->
        <div class="flex flex-col items-start">
            <img src="{{ asset('/img/LogoHST.png') }}" alt="Logo Barrabai" class="w-20 mb-4">
        </div>

        <div class="flex flex-col items-start">
            <div>
                <p class="font-semibold">Pemerintah Desa Kambat Utara</p>
                <p>Jl. Telaga Bawarna</p>
                <p>Desa Kambat Utara</p>
                <p>RT. 001 RW. 001</p>
                <p>Kecamatan Pandawan,</p>
                <p>Kabupaten Hulu Sungai Tengah,</p>
                <p>Provinsi Kalimantan Selatan,</p>
                <p>71352</p>
            </div>
        </div>

        <!-- Hubungi Kami -->
        <div>
            <p class="font-semibold mb-2">Hubungi Kami</p>
            <p>0822 5672 2800</p>
            <p>KambatUtara@hst.kab.go.id</p>
        </div>

        <!-- No Telepon Penting -->
        <div>
            <p class="font-semibold mb-2">No Telepon Penting</p>
            <p>Rini (Sekdes) : 082256722800</p>
        </div>

        <!-- Jelajahi -->
        <div>
            <p class="font-semibold mb-2">Jelajahi</p>
            <ul class="space-y-1 text-sm">
                <li><a href="{{ route('public.profil.desa') }}" class="hover:underline">Profil Desa</a></li>
                <li><a href="{{ route('public.profil.desa') }}#struktur" class="hover:underline">Struktur Pemerintahan</a></li>
                <li><a href="{{ route('administrasi') }}" class="hover:underline">Layanan Mandiri</a></li>
                <li><a href="{{ route('user.kependudukan') }}" class="hover:underline">Data & Statistik</a></li>
                <li><a href="{{ route('berita.index') }}" class="hover:underline">Berita & Kegiatan</a></li>
            </ul>
        </div>
    </div>
</footer>
