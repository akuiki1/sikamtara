<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-10 px-6 text-center">
    </section>

    <section class="p-6 space-y-8">
        <form method="GET" action="{{ route('user.keuangan') }}" class="mb-6">
            <label for="tahun" class="mr-2 font-medium">Pilih Tahun:</label>
            <select name="tahun" id="tahun" onchange="this.form.submit()" class="border px-2 py-1 rounded">
                @foreach (\App\Models\TahunAnggaran::orderByDesc('tahun')->get() as $th)
                    <option value="{{ $th->id_tahun_anggaran }}"
                        {{ $th->id_tahun_anggaran == $tahun->id_tahun_anggaran ? 'selected' : '' }}>
                        {{ $th->tahun }}
                    </option>
                @endforeach
            </select>
        </form>

        {{-- Pendapatan --}}
        <div>
            <h2 class="text-xl font-semibold text-blue-700 mb-2">Pendapatan</h2>
            <x-table>
                <x-slot name="head">
                    <tr>
                        <th class="p-2 text-left">PENDAPATAN DESA KAMBAT UTARA</th>
                        <th class="p-2 text-left">Anggaran</th>
                        <th class="p-2 text-left">Realisasi</th>
                        <th class="p-2 text-left">Selisih</th>
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @foreach ($pendapatan as $item)
                        <tr>
                            <td class="p-2">{{ $item->nama }}</td>
                            <td class="p-2 text-left">Rp {{ number_format($item->anggaran, 2, ',', '.') }}</td>
                            <td class="p-2 text-left">Rp {{ number_format($item->realisasi, 2, ',', '.') }}</td>
                            <td class="p-2 text-left">Rp
                                {{ number_format($item->anggaran - $item->realisasi, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        </div>

        {{-- Belanja --}}
        <div>
            <h2 class="text-xl font-semibold text-purple-700 mb-4">Belanja</h2>

            @foreach ($belanja as $b)
                @if ($b->rincianBelanja->count() > 0)
                    <div class="mb-6 p-4 bg-purple-50 border-l-4 border-purple-600 rounded">
                        <x-table>
                            <x-slot name="head">
                                <tr>
                                    <th class="p-2 text-left">Belanja {{ $b->nama }}</th>
                                    <th class="p-2 text-right">Anggaran</th>
                                    <th class="p-2 text-right">Realisasi</th>
                                    <th class="p-2 text-right">Selisih</th>
                                </tr>
                            </x-slot>
                            <x-slot name="body">
                                @foreach ($b->rincianBelanja as $r)
                                    <tr class="border-b">
                                        <td class="p-2">{{ $r->nama }}</td>
                                        <td class="p-2 text-right">Rp {{ number_format($r->anggaran, 2, ',', '.') }}
                                        </td>
                                        <td class="p-2 text-right">Rp {{ number_format($r->realisasi, 2, ',', '.') }}
                                        </td>
                                        <td class="p-2 text-right">Rp
                                            {{ number_format($r->anggaran - $r->realisasi, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-table>
                    </div>
                @endif
            @endforeach
        </div>


        {{-- Pembiayaan --}}
        <div>
            <h2 class="text-xl font-semibold text-green-700 mb-4">Pembiayaan</h2>

            <x-table>
                <x-slot name="head">
                    <tr>
                        <th class="p-2 text-left w-80">Nama</th>
                        <th class="p-2 text-right">Jenis</th>
                        <th class="p-2 text-right">Anggaran</th>
                        <th class="p-2 text-right">Realisasi</th>
                        <th class="p-2 text-right">Selisih</th>
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @foreach ($pembiayaan as $item)
                        <tr class="border-b">
                            <td class="p-2">{{ $item->nama }}</td>
                            <td class="p-2 text-right">{{ ucfirst($item->jenis) }}</td>
                            <td class="p-2 text-right">Rp {{ number_format($item->anggaran, 2, ',', '.') }}</td>
                            <td class="p-2 text-right">Rp {{ number_format($item->realisasi, 2, ',', '.') }}</td>
                            <td class="p-2 text-right">
                                Rp {{ number_format($item->anggaran - $item->realisasi, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        </div>
    </section>
</x-layout>
