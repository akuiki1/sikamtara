<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index()
    {
        $totalPenduduk = 1234;
        $lakiLaki = 600;
        $perempuan = 634;

        $usiaLabels = ['0-5 thn', '6-12 thn', '13-17 thn', '18-30 thn', '31-50 thn', '51+ thn'];
        $usiaData = [150, 200, 180, 300, 250, 154];

        return view('penduduk', [
            'totalPenduduk' => $totalPenduduk,
            'lakiLaki' => $lakiLaki,
            'perempuan' => $perempuan,
            'usiaLabels' => $usiaLabels,
            'usiaData' => $usiaData,
        ]);
    }

    public function adminIndex()
    {
        return view('admin.penduduk');
    }
}
