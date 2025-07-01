<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pembiayaan;
use App\Models\Pendapatan;
use Illuminate\Http\Request;
use App\Models\TahunAnggaran;
use App\Models\RincianBelanja;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        $gambarSlides = Berita::whereNotNull('gambar_cover')
            ->latest()
            ->take(5)
            ->pluck('gambar_cover');

        // Ambil semua tahun untuk dropdown
        $daftarTahun = TahunAnggaran::orderByDesc('tahun')->get();

        // Filter tahun berdasarkan input, default: tahun terbaru
        $idTahun = $request->input('tahun');

        $tahun = TahunAnggaran::when($idTahun, function ($query) use ($idTahun) {
            return $query->where('id_tahun_anggaran', $idTahun);
        }, function ($query) {
            return $query->orderByDesc('tahun');
        })->firstOrFail();

        // Data Keuangan
        $pendapatan = Pendapatan::where('id_tahun_anggaran', $tahun->id_tahun_anggaran)->sum('realisasi');

        $belanja = RincianBelanja::where('id_tahun_anggaran', $tahun->id_tahun_anggaran)->sum('realisasi');

        $pembiayaan = Pembiayaan::where('id_tahun_anggaran', $tahun->id_tahun_anggaran)->get();

        $surplusDefisit = $pendapatan - $belanja;

        $penerimaanPembiayaan = $pembiayaan->where('jenis', 'penerimaan')->sum('realisasi');
        $pengeluaranPembiayaan = $pembiayaan->where('jenis', 'pengeluaran')->sum('realisasi');
        $pembiayaanNetto = $penerimaanPembiayaan - $pengeluaranPembiayaan;

        // Hitung SILPA dari tahun sebelumnya
        $tahunSebelumnya = TahunAnggaran::where('tahun', $tahun->tahun - 1)->first();
        $silpa_awal = 0;
        if ($tahunSebelumnya) {
            $silpa_awal = Pembiayaan::where('id_tahun_anggaran', $tahunSebelumnya->id_tahun_anggaran)
                ->where('nama', 'like', 'SILPA%')
                ->value('realisasi') ?? 0;
        }

        $silpa_akhir = $silpa_awal + $surplusDefisit + $pembiayaanNetto;

        // Ambil berita terbaru
        $berita = Berita::where('status', 'published')->orderByDesc('tanggal_publish')->paginate(6);

        return view('welcome', [
            'gambarSlides' => $gambarSlides,
            'daftarTahun' => $daftarTahun,
            'tahun' => $tahun,
            'pendapatan' => $pendapatan,
            'totalBelanja' => $belanja,
            'surplusDefisit' => $surplusDefisit,
            'pembiayaanNetto' => $pembiayaanNetto,
            'silpa_akhir' => $silpa_akhir,
            'berita' => $berita,
        ]);
    }
    public function ringkasanTahun(Request $request)
    {
        $idTahun = $request->input('tahun');
        $tahun = TahunAnggaran::where('id_tahun_anggaran', $idTahun)->firstOrFail();

        $pendapatan = Pendapatan::where('id_tahun_anggaran', $idTahun)->sum('realisasi');
        $belanja = RincianBelanja::where('id_tahun_anggaran', $idTahun)->sum('realisasi');
        $pembiayaan = Pembiayaan::where('id_tahun_anggaran', $idTahun)->get();

        $surplusDefisit = $pendapatan - $belanja;
        $penerimaanPembiayaan = $pembiayaan->where('jenis', 'penerimaan')->sum('realisasi');
        $pengeluaranPembiayaan = $pembiayaan->where('jenis', 'pengeluaran')->sum('realisasi');
        $pembiayaanNetto = $penerimaanPembiayaan - $pengeluaranPembiayaan;

        $tahunSebelumnya = TahunAnggaran::where('tahun', $tahun->tahun - 1)->first();
        $silpa_awal = 0;
        if ($tahunSebelumnya) {
            $silpa_awal = Pembiayaan::where('id_tahun_anggaran', $tahunSebelumnya->id_tahun_anggaran)
                ->where('nama', 'like', 'SILPA%')->value('realisasi') ?? 0;
        }

        $silpa_akhir = $silpa_awal + $surplusDefisit + $pembiayaanNetto;

        return response()->json([
            'tahun' => $tahun->tahun,
            'pendapatan' => $pendapatan,
            'belanja' => $belanja,
            'surplusDefisit' => $surplusDefisit,
            'pembiayaanNetto' => $pembiayaanNetto,
            'silpa_akhir' => $silpa_akhir,
        ]);
    }
}
