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

        return view('user.keuangan', compact('tahun', 'pendapatan', 'belanja', 'pembiayaan'));
    }
}
