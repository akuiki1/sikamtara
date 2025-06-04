<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $laki = Penduduk::where('jenis_kelamin', 'L')->count();
        $perempuan = Penduduk::where('jenis_kelamin', 'P')->count();

        return view('admin.dashboard', [
            'statistik_penduduk' => [
                'laki' => $laki,
                'perempuan' => $perempuan,
            ],
            'title' => 'Sikamtara',
        ]);
    }
}
