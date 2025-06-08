<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Administrasi;
use Illuminate\Http\Request;
use App\Models\PengajuanAdministrasi;

class AdministrasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Administrasi::with('user');

        if ($request->has('search')) {
            $query->where('nama_administrasi', 'like', '%' . $request->search . '%');
        }

        if ($request->has('search.riwayat')) {
            $query->where('nama_administrasi', 'like', '%' . $request->search . '%');
        }


        // Filter berdasarkan role
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination dengan query string tetap
        $administrasi = $query->paginate(8)->appends($request->query());

        // Data untuk JavaScript (Alpine)
        $transformed = collect($administrasi->items())->map(function ($item) {
            return [
                'id_administrasi'         => $item->id_administrasi,
                'nama_administrasi'      => $item->nama_administrasi,
                'deskripsi'        => \Illuminate\Support\Str::limit($item->deskripsi, 100),
                'deskripsi_full'        => $item->deskripsi,
                'persyaratan'        => $item->persyaratan,
                'form'      => $item->form,
                'name_form' => Str::limit(Str::after(basename($item->form), '_'), 35),
                'name_form_edit' => Str::limit(Str::after(basename($item->form), '_'), 25),
            ];
        });

        // $penulis = User::select('id_user')->get();

        $jumlahLayanan = PengajuanAdministrasi::count();
        $jumlahMasuk = PengajuanAdministrasi::whereIn('status_pengajuan', ['baru', 'ditinjau'])->count();
        $jumlahSiapTtd = PengajuanAdministrasi::where('status_pengajuan', 'diproses')->count();
        $jumlahSelesaiTahunIni = PengajuanAdministrasi::where('status_pengajuan', 'selesai')
            ->whereYear('tanggal_pengajuan', Carbon::now()->year)
            ->count();

        return view('user.administrasi', [
            'administrasi'      => $administrasi,
            'administrasiJs'    => $transformed,
            'search'    => $request->search,
            'filter'    => $request->filter,
            // 'penulis'   => $penulis,
            'role'      => $request->role,
            'status'    => $request->status,
            'jumlahLayanan' => $jumlahLayanan,
            'jumlahMasuk' => $jumlahMasuk,
            'jumlahSiapTtd' => $jumlahSiapTtd,
            'jumlahSelesaiTahunIni' => $jumlahSelesaiTahunIni,

        ]);
    }

    public function apply($id)
    {
        // Nanti bisa fetch data service dari database berdasarkan ID.
        // Untuk sementara kita kasih dummy saja.

        $service = [
            'id' => $id,
            'title' => 'Contoh Layanan',
            'description' => 'Ini halaman untuk mengajukan layanan dengan ID: ' . $id,
        ];

        return view('layanan.administrasi.apply', compact('service'));
    }
}
