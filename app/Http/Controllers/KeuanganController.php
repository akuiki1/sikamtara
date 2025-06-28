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

        // Ambil tahun berdasarkan ID yang dikirim, atau fallback ke tahun terbaru
        $tahun = TahunAnggaran::when($idTahun, function ($query) use ($idTahun) {
            return $query->where('id_tahun_anggaran', $idTahun);
        }, function ($query) {
            return $query->orderByDesc('tahun');
        })->firstOrFail();

        // Ambil data berdasarkan tahun
        $pendapatan = Pendapatan::where('id_tahun_anggaran', $tahun->id_tahun_anggaran)->get();

        $belanja = Belanja::with(['rincianBelanja' => function ($q) use ($tahun) {
            $q->where('id_tahun_anggaran', $tahun->id_tahun_anggaran);
        }])->get();

        $pembiayaan = Pembiayaan::where('id_tahun_anggaran', $tahun->id_tahun_anggaran)->get();

        // Hitung total berdasarkan jenis
        $penerimaan = $pembiayaan->where('jenis', 'penerimaan')->sum('realisasi');
        $pengeluaran = $pembiayaan->where('jenis', 'pengeluaran')->sum('realisasi');
        $netto = $penerimaan - $pengeluaran;

        // Hitung total belanja (dari semua rincian)
        $totalBelanja = $belanja->flatMap->rincianBelanja->sum('realisasi');

        // Cari SILPA tahun sebelumnya
        $tahunSebelumnya = TahunAnggaran::where('tahun', $tahun->tahun - 1)->first();
        $silpa_awal = 0;

        if ($tahunSebelumnya) {
            $silpa_awal = Pembiayaan::where('id_tahun_anggaran', $tahunSebelumnya->id_tahun_anggaran)
                ->where('nama', 'like', 'SILPA%')
                ->value('realisasi') ?? 0;
        }

        // Hitung SILPA akhir
        $silpa_akhir = $silpa_awal + $netto;

        return view('user.keuangan', compact(
            'tahun',
            'pendapatan',
            'belanja',
            'pembiayaan',
            'penerimaan',
            'pengeluaran',
            'netto',
            'totalBelanja',
            'silpa_awal',
            'silpa_akhir'
        ));
    }
}
