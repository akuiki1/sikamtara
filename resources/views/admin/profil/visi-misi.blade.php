<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="p-6 space-y-8" x-data="{ modalVisi: false, modalMisi: false }">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Visi dan Misi Desa</h2>
        </div>

        <!-- Panel Visi -->
        <div class="bg-white border rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Visi</h3>
                <button @click="modalVisi = true" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Edit</button>
            </div>
            <p class="text-gray-800">Menjadikan Desa Kambat Utara sebagai desa mandiri, sejahtera, dan berbudaya berbasis gotong royong dan teknologi.</p>
        </div>

        <!-- Panel Misi -->
        <div class="bg-white border rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Misi</h3>
                <button @click="modalMisi = true" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Edit</button>
            </div>
            <ul class="list-disc pl-5 text-gray-800 space-y-2">
                <li>Meningkatkan kualitas pendidikan dan kesehatan masyarakat.</li>
                <li>Mendorong pertumbuhan ekonomi melalui UMKM dan pertanian.</li>
                <li>Menjaga kelestarian budaya dan lingkungan.</li>
                <li>Memanfaatkan teknologi informasi untuk pelayanan publik.</li>
            </ul>
        </div>

        <!-- Modal Visi -->
        <div x-show="modalVisi" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-xl">
                <h3 class="text-lg font-bold mb-4">Edit Visi</h3>
                <textarea class="w-full border rounded p-3 h-32">Menjadikan Desa Kambat Utara sebagai desa mandiri...</textarea>
                <div class="flex justify-end mt-4 space-x-2">
                    <button @click="modalVisi = false" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Modal Misi -->
        <div x-show="modalMisi" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-xl">
                <h3 class="text-lg font-bold mb-4">Edit Misi</h3>
                <textarea class="w-full border rounded p-3 h-40">- Meningkatkan kualitas pendidikan dan kesehatan masyarakat...</textarea>
                <div class="flex justify-end mt-4 space-x-2">
                    <button @click="modalMisi = false" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
