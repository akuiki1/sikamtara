<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-9 px-6 text-center">
    </section>

    <section class="p-6 space-y-4 bg-gray-100">

        {{-- Container Header --}}
        <div
            class="rounded-xl shadow-lg bg-white px-6 py-6 flex flex-col md:flex-row md:items-center md:justify-between">

            {{-- header --}}
            <div>
                <h1 class="text-2xl font-bold mb-2 md:mb-0 text-gray-800">Laporan Keuangan Desa Kambat Utara</h1>
                <p class="text-sm text-gray-600">Menampilkan data Pendapatan, Belanja, dan Pembiayaan berdasarkan tahun
                    anggaran</p>
            </div>

            {{-- CTA Pilih Tahun --}}
            <form method="GET" action="{{ route('user.keuangan') }}" class="mt-4 md:mt-0">
                <label for="tahun" class="mr-2 font-semibold">Pilih Tahun:</label>
                <select name="tahun" id="tahun" onchange="this.form.submit()"
                    class="border text-black px-3 py-1.5 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @foreach (\App\Models\TahunAnggaran::orderByDesc('tahun')->get() as $th)
                        <option value="{{ $th->id_tahun_anggaran }}"
                            {{ $th->id_tahun_anggaran == $tahun->id_tahun_anggaran ? 'selected' : '' }}>
                            {{ $th->tahun }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- container Card --}}
        <div class="rounded-xl shadow bg-white p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <div class="flex-1 bg-green-100 p-3 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-xs text-green-800 font-semibold">Pendapatan</p>
                <p class="text-xl font-bold text-green-900 mt-1">Rp
                    {{ number_format($pendapatan->sum('realisasi'), 2, ',', '.') }}</p>
            </div>

            <div class="flex-1 bg-red-100 p-3 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-xs text-red-800 font-semibold">Belanja</p>
                <p class="text-xl font-bold text-red-900 mt-1">Rp {{ number_format($totalBelanja, 2, ',', '.') }}</p>
            </div>

            <div class="flex-1 bg-indigo-100 p-3 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-xs text-indigo-800 font-semibold">Surplus/Defisit</p>
                <p class="text-xl font-bold text-indigo-900 mt-1">Rp {{ number_format($surplusDefisit, 2, ',', '.') }}
                </p>
            </div>

            <div class="flex-1 bg-purple-100 p-3 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-xs text-purple-800 font-semibold">Pembiayaan Netto</p>
                <p class="text-xl font-bold text-purple-900 mt-1">Rp {{ number_format($pembiayaanNetto, 2, ',', '.') }}
                </p>
            </div>

            <div class="flex-1 bg-yellow-100 p-3 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <p class="text-xs text-yellow-800 font-semibold">SILPA {{ $tahun->tahun }}</p>
                <p class="text-xl font-bold text-yellow-900 mt-1">Rp {{ number_format($silpa_akhir, 2, ',', '.') }}</p>
            </div>

        </div>


        {{-- tabel content --}}
        <div class="space-y-8">
            {{-- Pendapatan --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-blue-700 mb-4">Pendapatan</h2>
                <div class="overflow-x-auto">
                    <x-table class="w-full min-w-[600px]">
                        <x-slot name="head">
                            <tr>
                                <th class="px-4 py-2 text-left w-1/2">Pendapatan Desa Kambat Utara</th>
                                <th class="px-4 py-2 text-right w-1/6">Anggaran</th>
                                <th class="px-4 py-2 text-right w-1/6">Realisasi</th>
                                <th class="px-4 py-2 text-right w-1/6">Selisih</th>
                            </tr>
                        </x-slot>
                        <x-slot name="body">
                            @foreach ($pendapatan as $item)
                                <tr>
                                    <td class="px-4 py-2">{{ $item->nama }}</td>
                                    <td class="px-4 py-2 text-right">Rp
                                        {{ number_format($item->anggaran, 2, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right">Rp
                                        {{ number_format($item->realisasi, 2, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right">Rp
                                        {{ number_format($item->anggaran - $item->realisasi, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </x-slot>
                        <x-slot name="footer">
                            @php
                                $totalAnggaran = $pendapatan->sum('anggaran');
                                $totalRealisasi = $pendapatan->sum('realisasi');
                                $totalSelisih = $totalAnggaran - $totalRealisasi;
                            @endphp
                            <tr class="font-semibold border-t">
                                <td class="px-4 py-2 text-left">Total Pendapatan Desa Kambat Utara Tahun
                                    {{ $tahun->tahun }}</td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($totalAnggaran, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($totalRealisasi, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($totalSelisih, 2, ',', '.') }}
                                </td>
                            </tr>
                        </x-slot>
                    </x-table>
                </div>
            </div>

            {{-- Belanja --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-purple-700 mb-4">Belanja</h2>
                <div class="space-y-6">
                    @foreach ($belanja as $b)
                        @if ($b->rincianBelanja->count() > 0)
                            <div class="overflow-x-auto">
                                <x-table class="w-full min-w-[600px]">
                                    <x-slot name="head">
                                        <tr>
                                            <th class="px-4 py-2 text-left w-1/2">Belanja {{ $b->nama }}</th>
                                            <th class="px-4 py-2 text-right w-1/6">Anggaran</th>
                                            <th class="px-4 py-2 text-right w-1/6">Realisasi</th>
                                            <th class="px-4 py-2 text-right w-1/6">Selisih</th>
                                        </tr>
                                    </x-slot>
                                    <x-slot name="body">
                                        @foreach ($b->rincianBelanja as $r)
                                            <tr>
                                                <td class="px-4 py-2">{{ $r->nama }}</td>
                                                <td class="px-4 py-2 text-right">Rp
                                                    {{ number_format($r->anggaran, 2, ',', '.') }}</td>
                                                <td class="px-4 py-2 text-right">Rp
                                                    {{ number_format($r->realisasi, 2, ',', '.') }}</td>
                                                <td class="px-4 py-2 text-right">Rp
                                                    {{ number_format($r->anggaran - $r->realisasi, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </x-slot>
                                    <x-slot name="footer">
                                        @php
                                            $totalAnggaran = $b->rincianBelanja->sum('anggaran');
                                            $totalRealisasi = $b->rincianBelanja->sum('realisasi');
                                            $totalSelisih = $totalAnggaran - $totalRealisasi;
                                        @endphp
                                        <tr class="font-semibold border-t">
                                            <td class="px-4 py-2 text-left">Total Belanja {{ $b->nama }}</td>
                                            <td class="px-4 py-2 text-right">Rp
                                                {{ number_format($totalAnggaran, 2, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-right">Rp
                                                {{ number_format($totalRealisasi, 2, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-right">Rp
                                                {{ number_format($totalSelisih, 2, ',', '.') }}</td>
                                        </tr>
                                    </x-slot>
                                </x-table>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Pembiayaan --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-green-700 mb-4">Pembiayaan</h2>
                <div class="space-y-6">
                    {{-- Penerimaan --}}
                    <div class="overflow-x-auto">
                        <x-table class="w-full min-w-[600px]">
                            <x-slot name="head">
                                <tr>
                                    <th class="px-4 py-2 text-left w-1/2">Penerimaan Pembiayaan</th>
                                    <th class="px-4 py-2 text-right w-1/6">Anggaran</th>
                                    <th class="px-4 py-2 text-right w-1/6">Realisasi</th>
                                    <th class="px-4 py-2 text-right w-1/6">Selisih</th>
                                </tr>
                            </x-slot>
                            <x-slot name="body">
                                @foreach ($pembiayaan->where('jenis', 'penerimaan') as $item)
                                    <tr>
                                        <td class="px-4 py-2">{{ $item->nama }}</td>
                                        <td class="px-4 py-2 text-right">Rp
                                            {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-right">Rp
                                            {{ number_format($item->realisasi, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-right">Rp
                                            {{ number_format($item->selisih, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-table>
                    </div>

                    {{-- Pengeluaran --}}
                    <div class="overflow-x-auto">
                        <x-table class="w-full min-w-[600px]">
                            <x-slot name="head">
                                <tr>
                                    <th class="px-4 py-2 text-left w-1/2">Pengeluaran Pembiayaan</th>
                                    <th class="px-4 py-2 text-right w-1/6">Anggaran</th>
                                    <th class="px-4 py-2 text-right w-1/6">Realisasi</th>
                                    <th class="px-4 py-2 text-right w-1/6">Selisih</th>
                                </tr>
                            </x-slot>
                            <x-slot name="body">
                                @foreach ($pembiayaan->where('jenis', 'pengeluaran') as $item)
                                    <tr>
                                        <td class="px-4 py-2">{{ $item->nama }}</td>
                                        <td class="px-4 py-2 text-right">Rp
                                            {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-right">Rp
                                            {{ number_format($item->realisasi, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-right">Rp
                                            {{ number_format($item->selisih, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-table>
                    </div>

                    {{-- SILPA --}}
                    <div class="overflow-x-auto">
                        <x-table class="w-full min-w-[600px]">
                            <x-slot name="head">
                                <tr>
                                    <th class="px-4 py-2 text-left w-1/2">Pembiayaan Netto</th>
                                    <th class="px-4 py-2 text-right w-1/6">Anggaran</th>
                                    <th class="px-4 py-2 text-right w-1/6">Realisasi</th>
                                    <th class="px-4 py-2 text-right w-1/6">Selisih</th>
                                </tr>
                            </x-slot>
                            <x-slot name="footer">
                                <tr class="font-semibold border-t">
                                    <td class="px-4 py-2 text-left">SILPA Tahun {{ $tahun->tahun }}</td>
                                    <td class="px-4 py-2 text-right">Rp {{ number_format($silpa_akhir, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-right">Rp {{ number_format($silpa_akhir, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-right">Rp {{ number_format($silpa_akhir, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </x-slot>
                        </x-table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
