<?php

namespace App\Http\Controllers\admin;

use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Penduduk::with('keluarga');

        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->has('filter') && $request->filter !== '') {
            $query->where('status_tinggal', $request->filter);
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
                'alamat'            => $item->keluarga->alamat ?? 'Alamat tidak ada',
                'rt'                => $item->rt,
                'rw'                => $item->rw,
                'status'            => $item->status_tinggal,
            ];
        });

        return view('admin.penduduk.penduduk', [
            'penduduk'      => $penduduk,
            'pendudukJs'    => $transformed,
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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
