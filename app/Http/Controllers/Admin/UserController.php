<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('penduduk');

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->search . '%')
                    ->orWhereHas('penduduk', function ($p) use ($request) {
                        $p->where('nama', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $user = $query->paginate(10)->appends($request->query());

        $transformed = collect($user->items())->map(function ($item) {
            return [
                'id_user'           => $item->id_user,
                'email'             => $item->email,
                'status_verifikasi' => $item->status_verifikasi,
                'role' => $item->role,
                'foto'              => $item->foto,
                'nama'              => $item->penduduk ? $item->penduduk->nama : null,
            ];
        });

        return view('admin.akun.akun-warga', [
            'user'      => $user,
            'userJs'    => $transformed,
            'search'    => $request->search,
            'filter'    => $request->filter,
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
