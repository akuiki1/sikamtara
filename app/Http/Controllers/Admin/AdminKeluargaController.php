<?php

namespace App\Http\Controllers\Admin;

use Route;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Keluarga::with('penduduk');

        if ($request->has('search')) {
            $search = $request->search;

            $query->where('kode_keluarga', 'like', '%' . $search . '%')
                ->orWhereHas('kepalaKeluarga', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%');
                });
        }


        $keluarga = $query->paginate(10)->appends($request->query());

        $transformed = collect($keluarga->items())->map(function ($item) {
            return [
                'kode_keluarga'       => $item->kode_keluarga,
                'kepala_keluarga'     => $item->kepalaKeluarga ? $item->kepalaKeluarga->nama : null,
                'nik_kepala_keluarga' => $item->nik_kepala_keluarga,
                'alamat'              => $item->alamat,
                'rt'                  => $item->rt,
                'rw'                  => $item->rw,
                'anggota'             => $item->penduduk->map(function ($anggota) {
                    return [
                        'nik'            => $anggota->nik,
                        'nama'           => $anggota->nama,
                        'hubungan'       => $anggota->hubungan,
                    ];
                }),
            ];
        });

        return view('admin.penduduk.keluarga', [
            'keluarga'      => $keluarga,
            'keluargaJs'    => $transformed,
            'search'        => $request->search,
            'filter'        => $request->filter,
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
                'kode_keluarga' => 'required|digits:16|unique:keluarga,kode_keluarga',
                'nik_kepala_keluarga' => 'required|digits:16',
                'alamat' => 'required|string',
                'rt' => 'required|digits:3',
                'rw' => 'required|digits:3',
            ]);

            Keluarga::create($validated);

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_keluarga)
    {
        try {
            $keluarga = Keluarga::where('kode_keluarga', $kode_keluarga)->firstOrFail();
            $keluarga->update($request->all());

            // Balik ke halaman utama keluarga aja
            return redirect()->to('/admin/keluarga?search=' . $kode_keluarga)->with('success', 'Data keluarga berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->to('/admin/keluarga?search=' . $kode_keluarga)->with('error', 'Gagal: ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_keluarga)
    {
        try {
            Keluarga::where('kode_keluarga', $kode_keluarga)->delete();

            return redirect()->back()->with('success', 'Data keluarga berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
