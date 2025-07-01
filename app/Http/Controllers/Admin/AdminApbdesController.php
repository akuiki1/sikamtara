<?php

namespace App\Http\Controllers\Admin;

use App\Models\Belanja;
use App\Models\Pendapatan;
use Illuminate\Http\Request;
use App\Imports\APBDesImport;
use App\Models\TahunAnggaran;
use App\Models\RincianBelanja;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;


class AdminApbdesController extends Controller
{

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'tahun' => 'required|numeric|digits:4'
        ]);

        Excel::import(new APBDesImport($request->tahun), $request->file('file'));

        return back()->with('success', 'Data berhasil diimpor.');
    }

    /**
     * Display a listing of the resource.
     */
    public function dataAnggaran(Request $request)
    {
        $query = TahunAnggaran::orderBy('tahun', 'desc');

        if ($request->has('search')) {
            $query->where('tahun', 'like', '%' . $request->search . '%');
        }

        $tahun_anggaran = $query->paginate(6)->appends($request->query());

        $transformed = collect($tahun_anggaran->items())->map(function ($item) {
            $id_tahun = $item->id_tahun_anggaran;

            $totalPendapatan = DB::table('pendapatan')
                ->where('id_tahun_anggaran', $id_tahun)
                ->sum('anggaran');

            $totalBelanja = DB::table('rincian_belanja')
                ->where('id_tahun_anggaran', $id_tahun)
                ->sum('anggaran');

            $penerimaan = DB::table('pembiayaan')
                ->where('id_tahun_anggaran', $id_tahun)
                ->where('jenis', 'penerimaan')
                ->sum('anggaran');

            $pengeluaran = DB::table('pembiayaan')
                ->where('id_tahun_anggaran', $id_tahun)
                ->where('jenis', 'pengeluaran')
                ->sum('anggaran');

            $totalPembiayaan = $penerimaan - $pengeluaran;

            return [
                'id_tahun_anggaran' => $item->id_tahun_anggaran,
                'tahun'             => $item->tahun,
                'total_pendapatan'  => $totalPendapatan,
                'total_belanja'     => $totalBelanja,
                'total_pembiayaan'  => $totalPembiayaan,
            ];
        });


        return view('admin.apbdes.dataAnggaran', [
            'apbdes'   => $tahun_anggaran,
            'apbdesJs' => $transformed,
            'search'   => $request->search,
            'title'    => 'APBDes Tahun ' . now()->year,
        ]);
    }

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
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->back()->with('error', 'Tahun anggaran yang dimasukkan sudah tersedia.');
            }

            return redirect()->back()->with('error', 'Gagal menambahkan tahun anggaran: ' . $e->getMessage());
        }
    }

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
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->back()->with('error', 'Tahun anggaran yang dimasukkan sudah tersedia.');
            }

            return redirect()->back()->with('error', 'Gagal mengedit tahun anggaran: ' . $e->getMessage());
        }
    }

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


    /**
     * Display a pendapatan of the resource.
     */
    public function pendapatan(Request $request)
    {
        $tahunDipilih = $request->tahun;
        $tahunList = TahunAnggaran::orderBy('tahun', 'desc')->get();

        $data = [];

        if ($tahunDipilih) {
            $data = Pendapatan::with('tahunAnggaran')
                ->whereHas('tahunAnggaran', function ($query) use ($tahunDipilih) {
                    $query->where('tahun', $tahunDipilih);
                })->get();
        }

        $totalAnggaran = Pendapatan::whereHas('tahunAnggaran', fn($q) => $q->where('tahun', $tahunDipilih))->sum('anggaran');
        $totalRealisasi = Pendapatan::whereHas('tahunAnggaran', fn($q) => $q->where('tahun', $tahunDipilih))->sum('realisasi');
        $totalSelisih = $totalAnggaran - $totalRealisasi;


        return view('admin.apbdes.pendapatan', [
            'title' => 'Halaman Pendapatan',
            'tahunList' => $tahunList,
            'tahunDipilih' => $tahunDipilih,
            'data' => $data,
            'totalAnggaran' => $totalAnggaran,
            'totalRealisasi' => $totalRealisasi,
            'totalSelisih' => $totalSelisih,
        ]);
    }

    public function pendapatanStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'anggaran' => 'required|numeric',
            'realisasi' => 'required|numeric',
            'tahun' => 'required|integer'
        ]);

        $idTahun = TahunAnggaran::where('tahun', $request->tahun)->value('id_tahun_anggaran');

        if (!$idTahun) {
            return back()->withErrors(['tahun' => 'Tahun anggaran tidak valid']);
        }

        $anggaran = $request->anggaran;
        $realisasi = $request->realisasi;
        $selisih = $anggaran - $realisasi;

        Pendapatan::create([
            'nama' => $request->nama,
            'anggaran' => $anggaran,
            'realisasi' => $realisasi,
            'selisih' => $selisih,
            'id_tahun_anggaran' => $idTahun,
        ]);

        return redirect()->route('adminapbdes.pendapatan', ['tahun' => $request->tahun])
            ->with('success', 'Pendapatan berhasil ditambahkan.');
    }

    public function pendapatanUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'anggaran' => 'required|numeric',
            'realisasi' => 'required|numeric',
            'tahun' => 'required|integer'
        ]);

        $pendapatan = Pendapatan::findOrFail($id);
        $pendapatan->update([
            'nama' => $request->nama,
            'anggaran' => $request->anggaran,
            'realisasi' => $request->realisasi,
            'selisih' => $request->anggaran - $request->realisasi,
        ]);

        return redirect()->route('adminapbdes.pendapatan', ['tahun' => $request->tahun])
            ->with('success', 'Pendapatan berhasil diperbarui.');
    }

    public function pendapatanDestroy(Request $request, $id)
    {
        $pendapatan = Pendapatan::findOrFail($id);
        $pendapatan->delete();

        return redirect()->route('adminapbdes.pendapatan', ['tahun' => $request->tahun])
            ->with('success', 'Pendapatan berhasil dihapus.');
    }


    /**
     * Display a belanja of the resource.
     */
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

    public function bidangBelanjaStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Belanja::create([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Bidang berhasil ditambahkan!');
    }

    public function bidangBelanjaUpdate(Request $request)
    {
        $request->validate([
            'id_belanja' => 'required|exists:belanja,id_belanja',
            'nama' => 'required|string|max:255',
        ]);

        $bidang = Belanja::findOrFail($request->id_belanja);
        $bidang->nama = $request->nama;
        $bidang->save();

        return redirect()->back()->with('success', 'Bidang berhasil diperbarui!');
    }

    public function bidangBelanjaDestroy(Request $request)
    {
        try {
            $request->validate([
                'id_belanja' => 'required|exists:belanja,id_belanja',
            ]);

            $bidang = Belanja::where('id_belanja', $request->id_belanja)->firstOrFail();
            $bidang->delete();

            return redirect()->back()->with('success', 'Bidang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus bidang: ' . $e->getMessage());
        }
    }

    public function rincianBelanjaStore(Request $request)
    {
        $validated = $request->validate([
            'id_belanja' => 'required|exists:belanja,id_belanja',
            'id_tahun_anggaran' => 'required|exists:tahun_anggaran,id_tahun_anggaran',
            'nama' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:0',
            'realisasi' => 'required|numeric|min:0',
        ]);

        $validated['selisih'] = $validated['anggaran'] - $validated['realisasi'];

        RincianBelanja::create($validated);

        return redirect()->back()->with('success', 'Rincian belanja berhasil ditambahkan!');
    }

    public function rincianBelanjaUpdate(Request $request)
    {
        $request->validate([
            'id_rincian_belanja' => 'required|exists:rincian_belanja,id_rincian_belanja',
            'nama' => 'required|string|max:255',
            'anggaran' => 'nullable|numeric',
            'realisasi' => 'nullable|numeric',
        ]);

        $rincian = RincianBelanja::findOrFail($request->id_rincian_belanja);

        $rincian->update([
            'nama' => $request->nama,
            'anggaran' => str_replace(',', '.', $request->anggaran),
            'realisasi' => str_replace(',', '.', $request->realisasi),
            'selisih' => ($request->anggaran ?? 0) - ($request->realisasi ?? 0),
        ]);

        return redirect()->back()->with('success', 'Rincian berhasil diperbarui!');
    }

    public function rincianBelanjaDestroy(Request $request)
    {
        try {
            $request->validate([
                'id_rincian_belanja' => 'required|exists:rincian_belanja,id_rincian_belanja',
            ]);

            $rincian = RincianBelanja::findOrFail($request->id_rincian_belanja);
            $rincian->delete();

            return redirect()->back()->with('success', 'Rincian belanja berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus rincian belanja: ' . $e->getMessage());
        }
    }

    /**
     * Display a rekapitulasi of the resource.
     */
    public function rekapitulasi()
    {
        return view('admin.apbdes.rekapitulasi', [
            'title' => 'APBDes Tahun ' . now()->year,
        ]);
    }
}
