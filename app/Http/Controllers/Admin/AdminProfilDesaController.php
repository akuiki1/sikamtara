<?php

namespace App\Http\Controllers\admin;

use App\Models\Sejarah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminProfilDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sejarah = Sejarah::first(); // tanpa new Sejarah

        return view('admin.profil-desa', [
            'sejarah' => $sejarah,
        ]);
    }


    public function updateSejarah(Request $request)
    {
        $request->validate([
            'sejarah' => 'required|string',
            'foto' => 'nullable|string',
        ]);

        try {
            // Ambil entri pertama
            $sejarah = Sejarah::first();

            if ($sejarah) {
                $sejarah->update([
                    'sejarah' => $request->sejarah,
                    'foto' => $request->foto ?? '',
                ]);
            } else {
                // Kalau belum ada, baru buat
                Sejarah::create([
                    'sejarah' => $request->sejarah,
                    'foto' => $request->foto ?? '',
                ]);
            }

            return redirect()->back()->with('success', 'Sejarah desa berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'Gagal memperbarui sejarah: ' . $e->getMessage());
        }
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
