<?php

namespace App\Http\Controllers\admin;

use App\Models\Apbdes;
use Illuminate\Http\Request;
use App\Models\TahunAnggaran;
use App\Models\RincianAnggaran;
use App\Models\KategoriAnggaran;
use App\Http\Controllers\Controller;
use App\Models\PenerimaanPembiayaan;
use App\Models\PengeluaranPembiayaan;
use Illuminate\Support\Facades\DB;


class AdminApbdesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dataAnggaran(Request $request)
    {
        $query = Apbdes::query();

        if ($request->has('search')) {
            $query->where('tahun', 'like', '%' . $request->search . '%');
        }

        $apbdes = $query->paginate(10)->appends($request->query());

        // Transformasi data jadi JS-ready
        $transformed = collect($apbdes->items())->map(function ($item) {
            $id_tahun = DB::table('tahun_anggaran')->where('tahun', $item->tahun)->value('id_tahun_anggaran');

            $totalPendapatan = DB::table('rincian_anggaran')
                ->join('sub_kategori_anggaran', 'rincian_anggaran.sub_kategori_id', '=', 'sub_kategori_anggaran.id_sub_kategori_anggaran')
                ->join('kategori_anggaran', 'sub_kategori_anggaran.kategori_id', '=', 'kategori_anggaran.id_kategori_anggaran')
                ->where('kategori_anggaran.nama', 'Pendapatan')
                ->where('rincian_anggaran.id_tahun_anggaran', $id_tahun)
                ->sum('anggaran');

            $totalBelanja = DB::table('rincian_anggaran')
                ->join('sub_kategori_anggaran', 'rincian_anggaran.sub_kategori_id', '=', 'sub_kategori_anggaran.id_sub_kategori_anggaran')
                ->join('kategori_anggaran', 'sub_kategori_anggaran.kategori_id', '=', 'kategori_anggaran.id_kategori_anggaran')
                ->where('kategori_anggaran.nama', 'Belanja')
                ->where('rincian_anggaran.id_tahun_anggaran', $id_tahun)
                ->sum('anggaran');

            $penerimaan = DB::table('penerimaan_pembiayaan')->where('id_tahun_anggaran', $id_tahun)->sum('nilai');
            $pengeluaran = DB::table('pengeluaran_pembiayaan')->where('id_tahun_anggaran', $id_tahun)->sum('nilai');
            $totalPembiayaan = $penerimaan - $pengeluaran;

            return [
                'id_apbdes'         => $item->id_apbdes,
                'tahun'             => $item->tahun,
                'total_pendapatan'  => $totalPendapatan,
                'total_belanja'     => $totalBelanja,
                'total_pembiayaan'  => $totalPembiayaan,
            ];
        });

        // Berikan kembali hasil transformasi ke Blade via JS
        return view('admin.apbdes.dataAnggaran', [
            'apbdes'   => $apbdes,
            'apbdesJs' => $transformed,
            'search'   => $request->search,
            'title'    => 'APBDes Tahun ' . now()->year,
        ]);
    }



    public function pendapatan()
    {
        return view('admin.apbdes.pendapatan', [
            'title' => 'APBDes Tahun ' . now()->year,
        ]);
    }
    public function belanja()
    {
        return view('admin.apbdes.belanja', [
            'title' => 'APBDes Tahun ' . now()->year,
        ]);
    }
    public function pembiayaan()
    {
        return view('admin.apbdes.pembiayaan', [
            'title' => 'APBDes Tahun ' . now()->year,
        ]);
    }
    public function rekapitulasi()
    {
        return view('admin.apbdes.rekapitulasi', [
            'title' => 'APBDes Tahun ' . now()->year,
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
            'tahun' => 'required|digits:4|integer',
        ]);

        try {
            Apbdes::create([
                'tahun' => $request->tahun,
            ]);

            return redirect()->back()->with('success', 'Apbdes Baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan APBDes: ' . $e->getMessage());
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
            'tahun' => 'required|digits:4|integer',
        ]);

        try {
            $apbdes = Apbdes::findOrFail($id);
            $apbdes->update([
                'tahun' => $request->tahun,
            ]);

            return redirect()->back()->with('success', 'Data APBDes berhasil diperbarui!');
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
            $apbdes = Apbdes::findOrFail($id);
            $apbdes->delete();

            return redirect()->back()->with('success', 'Data APBDes berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus APBDes: ' . $e->getMessage());
        }
    }
}
