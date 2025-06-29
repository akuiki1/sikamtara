<?php

namespace App\Http\Controllers\admin;

use App\Models\pengaduan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPengaduanController extends Controller
{
    public function index(Request $request)
    {
        $total = pengaduan::count();
        $terkirim = pengaduan::where('status', 'terkirim')->count();
        $diproses = pengaduan::whereIn('status', ['diterima', 'diproses'])->count();
        $ditutup = pengaduan::whereIn('status', ['selesai', 'ditolak'])->count();

        $query = Pengaduan::with('user');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul_pengaduan', 'like', '%' . $request->search . '%')
                    ->orWhere('isi_pengaduan', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengaduans = $query->latest()->paginate(20)->appends(request()->query());

        return view('admin.layanan.pengaduan', [
            'title' => 'Pengaduan Warga',
            'total' => $total,
            'terkirim' => $terkirim,
            'diproses' => $diproses,
            'ditutup' => $ditutup,

            'pengaduans' => $pengaduans,
        ]);
    }
}
