<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apbdes;
use App\Models\DetailApbdes;

class KeuanganController extends Controller
{
    public function pendapatanLain($tahun)
    {
        $apbdes = Apbdes::with('rincian')->where('tahun', $tahun)->first();

        if (!$apbdes) {
            return response()->json([
                'summary' => [
                    'pendapatan' => 0,
                    'belanja' => 0,
                    'selisih' => 0
                ],
                'detailPendapatan' => [],
                'detailBelanja' => [],
                'detailPembiayaan' => [],
            ]);
        }

        $rincian = $apbdes->rincian;

        $pendapatan = $rincian->where('kategori', 'pendapatan');
        $belanja = $rincian->where('kategori', 'belanja');
        $pembiayaan = $rincian->where('kategori', 'pembiayaan');

        $totalPendapatan = $pendapatan->sum('realisasi');
        $totalBelanja = $belanja->sum('realisasi');
        $selisih = $totalPendapatan - $totalBelanja;

        return response()->json([
            'summary' => [
                'pendapatan' => $totalPendapatan,
                'belanja' => $totalBelanja,
                'selisih' => $selisih
            ],
            'detailPendapatan' => $pendapatan->map(function ($item) {
                return [
                    'id' => $item->id_rincian,
                    'nama' => $item->sub_judul ?: $item->judul,
                    'nilai' => $item->realisasi
                ];
            }),
            'detailBelanja' => $belanja->map(function ($item) {
                return [
                    'id' => $item->id_rincian,
                    'nama' => $item->sub_judul ?: $item->judul,
                    'nilai' => $item->realisasi
                ];
            }),
            'detailPembiayaan' => $pembiayaan->map(function ($item) {
                return [
                    'id' => $item->id_rincian,
                    'nama' => $item->sub_judul ?: $item->judul,
                    'nilai' => $item->realisasi
                ];
            }),
        ]);
    }
}
