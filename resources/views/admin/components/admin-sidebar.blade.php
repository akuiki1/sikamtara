<div class="h-full bg-gray-800 text-white p-6">
    <div class="space-y-6">
        <div class="text-lg font-semibold">Admin Dashboard</div>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}" class="block py-2 hover:bg-gray-700 rounded">Dashboard</a></li>
            <li><a href="{{ route('admin.surats') }}" class="block py-2 hover:bg-gray-700 rounded">Surat Pengajuan</a></li>
            <li><a href="{{ route('admin.pengaduan') }}" class="block py-2 hover:bg-gray-700 rounded">Pengaduan</a></li>
            <li><a href="{{ route('admin.penduduk') }}" class="block py-2 hover:bg-gray-700 rounded">Penduduk</a></li>
            <li><a href="{{ route('admin.settings') }}" class="block py-2 hover:bg-gray-700 rounded">Pengaturan</a></li>
        </ul>
    </div>
</div>
