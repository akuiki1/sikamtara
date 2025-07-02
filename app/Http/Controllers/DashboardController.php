<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penduduk;
use App\Models\Pengaduan;
use App\Models\PengajuanAdministrasi;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $laki = Penduduk::where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan = Penduduk::where('jenis_kelamin', 'Perempuan')->count();
        $jumlahPenduduk = $laki + $perempuan;

        $akunTerverifikasi = User::where('status_verifikasi', 'Terverifikasi')->count();
        $layananMenunggu = PengajuanAdministrasi::whereIn('status_pengajuan', ['baru', 'ditinjau'])->count();
        $pengaduanMasuk = Pengaduan::whereIn('status', ['terkirim', 'diterima'])->count();

        $pengaduan = Pengaduan::with('user')
            ->whereIn('status', ['baru', 'ditinjau'])
            ->latest()
            ->get();

        $pengajuan = PengajuanAdministrasi::with('user')
            ->whereIn('status_pengajuan', ['baru', 'ditinjau'])
            ->latest()
            ->get();

        $aktivitas = $pengaduan->concat($pengajuan)->sortByDesc('created_at')->values();

        // Manual paginate (10 per halaman)
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 5;
        $pagedData = $aktivitas->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $aktivitasPaginated = new LengthAwarePaginator($pagedData, $aktivitas->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('admin.dashboard', [
            'statistik_penduduk' => [
                'laki' => $laki,
                'perempuan' => $perempuan,
            ],
            'jumlahPenduduk' => $jumlahPenduduk,
            'akunTerverifikasi' => $akunTerverifikasi,
            'layananMenunggu' => $layananMenunggu,
            'pengaduanMasuk' => $pengaduanMasuk,
            'aktivitas' => $aktivitasPaginated,
            'title' => 'Sikamtara',
        ]);
    }
}
