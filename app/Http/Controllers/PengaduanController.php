<?php

namespace App\Http\Controllers;

use App\Models\pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {
        $total = pengaduan::count();
        $terkirim = pengaduan::where('status', 'terkirim')->count();
        $diproses = pengaduan::whereIn('status', ['diterima', 'diproses'])->count();
        $ditutup = pengaduan::whereIn('status', ['selesai', 'ditolak'])->count();

        return view('user.pengaduan', [
            'title' => 'Pengaduan Warga',
            'total' => $total,
            'terkirim' => $terkirim,
            'diproses' => $diproses,
            'ditutup' => $ditutup,
        ]);
    }
}
