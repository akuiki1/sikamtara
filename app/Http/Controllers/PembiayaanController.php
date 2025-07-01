<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAnggaran;
use App\Models\Pembiayaan;

class PembiayaanController extends Controller
{
    private function hitungTotal($collection)
    {
        return [
            'anggaran' => $collection->sum('anggaran'),
            'realisasi' => $collection->sum('realisasi'),
            'selisih' => $collection->sum('selisih'),
        ];
    }

    public function index(Request $request)
    {
        $tahunDipilih = $request->tahun;
        $tahunList = TahunAnggaran::orderByDesc('tahun')->get();

        $pembiayaan = collect();

        if ($tahunDipilih) {
            $pembiayaan = Pembiayaan::whereHas('tahunAnggaran', function ($q) use ($tahunDipilih) {
                $q->where('tahun', $tahunDipilih);
            })->get();
        }

        $penerimaan = $pembiayaan->where('jenis', 'penerimaan');
        $pengeluaran = $pembiayaan->where('jenis', 'pengeluaran');

        return view('admin.apbdes.pembiayaan', [
            'title' => 'Pembiayaan',
            'tahunList' => $tahunList,
            'tahunDipilih' => $tahunDipilih,
            'pembiayaan' => $pembiayaan,
            'totalPenerimaan' => $this->hitungTotal($penerimaan),
            'totalPengeluaran' => $this->hitungTotal($pengeluaran),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:penerimaan,pengeluaran',
            'anggaran' => 'required|numeric|min:0',
            'realisasi' => 'required|numeric|min:0',
            'id_tahun_anggaran' => 'required|exists:tahun_anggaran,id_tahun_anggaran',
        ]);

        Pembiayaan::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'anggaran' => $request->anggaran,
            'realisasi' => $request->realisasi,
            'id_tahun_anggaran' => $request->id_tahun_anggaran,
        ]);

        $tahun = TahunAnggaran::find($request->id_tahun_anggaran)?->tahun;

        return redirect()->route('adminapbdes.pembiayaan', ['tahun' => $tahun])
            ->with('success', 'Data pembiayaan berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_pembiayaan' => 'required|exists:pembiayaan,id_pembiayaan',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:penerimaan,pengeluaran',
            'anggaran' => 'required|numeric|min:0',
            'realisasi' => 'required|numeric|min:0',
            'id_tahun_anggaran' => 'required|exists:tahun_anggaran,id_tahun_anggaran',
        ]);

        $pembiayaan = Pembiayaan::findOrFail($request->id_pembiayaan);
        $pembiayaan->update([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'anggaran' => $request->anggaran,
            'realisasi' => $request->realisasi,
            'id_tahun_anggaran' => $request->id_tahun_anggaran,
        ]);

        $tahun = TahunAnggaran::find($request->id_tahun_anggaran)?->tahun;

        return redirect()->route('adminapbdes.pembiayaan', ['tahun' => $tahun])
            ->with('success', 'Data pembiayaan berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_pembiayaan' => 'required|exists:pembiayaan,id_pembiayaan',
        ]);

        $pembiayaan = Pembiayaan::findOrFail($request->id_pembiayaan);
        $tahun = $pembiayaan->tahunAnggaran?->tahun;

        $pembiayaan->delete();

        return redirect()->route('adminapbdes.pembiayaan', ['tahun' => $tahun])
            ->with('success', 'Data pembiayaan berhasil dihapus.');
    }
}
