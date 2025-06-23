<?php

namespace App\Http\Controllers\admin;

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
        $query = TahunAnggaran::query();

        if ($request->has('search')) {
            $query->where('tahun', 'like', '%' . $request->search . '%');
        }

        $tahun_anggaran = $query->paginate(10)->appends($request->query());

        // Transformasi data jadi JS-ready
        $transformed = collect($tahun_anggaran->items())->map(function ($item) {
            $id_tahun = DB::table('tahun_anggaran')->where('tahun', $item->tahun)->value('id_tahun_anggaran');

            $totalPendapatan = DB::table('rincian_anggaran')
                ->join('sub_kategori_anggaran', 'rincian_anggaran.id_sub_kategori_anggaran', '=', 'sub_kategori_anggaran.id_sub_kategori_anggaran')
                ->join('kategori_anggaran', 'sub_kategori_anggaran.id_kategori_anggaran', '=', 'kategori_anggaran.id_kategori_anggaran')
                ->where('kategori_anggaran.nama', 'Pendapatan')
                ->where('rincian_anggaran.id_tahun_anggaran', $id_tahun)
                ->sum('anggaran');

            $totalBelanja = DB::table('rincian_anggaran')
                ->join('sub_kategori_anggaran', 'rincian_anggaran.id_sub_kategori_anggaran', '=', 'sub_kategori_anggaran.id_sub_kategori_anggaran')
                ->join('kategori_anggaran', 'sub_kategori_anggaran.id_kategori_anggaran', '=', 'kategori_anggaran.id_kategori_anggaran')
                ->where('kategori_anggaran.nama', 'Belanja')
                ->where('rincian_anggaran.id_tahun_anggaran', $id_tahun)
                ->sum('anggaran');

            $penerimaan = DB::table('penerimaan_pembiayaan')->where('id_tahun_anggaran', $id_tahun)->sum('nilai');
            $pengeluaran = DB::table('pengeluaran_pembiayaan')->where('id_tahun_anggaran', $id_tahun)->sum('nilai');
            $totalPembiayaan = $penerimaan - $pengeluaran;

            return [
                'id_tahun_anggaran' => $item->id_tahun_anggaran,
                'tahun'             => $item->tahun,
                'total_pendapatan'  => $totalPendapatan,
                'total_belanja'     => $totalBelanja,
                'total_pembiayaan'  => $totalPembiayaan,
            ];
        });

        // Berikan kembali hasil transformasi ke Blade via JS
        return view('admin.apbdes.dataAnggaran', [
            'apbdes'   => $tahun_anggaran,
            'apbdesJs' => $transformed,
            'search'   => $request->search,
            'title'    => 'APBDes Tahun ' . now()->year,
        ]);
    }

    public function pendapatan($id_tahun_anggaran)
    {
        // Ambil tahun dari id_tahun_anggaran
        $tahun = DB::table('tahun_anggaran')->where('id_tahun_anggaran', $id_tahun_anggaran)->value('tahun');

        // Ambil rincian pendapatan berdasarkan id_tahun
        $pendapatan = DB::table('rincian_anggaran')
            ->join('sub_kategori_anggaran', 'rincian_anggaran.id_sub_kategori_anggaran', '=', 'sub_kategori_anggaran.id_sub_kategori_anggaran')
            ->join('kategori_anggaran', 'sub_kategori_anggaran.id_kategori_anggaran', '=', 'kategori_anggaran.id_kategori_anggaran')
            ->where('kategori_anggaran.nama', 'Pendapatan')
            ->where('rincian_anggaran.id_tahun_anggaran', $id_tahun_anggaran)
            ->select(
                'rincian_anggaran.id_rincian_anggaran',
                'rincian_anggaran.nama',
                'rincian_anggaran.anggaran',
                'rincian_anggaran.realisasi',
                DB::raw('(rincian_anggaran.anggaran - rincian_anggaran.realisasi) as selisih')
            )
            ->get();

        $pendapatanJs = $pendapatan->map(function ($item) use ($tahun) {
            $id_tahun = DB::table('tahun_anggaran')->where('tahun', $item->tahun)->value('id_tahun_anggaran');
            return [
                'id' => $item->id_rincian,
                'nama' => $item->nama,
                'anggaran' => $item->anggaran,
                'realisasi' => $item->realisasi,
                'selisih' => $item->selisih,
                'tahun' => $tahun,
            ];
        });

        $tahunList = DB::table('tahun_anggaran')
            ->orderByDesc('tahun')
            ->select('id_tahun_anggaran as id', 'tahun')
            ->get();

        $tahunAktif = DB::table('tahun_anggaran')->where('id_tahun_anggaran', $id_tahun_anggaran)->value('tahun');

        return view('admin.apbdes.pendapatan', [
            'pendapatanJs' => $pendapatanJs,
            'tahunListJs' => $tahunList,
            'tahunAktif'        => $tahunAktif,
            'tahun' => $tahun,
            'title' => 'APBDes Tahun ' . now()->year
        ]);
    }

    public function pendapatanTerbaru()
    {
        $id_terbaru = DB::table('tahun_anggaran')
            ->orderByDesc('tahun')
            ->value('id_tahun_anggaran');

        return redirect()->route('admin.apbdes.pendapatan', $id_terbaru);
    }



    public function belanja($id_tahun_anggaran)
    {
        // Ambil tahun dari id_tahun_anggaran
        $tahun = DB::table('tahun_anggaran')->where('id_tahun_anggaran', $id_tahun_anggaran)->value('tahun');

        // Ambil rincian pendapatan berdasarkan id_tahun
        $pendapatan = DB::table('rincian_anggaran')
            ->join('sub_kategori_anggaran', 'rincian_anggaran.id_sub_kategori_anggaran', '=', 'sub_kategori_anggaran.id_sub_kategori_anggaran')
            ->join('kategori_anggaran', 'sub_kategori_anggaran.id_kategori_anggaran', '=', 'kategori_anggaran.id_kategori_anggaran')
            ->where('kategori_anggaran.nama', 'Pendapatan')
            ->where('rincian_anggaran.id_tahun_anggaran', $id_tahun_anggaran)
            ->select(
                'rincian_anggaran.id_rincian_anggaran',
                'rincian_anggaran.nama',
                'rincian_anggaran.anggaran',
                'rincian_anggaran.realisasi',
                DB::raw('(rincian_anggaran.anggaran - rincian_anggaran.realisasi) as selisih')
            )
            ->get();

        $pendapatanJs = $pendapatan->map(function ($item) use ($tahun) {
            $id_tahun = DB::table('tahun_anggaran')->where('tahun', $item->tahun)->value('id_tahun_anggaran');
            return [
                'id' => $item->id_rincian,
                'nama' => $item->nama,
                'anggaran' => $item->anggaran,
                'realisasi' => $item->realisasi,
                'selisih' => $item->selisih,
                'tahun' => $tahun,
            ];
        });

        $tahunList = DB::table('tahun_anggaran')
            ->orderByDesc('tahun')
            ->select('id_tahun_anggaran as id', 'tahun')
            ->get();

        $tahunAktif = DB::table('tahun_anggaran')->where('id_tahun_anggaran', $id_tahun_anggaran)->value('tahun');

        return view('admin.apbdes.belanja', [
            'pendapatanJs' => $pendapatanJs,
            'tahunListJs' => $tahunList,
            'tahunAktif'        => $tahunAktif,
            'tahun' => $tahun,
            'title' => 'APBDes Tahun ' . now()->year
        ]);
    }

    public function belanjaTerbaru()
    {
        $id_terbaru = DB::table('tahun_anggaran')
            ->orderByDesc('tahun')
            ->value('id_tahun_anggaran');

        return redirect()->route('admin.apbdes.belanja', $id_terbaru);
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
            TahunAnggaran::create([
                'tahun' => $request->tahun,
            ]);

            return redirect()->back()->with('success', 'Tahun Anggaran Baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan Tahun Anggaran: ' . $e->getMessage());
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
            $tahun_anggaran = TahunAnggaran::findOrFail($id);
            $tahun_anggaran->update([
                'tahun' => $request->tahun,
            ]);

            return redirect()->back()->with('success', 'Data tahun anggaran berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengedit tahun anggaran: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $tahun_anggaran = TahunAnggaran::findOrFail($id);
            $tahun_anggaran->delete();

            return redirect()->back()->with('success', 'Data tahun anggaran berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus tahun anggaran: ' . $e->getMessage());
        }
    }
}
