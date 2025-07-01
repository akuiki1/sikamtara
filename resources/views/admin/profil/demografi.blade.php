<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
        <!-- Notifikasi Success -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-3xl font-bold text-gray-800 mb-6">Demografi Desa</h2>

        <!-- Statistik Penduduk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-blue-700">Jumlah Penduduk</h3>
                <p class="text-3xl font-bold text-gray-800 mt-2">4382</p>
            </div>

            <div class="bg-green-100 p-4 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-green-700">Jumlah Laki-laki</h3>
                <p class="text-3xl font-bold text-gray-800 mt-2">1943</p>
            </div>

            <div class="bg-pink-100 p-4 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-pink-700">Jumlah Perempuan</h3>
                <p class="text-3xl font-bold text-gray-800 mt-2">1762</p>
            </div>
        </div>

        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Edit Data Demografi</h3>

        <!-- Form Input untuk Mengedit Data Demografi -->
        {{-- <form action="{{ route('admin.demografi.update') }}" method="POST"> --}}
        <form action="#" method="POST">
            @csrf
            @method('PUT')

            <!-- Input Jumlah Penduduk -->
            <div class="mb-6">
                <label for="jumlah_penduduk" class="block text-lg font-semibold text-gray-700 mb-2">Jumlah Penduduk</label>
                <input type="number" name="jumlah_penduduk" id="jumlah_penduduk" class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-700" value="4382" required>
                @error('jumlah_penduduk')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Jumlah Laki-laki -->
            <div class="mb-6">
                <label for="jumlah_laki_laki" class="block text-lg font-semibold text-gray-700 mb-2">Jumlah Laki-laki</label>
                <input type="number" name="jumlah_laki_laki" id="jumlah_laki_laki" class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-700" value="1943" required>
                @error('jumlah_laki_laki')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Jumlah Perempuan -->
            <div class="mb-6">
                <label for="jumlah_perempuan" class="block text-lg font-semibold text-gray-700 mb-2">Jumlah Perempuan</label>
                <input type="number" name="jumlah_perempuan" id="jumlah_perempuan" class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-700" value="1762" required>
                @error('jumlah_perempuan')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300 focus:outline-none">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
