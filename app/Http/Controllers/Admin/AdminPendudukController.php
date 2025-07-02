<?php

namespace App\Http\Controllers\Admin;

use App\Models\Keluarga;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Penduduk::with('keluarga');

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }

        $penduduk = $query->paginate(10)->appends($request->query());

        $transformed = collect($penduduk->items())->map(function ($item) {
            return [
                'nik'               => $item->nik,
                'nama'              => $item->nama,
                'tempat_lahir'      => $item->tempat_lahir,
                'tanggal_lahir'     => $item->tanggal_lahir,
                'jenis_kelamin'     => $item->jenis_kelamin,
                'agama'             => $item->agama,
                'pendidikan'        => $item->pendidikan,
                'pekerjaan'         => $item->pekerjaan,
                'status_perkawinan' => $item->status_perkawinan,
                'golongan_darah'    => $item->golongan_darah,
                'hubungan'          => $item->hubungan,
                'kewarganegaraan'   => $item->kewarganegaraan,
                'kode_keluarga'     => $item->kode_keluarga,
                'status_tinggal'    => $item->status_tinggal,
                'alamat'            => optional($item->keluarga)->alamat,
                'rt'                => optional($item->keluarga)->rt,
                'rw'                => optional($item->keluarga)->rw,
            ];
        });

        $daftar_keluarga = Keluarga::select('kode_keluarga')->get();

        return view('admin.penduduk.penduduk', [
            'penduduk'        => $penduduk,
            'pendudukJs'      => $transformed,
            'search'          => $request->search,
            'filter'          => $request->filter,
            'daftar_keluarga' => $daftar_keluarga, // ini dia!
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
        try {
            $validated = $request->validate([
                'nik' => 'required|numeric|unique:penduduk,nik',
                'nama' => 'nullable|string|max:255',
                'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
                'tempat_lahir' => 'nullable|string|max:100',
                'tanggal_lahir' => 'nullable|date',
                'agama' => 'nullable|string|max:50',
                'pendidikan' => 'nullable|string|max:100',
                'pekerjaan' => 'nullable|string|max:100',
                'status_perkawinan' => 'nullable|string|max:50',
                'golongan_darah' => 'nullable|string|max:10',
                'kewarganegaraan' => 'nullable|string|max:100',
                'hubungan' => 'nullable|string|max:50',
                'kode_keluarga' => 'required|string|size:16',
                'status_tinggal' => 'nullable|string|max:50',
            ]);

            Penduduk::create($validated);

            return redirect()->back()->with('success', 'Kode keluarga berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
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
    public function edit(Request $request, $nik) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nik)
    {
        $penduduk = Penduduk::where('nik', $nik)->firstOrFail();

        // Update data
        $penduduk->update($request->all());

        // Redirect ke halaman dengan search berdasarkan NIK
        return redirect()->to('/admin/penduduk?search=' . $nik)
            ->with('success', 'Data berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($nik)
    {
        try {
            Penduduk::where('nik', $nik)->delete();

            return redirect()->back()->with('success', 'Data keluarga berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
