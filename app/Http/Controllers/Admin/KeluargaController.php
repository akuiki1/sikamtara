<?php

namespace App\Http\Controllers\admin;

use Route;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Keluarga::with('penduduk');

        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->has('filter') && $request->filter !== '') {
            $query->where('status_tinggal', $request->filter);
        }

        $keluarga = $query->paginate(20)->appends($request->query());

        $transformed = collect($keluarga->items())->map(function ($item) {
            return [
                'kode_keluarga'     => $item->kode_keluarga,
                'kepala_keluarga'   => $item->kepala_keluarga,
                'alamat'            => $item->alamat,
                'rt'                => $item->rt,
                'rw'                => $item->rw,
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
        $validated = $request->validate([
            'kode_keluarga' => 'required|string|unique:keluargas,kode_keluarga',
            'kepala_keluarga' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'dusun' => 'nullable|string|max:100',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
        ]);

        Keluarga::create($validated);

        return redirect()->back()->with('success', 'Data keluarga berhasil ditambahkan!');
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
    public function update(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'kode_keluarga' => 'required|string|unique:keluargas,kode_keluarga,' . $keluarga->id,
            'kepala_keluarga' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'dusun' => 'nullable|string|max:100',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
        ]);

        $keluarga->update($validated);

        return redirect()->back()->with('success', 'Data keluarga berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keluarga $keluarga)
    {
        $keluarga->delete();

        return response()->json(['message' => 'Data keluarga berhasil dihapus']);
    }

    // public function __construct()
    // {
    //     // supaya route model binding pake kode_keluarga
    //     $this->middleware(function ($request, $next) {
    //         Route::bind('keluarga', function ($value) {
    //             return \App\Models\Keluarga::where('kode_keluarga', $value)->firstOrFail();
    //         });
    //         return $next($request);
    //     });
    // }
}
