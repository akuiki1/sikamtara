<table>
    <tr>
        <td colspan="5" align="center"><strong>REALISASI APBDES DESA KAMBAT UTARA</strong></td>
    </tr>
    <tr>
        <td colspan="5" align="center"><strong>TAHUN {{ $tahun }}</strong></td>
    </tr>
    <tr><td colspan="5"></td></tr>

    <tr style="background-color: #f9cb9c;">
        <th>Uraian</th>
        <th>Anggaran</th>
        <th>Realisasi</th>
        <th>Sisa</th>
        <th>Persentase</th>
    </tr>

    @php
        $grouped = $details->groupBy('kategori');
    @endphp

    @foreach ($grouped as $kategori => $items)
        @php
            $kategoriUpper = strtoupper($kategori);
            $groupedJudul = $items->groupBy('judul');
            $totalAnggaran = $items->sum('anggaran');
            $totalRealisasi = $items->sum('realisasi');
        @endphp

        <tr style="background-color: #c9daf8;">
            <td colspan="5"><strong>{{ $kategoriUpper }}</strong></td>
        </tr>

        @foreach ($groupedJudul as $judul => $subitems)
            <tr style="background-color: #d9ead3;">
                <td colspan="5"><strong>{{ $judul }}</strong></td>
            </tr>

            @foreach ($subitems as $item)
                <tr>
                    <td>{{ $item->sub_judul }}</td>
                    <td>Rp {{ number_format($item->anggaran, 2, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->realisasi, 2, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->anggaran - $item->realisasi, 2, ',', '.') }}</td>
                    <td>
                        @if ($item->anggaran > 0)
                            {{ number_format(($item->realisasi / $item->anggaran) * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </td>
                </tr>
            @endforeach
        @endforeach

        <tr style="background-color: #fce5cd; font-weight: bold;">
            <td>Total {{ ucfirst($kategori) }}</td>
            <td>Rp {{ number_format($totalAnggaran, 2, ',', '.') }}</td>
            <td>Rp {{ number_format($totalRealisasi, 2, ',', '.') }}</td>
            <td>Rp {{ number_format($totalAnggaran - $totalRealisasi, 2, ',', '.') }}</td>
            <td>
                @if ($totalAnggaran > 0)
                    {{ number_format(($totalRealisasi / $totalAnggaran) * 100, 2) }}%
                @else
                    0%
                @endif
            </td>
        </tr>

        <tr><td colspan="5"></td></tr>
    @endforeach
</table>
