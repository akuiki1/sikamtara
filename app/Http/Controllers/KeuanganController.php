<?php

namespace App\Http\Controllers;

use App\Models\Belanja;
use App\Models\Pembiayaan;
use App\Models\Pendapatan;
use Illuminate\Http\Request;
use App\Models\TahunAnggaran;
use Maatwebsite\Excel\Facades\Excel;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $idTahun = $request->input('tahun');

        $tahun = TahunAnggaran::when($idTahun, function ($query) use ($idTahun) {
            return $query->where('id_tahun_anggaran', $idTahun);
        }, function ($query) {
            return $query->orderByDesc('tahun');
        })->firstOrFail();

        $pendapatan = Pendapatan::where('id_tahun_anggaran', $tahun->id_tahun_anggaran)->get();

        $belanja = Belanja::with(['rincianBelanja' => function ($q) use ($tahun) {
            $q->where('id_tahun_anggaran', $tahun->id_tahun_anggaran);
        }])->get();

        $pembiayaan = Pembiayaan::where('id_tahun_anggaran', $tahun->id_tahun_anggaran)->get();

        // Total Pendapatan
        $totalPendapatan = $pendapatan->sum('realisasi');

        // Total Belanja (semua rincian)
        $totalBelanja = $belanja->flatMap->rincianBelanja->sum('realisasi');

        // Hitung Surplus/Defisit
        $surplusDefisit = $totalPendapatan - $totalBelanja;

        // Hitung Pembiayaan Netto (Penerimaan - Pengeluaran)
        $penerimaanPembiayaan = $pembiayaan->where('jenis', 'penerimaan')->sum('realisasi');
        $pengeluaranPembiayaan = $pembiayaan->where('jenis', 'pengeluaran')->sum('realisasi');
        $pembiayaanNetto = $penerimaanPembiayaan - $pengeluaranPembiayaan;

        // SILPA Awal dari tahun sebelumnya
        $tahunSebelumnya = TahunAnggaran::where('tahun', $tahun->tahun - 1)->first();
        $silpa_awal = 0;

        if ($tahunSebelumnya) {
            $silpa_awal = Pembiayaan::where('id_tahun_anggaran', $tahunSebelumnya->id_tahun_anggaran)
                ->where('nama', 'like', 'SILPA%')
                ->value('realisasi') ?? 0;
        }

        // Hitung SILPA Akhir = SILPA Awal + Surplus/Defisit + Pembiayaan Netto
        $silpa_akhir = $silpa_awal + $surplusDefisit + $pembiayaanNetto;

        return view('user.keuangan', compact(
            'tahun',
            'pendapatan',
            'belanja',
            'pembiayaan',
            'totalPendapatan',
            'totalBelanja',
            'surplusDefisit',
            'penerimaanPembiayaan',
            'pengeluaranPembiayaan',
            'pembiayaanNetto',
            'silpa_awal',
            'silpa_akhir'
        ));
    }
}
