<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sejarah;
use App\Models\Visimisi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StrukturPemerintahan;

class AdminProfilDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StrukturPemerintahan::with('user');

        if ($request->has('search')) {
            $query->where('nama_administrasi', 'like', '%' . $request->search . '%');
        }


        // Filter berdasarkan role
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination dengan query string tetap
        $strukturPemerintahan = $query->paginate(8)->appends($request->query());

        // Data untuk JavaScript (Alpine)
        $transformed = collect($strukturPemerintahan->items())->map(function ($item) {
            return [
                'id_administrasi'         => $item->id_administrasi,
                'nama_administrasi'      => $item->nama_administrasi,
                'deskripsi'        => Str::limit($item->deskripsi, 100),
                'deskripsi_full'        => $item->deskripsi,
                'persyaratan'        => $item->persyaratan,
                'form'      => $item->form,
                // 'name_form' => Str::limit(Str::after(basename($item->form), '_'), 35),
                // 'name_form_edit' => Str::limit(Str::after(basename($item->form), '_'), 25),
            ];
        });
        
        $sejarah = Sejarah::first();
        $visimisi = Visimisi::first();


        return view('admin.profil-desa', [
            'strukturPemerintahan'      => $strukturPemerintahan,
            'strukturPemerintahanJs'    => $transformed,
            'search'    => $request->search,
            'sejarah' => $sejarah,
            'visimisi' => $visimisi,
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

    public function updateVisimisi(Request $request)
    {
        $request->validate([
            'visi' => 'required|text',
            'misi' => 'required|text',
        ]);

        try {
            // Ambil entri pertama
            $visimisi = Visimisi::first();

            if ($visimisi) {
                $visimisi->update([
                    'visi' => $request->visi,
                    'misi' => $request->misi ?? '',
                ]);
            } else {
                // Kalau belum ada, baru buat
                Visimisi::create([
                    'visi' => $request->visi,
                    'misi' => $request->misi ?? '',
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
