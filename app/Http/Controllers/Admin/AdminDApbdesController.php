<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apbdes;
use App\Models\DetailApbdes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDApbdesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        return view('admin.apbdes.detail-apbdes', [
            'paginate'  => $paginate,
            'detailJs'  => $detailJs,
            'search'    => $request->search,
            'filter'    => $request->filter,
            'tahun'     => $tahun,
            'title'     => "Kelola Detail APBDes"
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_apbdes' => 'required|exists:apbdes,id_apbdes',
            'judul' => 'required|string|max:255',
            'sub_judul' => 'required|string',
            'anggaran' => 'required|numeric|min:0',
            'realisasi' => 'required|numeric|min:0',
            'kategori' => 'required|in:pendapatan,belanja,pembiayaan',
        ]);

        try {
            DetailApbdes::create([
                'id_apbdes' => $request->id_apbdes,
                'judul'     => $request->judul,
                'sub_judul' => $request->sub_judul,
                'anggaran'  => $request->anggaran,
                'realisasi' => $request->realisasi,
                'kategori'  => $request->kategori,
            ]);

            return redirect()->back()->with('success', 'Data APBDes berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_apbdes' => 'required|exists:apbdes,id_apbdes',
            'judul' => 'required|string|max:255',
            'sub_judul' => 'required|string',
            'anggaran' => 'required|numeric|min:0',
            'realisasi' => 'required|numeric|min:0',
            'kategori' => 'required|in:Pendapatan,Belanja,Pembiayaan',
        ]);

        try {
            $detail = DetailApbdes::findOrFail($id);
            $detail->update([
                'id_apbdes' => $request->id_apbdes,
                'judul'     => $request->judul,
                'sub_judul' => $request->sub_judul,
                'anggaran'  => $request->anggaran,
                'realisasi' => $request->realisasi,
                'kategori'  => $request->kategori,
            ]);

            return redirect()->back()->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengedit APBDes: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $apbdes = DetailApbdes::findOrFail($id);
            $apbdes->delete();

            return redirect()->back()->with('success', 'Data APBDes berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus APBDes: ' . $e->getMessage());
        }
    }
}
