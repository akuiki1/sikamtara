<?php

namespace App\Http\Controllers;

use App\Models\Rt;
use App\Models\Rw;
use App\Models\User;
use App\Models\Sejarah;
use App\Models\Penduduk;
use App\Models\Visimisi;
use App\Models\LuasWilayah;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StrukturPemerintahan;
use App\Models\ProgramPembangunanDesa;

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

        $penduduk = Penduduk::count();
        $sejarah = Sejarah::first();
        $visimisi = Visimisi::first();
        $users = User::with('penduduk')->get();
        $programs = ProgramPembangunanDesa::orderByDesc('tanggal_mulai')->get();
        $jumlahRt = Rt::count();
        $jumlahRw = Rw::count();
        $luasWilayah = LuasWilayah::first();

        return view('user.profil-desa', [
            'strukturPemerintahan' => $strukturPemerintahan,
            'strukturPemerintahanJs' => $transformed,
            'search' => $request->search,
            'penduduk' => $penduduk,
            'sejarah' => $sejarah,
            'visimisi' => $visimisi,
            'users' => $users,
            'programs' => $programs,
            'jumlahRt' => $jumlahRt,
            'jumlahRw' => $jumlahRw,
            'luasWilayah' => $luasWilayah ? $luasWilayah->luas . ' ' . $luasWilayah->satuan : '0 Ha',
        ]);
    }
}
