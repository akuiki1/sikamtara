<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Keluarga;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index()
    {
        $total = Penduduk::count();
        $laki = Penduduk::where('jenis_kelamin', 'L')->count();
        $perempuan = Penduduk::where('jenis_kelamin', 'P')->count();
        $keluarga = Keluarga::distinct('kode_keluarga')->count('kode_keluarga');
        $dataUmur = $this->berdasarkanUmur();

        $usiaLabels = ['0-5 thn', '6-12 thn', '13-17 thn', '18-30 thn', '31-50 thn', '51+ thn'];
        $usiaData = [150, 200, 180, 300, 250, 154];

        $agamaCounts = Penduduk::selectRaw('agama, COUNT(*) as jumlah')
            ->groupBy('agama')
            ->pluck('jumlah', 'agama')
            ->toArray();

        $totalAgama = array_sum($agamaCounts);

        return view('user.penduduk', array_merge([
            'total' => $total,
            'laki' => $laki,
            'perempuan' => $perempuan,
            'keluarga' => $keluarga,
            'usiaLabels' => $usiaLabels,
            'usiaData' => $usiaData,
            'agamaData' => $agamaCounts,
            'totalAgama' => $totalAgama,
        ], $dataUmur));
    }

    public function berdasarkanUmur()
    {
        $penduduk = Penduduk::select('tanggal_lahir', 'jenis_kelamin')
            ->whereNotNull('tanggal_lahir')
            ->get();

        $umurData = [
            'L' => [],
            'P' => [],
        ];

        $kelompokUmur = [
            '0-4' => [0, 4],
            '5-9' => [5, 9],
            '10-14' => [10, 14],
            '15-19' => [15, 19],
            '20-24' => [20, 24],
            '25-29' => [25, 29],
            '30-34' => [30, 34],
            '35-39' => [35, 39],
            '40-44' => [40, 44],
            '45-49' => [45, 49],
            '50-54' => [50, 54],
            '55-59' => [55, 59],
            '60+' => [60, 120],
        ];

        // Inisialisasi array kosong
        foreach ($kelompokUmur as $key => $range) {
            $umurData['L'][$key] = 0;
            $umurData['P'][$key] = 0;
        }

        foreach ($penduduk as $p) {
            $umur = Carbon::parse($p->tanggal_lahir)->age;

            foreach ($kelompokUmur as $label => [$min, $max]) {
                if ($umur >= $min && $umur <= $max) {
                    $umurData[$p->jenis_kelamin][$label]++;
                    break;
                }
            }
        }

        // Temukan kelompok umur tertinggi per jenis kelamin
        $tertinggiL = collect($umurData['L'])->sortDesc()->keys()->first();
        $tertinggiP = collect($umurData['P'])->sortDesc()->keys()->first();

        $totalL = array_sum($umurData['L']);
        $totalP = array_sum($umurData['P']);

        return [
            'umurData' => $umurData,
            'tertinggi' => [
                'L' => [
                    'label' => $tertinggiL,
                    'jumlah' => $umurData['L'][$tertinggiL],
                    'persentase' => $totalL > 0 ? round(($umurData['L'][$tertinggiL] / $totalL) * 100, 2) : 0,
                ],
                'P' => [
                    'label' => $tertinggiP,
                    'jumlah' => $umurData['P'][$tertinggiP],
                    'persentase' => $totalP > 0 ? round(($umurData['P'][$tertinggiP] / $totalP) * 100, 2) : 0,
                ],
            ],
        ];
    }
}
