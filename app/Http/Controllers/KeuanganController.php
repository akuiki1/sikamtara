<?php

namespace App\Http\Controllers;

use App\Models\Apbdes;
use App\Models\DetailApbdes;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = DetailApbdes::with('apbdes');

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('filter')) {
            $query->where('kategori', $request->filter);
        }

        $paginate = $query->paginate(10)->appends($request->query());

        $detailJs = collect($paginate->items())->map(function ($item) {
            return [
                'id_rincian' => $item->id_rincian,
                'tahun'      => optional($item->apbdes)->tahun,
                'kategori'   => $item->kategori,
                'judul'      => $item->judul,
                'sub_judul'  => $item->sub_judul,
                'anggaran' => 'Rp ' . number_format($item->anggaran, 2, ',', '.'),
                'realisasi' => 'Rp ' . number_format($item->realisasi, 2, ',', '.'),
            ];
        });

        $tahun = Apbdes::select('id_apbdes', 'tahun')->orderByDesc('tahun')->get();

        return view('user.keuangan', [
            'paginate'  => $paginate,
            'detailJs'  => $detailJs,
            'search'    => $request->search,
            'filter'    => $request->filter,
            'tahun'     => $tahun,
            'title'     => "Kelola Detail APBDes"
        ]);
    }


    public function export(Request $request)
    {
        $tahun = $request->input('tahun');
        return Excel::download(new ApbdesExport($tahun), "apbdes-{$tahun}.xlsx");
    }
}
