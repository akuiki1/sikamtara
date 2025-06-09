<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-10 px-6 text-center">
    </section>

    <section x-data="{ tahunDipilih: new Date().getFullYear(), tahunList: [2023, 2024, 2025] }" class="p-6 space-y-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Laporan APBDes</h1>
                <p class="text-sm text-gray-600">Anggaran Pendapatan dan Belanja Desa per tahun</p>
            </div>
            <div class="flex gap-4 flex-wrap">
                {{-- Dropdown tahun --}}
                <select x-model="tahunDipilih" @change="window.location.href = '?tahun=' + tahunDipilih"
                    class="border rounded-lg px-3 py-2 text-sm text-gray-700">
                    @foreach ($tahunList as $t)
                        <option value="{{ $t }}" @selected($t == $tahun)>{{ $t }}</option>
                    @endforeach
                </select>


                {{-- Tombol unduh --}}
                <a :href="`/apbdes/export?tahun=${tahunDipilih}`"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Unduh Excel
                </a>
            </div>
        </div>

        {{-- Konten --}}
        <div class="space-y-6">
            {{-- Pendapatan --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="bg-blue-100 px-4 py-3 font-semibold text-blue-900">
                    Pendapatan
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left border-t">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">Sumber</th>
                                <th class="px-4 py-2 border">Anggaran</th>
                                <th class="px-4 py-2 border">Realisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendapatan as $item)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 border">{{ $item->judul }}</td>
                                    <td class="px-4 py-2 border">Rp{{ number_format($item->anggaran, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 border">Rp{{ number_format($item->realisasi, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-gray-500">Data kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Belanja --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="bg-red-100 px-4 py-3 font-semibold text-red-900">
                    Belanja
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left border-t">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">Kategori</th>
                                <th class="px-4 py-2 border">Anggaran</th>
                                <th class="px-4 py-2 border">Realisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($belanja as $item)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 border">{{ $item->judul }}</td>
                                    <td class="px-4 py-2 border">Rp{{ number_format($item->anggaran, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 border">Rp{{ number_format($item->realisasi, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-gray-500">Data kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pembiayaan --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="bg-yellow-100 px-4 py-3 font-semibold text-yellow-900">
                    Pembiayaan
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left border-t">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">Jenis</th>
                                <th class="px-4 py-2 border">Anggaran</th>
                                <th class="px-4 py-2 border">Realisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pembiayaan as $item)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 border">{{ $item->judul }}</td>
                                    <td class="px-4 py-2 border">Rp{{ number_format($item->anggaran, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 border">Rp{{ number_format($item->realisasi, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-gray-500">Data kosong</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </section>


</x-layout>
