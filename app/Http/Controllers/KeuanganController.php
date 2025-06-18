<?php

namespace App\Http\Controllers;

use App\Models\Apbdes;
use App\Models\DetailApbdes;
use Illuminate\Http\Request;
use App\Exports\ApbdesExport;
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
                'anggaran' => (float) $item->anggaran,
                'realisasi' => (float) $item->realisasi,

            ];
        });


        $tahunOptions = Apbdes::select('id_apbdes', 'tahun')->orderByDesc('tahun')->get();
        $tahunTerbaru = $tahunOptions->first()?->tahun ?? now()->year;

        // Kelompokkan data belanja berdasarkan sub_judul
        $groupedBelanja = $detailJs->where('kategori', 'belanja')
            ->groupBy('sub_judul')
            ->map(function ($items, $judul) {
                return [
                    'judul' => $judul,
                    'children' => $items->values()
                ];
            })->values(); // values() untuk reset key ke numeric


        return view('user.keuangan', [
            'paginate'  => $paginate,
            'groupedBelanja' => $groupedBelanja->toArray(),
            'detailJs' => $detailJs->toArray(),
            'search'    => $request->search,
            'filter'    => $request->filter,
            'tahun'         => $tahunOptions,
            'tahunTerbaru'  => $tahunTerbaru,
            'title'     => "Kelola Detail APBDes"
        ]);
    }


    public function export(Request $request)
    {
        $tahun = $request->input('tahun');
        return Excel::download(new ApbdesExport($tahun), "apbdes-{$tahun}.xlsx");
    }
}
