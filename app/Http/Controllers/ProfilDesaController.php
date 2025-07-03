<?php

namespace App\Http\Controllers;

use App\Models\Sejarah;
use App\Models\Visimisi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StrukturPemerintahan;

class ProfilDesaController extends Controller
{
     public function index(Request $request)
    {
        $query = StrukturPemerintahan::with('user.penduduk');

        if ($request->has('search')) {
            $query->whereHas('user.penduduk', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        // Jika ingin filter status, pastikan ada kolom 'status' di tabel
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $strukturPemerintahan = $query->get();

        $transformed = $strukturPemerintahan->map(function ($item) {
            return [
                'id' => $item->id,
                'jabatan' => $item->jabatan,
                'deskripsi' => Str::limit($item->deskripsi, 100),
                'nama' => $item->user->penduduk->nama ?? '-',
            ];
        });

        $sejarah = Sejarah::first();
        $visimisi = Visimisi::first();

        return view('user.profil-desa', [
            'strukturPemerintahan' => $strukturPemerintahan,
            'strukturPemerintahanJs' => $transformed,
            'search' => $request->search,
            'sejarah' => $sejarah,
            'visimisi' => $visimisi,
        ]);
    }
}
