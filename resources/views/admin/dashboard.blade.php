<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold">Total Pengaduan</h3>
            <p class="text-2xl font-bold">120</p>
        </div>
        
        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold">Pengaduan Terbaru</h3>
            <p class="text-2xl font-bold">15</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold">Penduduk Terdaftar</h3>
            <p class="text-2xl font-bold">500</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold">Surat Pengajuan</h3>
            <p class="text-2xl font-bold">32</p>
        </div>
    </div>

    {{-- Tabel atau konten lainnya --}}
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Daftar Pengaduan</h2>
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">ID Pengaduan</th>
                    <th class="px-4 py-2 border-b">Nama</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Tanggal Pengaduan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2 border-b">#12345</td>
                    <td class="px-4 py-2 border-b">John Doe</td>
                    <td class="px-4 py-2 border-b">Diterima</td>
                    <td class="px-4 py-2 border-b">2025-04-27</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-admin-layout>
