<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apbdes;
use App\Models\DetailApbdes;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        // Ambil ID Apbdes berdasarkan tahun
        $apbdes = Apbdes::where('tahun', $tahun)->first();

        $detail = collect();

        if ($apbdes) {
            $detail = DetailApbdes::where('id_apbdes', $apbdes->id)->get();
        }

        return view('user.keuangan', [
            'tahun'      => $tahun,
            'tahunList'  => Apbdes::pluck('tahun'),
            'pendapatan' => $detail->where('kategori', 'pendapatan'),
            'belanja'    => $detail->where('kategori', 'belanja'),
            'pembiayaan' => $detail->where('kategori', 'pembiayaan'),
        ]);
    }


    public function export(Request $request)
    {
        $tahun = $request->input('tahun');
        return Excel::download(new ApbdesExport($tahun), "apbdes-{$tahun}.xlsx");
    }
}
