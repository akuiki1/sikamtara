<x-admin-layout>
    <x-slot:title>Verifikasi Akun</x-slot>

    <section class="flex items-center justify-center bg-gray-100">
        <div class="bg-white rounded-2xl shadow-xl w-full px-10 py-10 transition-all duration-300">
            <a href="{{ route('user.index') }}" class="flex items-center text-gray-500 hover:underline mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>

            <h2 class="text-3xl font-bold text-center text-gray-800">Verifikasi Akun Warga</h2>

            <div class="mt-6 space-y-6">
                <div class="border p-6 rounded-lg shadow-md">
                    <h1 class="text-gray-800 font-semibold text-xl">Foto KTP</h1>
                    <img src="{{ asset('storage/' . $verifikasi->foto_ktp) }}" alt=""
                        class="w-full h-auto rounded-lg shadow-md mt-4">
                </div>
                <div class="border p-6 rounded-lg shadow-md">
                    <h1 class="text-gray-800 font-semibold text-xl">Selfie KTP</h1>
                    <img src="{{ asset('storage/' . $verifikasi->selfie_ktp) }}" alt=""
                        class="w-full h-auto rounded-lg shadow-md mt-4">
                </div>
                <div class="border p-6 rounded-lg shadow-md">
                    <h1 class="text-gray-800 font-semibold text-xl">Foto KTP</h1>
                    <img src="{{ asset('storage/' . $verifikasi->foto_kk) }}" alt=""
                        class="w-full h-auto rounded-lg shadow-md mt-4">
                </div>
            </div>

            <form method="POST" action="{{ route('user.verifikasi.update', $verifikasi->id) }}">
                @csrf
                @method('PUT')
                <div class="mt-6">
                    <input type="text" name="status_verifikasi" id="status_verifikasi" value="Terverifikasi" hidden>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">Simpan</button>
                </div>
            </form>
        </div>
</x-admin-layout>
