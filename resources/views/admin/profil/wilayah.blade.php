<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="p-6" x-data="{ modalAdd: false, modalEdit: false, modalView: false }">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Wilayah Administrasi</h2>
            <button @click="modalAdd = true" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">+ Tambah Wilayah</button>
        </div>

        <div class="overflow-x-auto bg-white rounded-xl shadow border">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Dusun</th>
                        <th class="px-4 py-3 text-left">RW</th>
                        <th class="px-4 py-3 text-left">RT</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">1</td>
                        <td class="px-4 py-2">Dusun Mekar Sari</td>
                        <td class="px-4 py-2">01</td>
                        <td class="px-4 py-2">01</td>
                        <td class="px-4 py-2 space-x-1">
                            <button @click="modalView = true" class="text-blue-600 hover:underline">Lihat</button>
                            <button @click="modalEdit = true" class="text-yellow-600 hover:underline">Edit</button>
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                    <!-- Tambahkan baris lainnya di sini -->
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah -->
        <div x-show="modalAdd" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">Tambah Wilayah</h3>
                <form class="space-y-4">
                    <input type="text" placeholder="Nama Dusun" class="w-full border rounded px-4 py-2">
                    <input type="text" placeholder="RW" class="w-full border rounded px-4 py-2">
                    <input type="text" placeholder="RT" class="w-full border rounded px-4 py-2">
                    <div class="flex justify-end space-x-2">
                        <button @click.prevent="modalAdd = false" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit -->
        <div x-show="modalEdit" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">Edit Wilayah</h3>
                <form class="space-y-4">
                    <input type="text" value="Dusun Mekar Sari" class="w-full border rounded px-4 py-2">
                    <input type="text" value="01" class="w-full border rounded px-4 py-2">
                    <input type="text" value="01" class="w-full border rounded px-4 py-2">
                    <div class="flex justify-end space-x-2">
                        <button @click.prevent="modalEdit = false" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Lihat -->
        <div x-show="modalView" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl w-full max-w-sm">
                <h3 class="text-lg font-bold mb-4">Detail Wilayah</h3>
                <ul class="text-gray-800 space-y-1">
                    <li><strong>Dusun:</strong> Mekar Sari</li>
                    <li><strong>RW:</strong> 01</li>
                    <li><strong>RT:</strong> 01</li>
                </ul>
                <div class="flex justify-end mt-4">
                    <button @click="modalView = false" class="bg-gray-200 px-4 py-2 rounded">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
