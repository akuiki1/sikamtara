<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\TahunAnggaran;
use App\Models\RincianAnggaran;
use App\Models\KategoriAnggaran;
use App\Http\Controllers\Controller;
use App\Models\Belanja;
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

    public function pendapatan(Request $request)
    {
        $tahunDipilih = $request->tahun;
        $tahunList = TahunAnggaran::orderBy('tahun', 'desc')->get();

        $data = [];

        if ($tahunDipilih) {
            $data = Belanja::with(['rincianBelanja' => function ($query) use ($tahunDipilih) {
                $query->whereHas('tahunAnggaran', function ($q) use ($tahunDipilih) {
                    $q->where('tahun', $tahunDipilih);
                });
            }])->get();
        }

        return view('admin.apbdes.pendapatan', [
            'title' => 'Halaman Pendapatan',
            'tahunList' => $tahunList,
            'tahunDipilih' => $tahunDipilih,
            'data' => $data,
        ]);
    }

    public function belanja(Request $request)
    {
        $tahunDipilih = $request->tahun;
        $tahunList = TahunAnggaran::orderBy('tahun', 'desc')->get();

        $data = [];

        if ($tahunDipilih) {
            $data = Belanja::with(['rincianBelanja' => function ($query) use ($tahunDipilih) {
                $query->whereHas('tahunAnggaran', function ($q) use ($tahunDipilih) {
                    $q->where('tahun', $tahunDipilih);
                });
            }])->get();
        }

        return view('admin.apbdes.belanja', [
            'title' => 'Halaman Belanja',
            'tahunList' => $tahunList,
            'tahunDipilih' => $tahunDipilih,
            'data' => $data,
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
