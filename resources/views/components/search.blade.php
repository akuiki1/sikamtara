<div x-data="searchComponent()" x-init="init()" @click.away="showResults = false" class="relative w-full max-w-lg">
    <input type="text" placeholder="Cari data warga, surat, info desa..." x-model="query" @input="filterResults()"
        class="w-full pl-11 pr-4 py-2 rounded-full bg-gray-100 focus:bg-white border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm text-gray-700 shadow-sm" />
    <div class="absolute inset-y-0 left-4 flex items-center text-gray-400">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
        </svg>
    </div>

    <div x-show="showResults"
        class="absolute z-50 w-full bg-white mt-2 rounded-xl shadow-lg border border-gray-200 max-h-60 overflow-y-auto">
        <template x-for="(result, index) in results" :key="index">
            <a href="#" @click.prevent="handleClick(result)"
                class="block px-4 py-2 text-sm hover:bg-blue-50 text-gray-700" x-text="result.label"></a>
        </template>
    </div>
</div>

<script>
    function searchComponent() {
        return {
            query: '',
            results: [],
            showResults: false,
            staticData: [{
                    label: 'Beranda',
                    href: '{{ route('dashboard.index') }}'
                },
                {
                    label: 'Profil Desa',
                    href: '{{ route('profildesa.index') }}'
                },
                {
                    label: 'Layanan Administrasi',
                    href: '{{ route('adminadministrasi.index') }}'
                },
                {
                    label: 'Pengaduan Masyarakat',
                    href: '{{ route('admin.pengaduan.index') }}'
                },
                {
                    label: 'Berita Desa',
                    href: '{{ route('adminberita.index') }}'
                },
                {
                    label: 'Pengumuman',
                    href: '{{ route('adminpengumuman.index') }}'
                },
                {
                    label: 'Profil Admin',
                    href: '{{ route('profile.edit') }}'
                },
                {
                    label: 'Kelola Akun Warga',
                    href: '{{ route('user.index') }}'
                },
                {
                    label: 'Data Penduduk',
                    href: '{{ route('penduduk.index') }}'
                },
                {
                    label: 'Data Keluarga',
                    href: '{{ route('keluarga.index') }}'
                },
                {
                    label: 'Anggaran APBDes',
                    href: '{{ route('adminapbdes.dataAnggaran') }}'
                },
                {
                    label: 'Pendapatan APBDes',
                    href: '{{ route('adminapbdes.pendapatan') }}'
                },
                {
                    label: 'Belanja APBDes',
                    href: '{{ route('adminapbdes.belanja') }}'
                },
                {
                    label: 'Pembiayaan APBDes',
                    href: '{{ route('adminapbdes.pembiayaan') }}'
                },
                {
                    label: 'Rekapitulasi APBDes',
                    href: '{{ route('adminapbdes.rekapitulasi') }}'
                },
                {
                    label: 'Logout',
                    id: 'menu-logout'
                }
            ],

            init() {
                this.results = this.staticData;
            },
            filterResults() {
                this.results = [];

                // Static search (label from staticData)
                const staticResults = this.staticData.filter(item =>
                    item.label.toLowerCase().includes(this.query.toLowerCase())
                );

                // Dynamic DOM ID search
                const domResults = Array.from(document.querySelectorAll('[id]'))
                    .filter(el => el.id && el.id.toLowerCase().includes(this.query.toLowerCase()))
                    .map(el => ({
                        label: `[Halaman Ini] #${el.id}`,
                        id: el.id,
                        href: window.location.pathname
                    }));

                this.results = [...staticResults, ...domResults];
                this.showResults = this.query.length > 0;
            },
            handleClick(result) {
                const currentPath = window.location.pathname;
                const targetPath = new URL(result.href ?? '', window.location.origin).pathname;

                if (result.id && currentPath === targetPath) {
                    const el = document.getElementById(result.id);
                    if (el) {
                        el.scrollIntoView({
                            behavior: 'smooth'
                        });
                        el.classList.add('bg-yellow-100');
                        setTimeout(() => el.classList.remove('bg-yellow-100'), 1000);
                    }
                } else if (result.href) {
                    window.location.href = result.href;
                }

                this.showResults = false;
                this.query = '';
            }
        }
    }
</script>
