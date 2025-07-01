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

        // Ambil tahun, jika tidak ada -> null (tidak pakai firstOrFail)
        $tahun = TahunAnggaran::when($idTahun, function ($query) use ($idTahun) {
            return $query->where('id_tahun_anggaran', $idTahun);
        }, function ($query) {
            return $query->orderByDesc('tahun');
        })->first();

        // Jika tidak ada tahun sama sekali
        if (!$tahun) {
            return view('user.keuangan', [
                'tahun' => null,
                'pendapatan' => collect(),
                'belanja' => collect(),
                'pembiayaan' => collect(),
                'totalPendapatan' => 0,
                'totalBelanja' => 0,
                'surplusDefisit' => 0,
                'penerimaanPembiayaan' => 0,
                'pengeluaranPembiayaan' => 0,
                'pembiayaanNetto' => 0,
                'silpa_awal' => 0,
                'silpa_akhir' => 0,
            ]);
        }

        // Data keuangan (boleh kosong)
        $pendapatan = Pendapatan::where('id_tahun_anggaran', $tahun->id_tahun_anggaran)->get();

        $belanja = Belanja::with(['rincianBelanja' => function ($q) use ($tahun) {
            $q->where('id_tahun_anggaran', $tahun->id_tahun_anggaran);
        }])->get();

        $pembiayaan = Pembiayaan::where('id_tahun_anggaran', $tahun->id_tahun_anggaran)->get();

        // Total Pendapatan
        $totalPendapatan = $pendapatan->sum('realisasi');

        // Total Belanja dari semua rincian
        $totalBelanja = $belanja->flatMap->rincianBelanja->sum('realisasi');

        // Hitung Surplus/Defisit
        $surplusDefisit = $totalPendapatan - $totalBelanja;

        // Hitung Pembiayaan Netto
        $penerimaanPembiayaan = $pembiayaan->where('jenis', 'penerimaan')->sum('realisasi');
        $pengeluaranPembiayaan = $pembiayaan->where('jenis', 'pengeluaran')->sum('realisasi');
        $pembiayaanNetto = $penerimaanPembiayaan - $pengeluaranPembiayaan;

        // SILPA awal
        $tahunSebelumnya = TahunAnggaran::where('tahun', $tahun->tahun - 1)->first();
        $silpa_awal = 0;

        if ($tahunSebelumnya) {
            $silpa_awal = Pembiayaan::where('id_tahun_anggaran', $tahunSebelumnya->id_tahun_anggaran)
                ->where('nama', 'like', 'SILPA%')
                ->value('realisasi') ?? 0;
        }

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
