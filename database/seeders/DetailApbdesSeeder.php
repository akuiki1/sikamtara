<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailApbdesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Pendapatan
            ['id_apbdes' => 1, 'kategori' => 'pendapatan', 'judul' => '', 'sub_judul' => 'Dana Desa', 'anggaran' => 1019855000, 'realisasi' => 1019855000],
            ['id_apbdes' => 1, 'kategori' => 'pendapatan', 'judul' => '', 'sub_judul' => 'Alokasi Dana Desa', 'anggaran' => 645360000, 'realisasi' => 641560582],
            ['id_apbdes' => 1, 'kategori' => 'pendapatan', 'judul' => '', 'sub_judul' => 'Bagi Hasil BUMDes', 'anggaran' => 3852240, 'realisasi' => 3852340],
            ['id_apbdes' => 1, 'kategori' => 'pendapatan', 'judul' => '', 'sub_judul' => 'Bagi Hasil Pajak Daerah dan Retribusi Daerah', 'anggaran' => 14266290, 'realisasi' => 12827000],
            ['id_apbdes' => 1, 'kategori' => 'pendapatan', 'judul' => '', 'sub_judul' => 'Bunga Bank', 'anggaran' => 400000, 'realisasi' => 2240427],

            // Belanja - Penyelenggaraan Pemerintahan Desa
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Penyelenggaraan Pemerintahan Desa', 'sub_judul' => 'Sub Bidang Penyelenggaraan Belanja Siltap, Tunjangan dan Operasional Pemerintahan Desa', 'anggaran' => 482340433, 'realisasi' => 458627188],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Penyelenggaraan Pemerintahan Desa', 'sub_judul' => 'Sub Bidang Penyediaan Sarana Prasarana Pemerintahan Desa', 'anggaran' => 49154943, 'realisasi' => 446313],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Penyelenggaraan Pemerintahan Desa', 'sub_judul' => 'Sub Bidang Pengelolaan Administrasi Kependudukan, Pencatatan Sipil, Statistik dan Kearsipan', 'anggaran' => 3700000, 'realisasi' => 3700000],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Penyelenggaraan Pemerintahan Desa', 'sub_judul' => 'Sub Bidang Penyelenggaraan Tata Praja Pemerintahan, Perencanaan, Keuangan dan Pelaporan', 'anggaran' => 18963000, 'realisasi' => 1963000],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Penyelenggaraan Pemerintahan Desa', 'sub_judul' => 'Pertanahan', 'anggaran' => 5000000, 'realisasi' => 5000000],

            // Belanja - Pelaksanaan Pembangunan Desa
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Pelaksanaan Pembangunan Desa', 'sub_judul' => 'Kesehatan', 'anggaran' => 314423654, 'realisasi' => 304061880],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Pelaksanaan Pembangunan Desa', 'sub_judul' => 'Pekerjaan Umum dan Penataan Ruang', 'anggaran' => 36687040, 'realisasi' => 34404520],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Pelaksanaan Pembangunan Desa', 'sub_judul' => 'Kawasan Permukiman', 'anggaran' => 7120000, 'realisasi' => 7120000],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Pelaksanaan Pembangunan Desa', 'sub_judul' => 'Perhubungan dan Komunikasi', 'anggaran' => 45030450, 'realisasi' => 43484000],

            // BIDANG PELAKSANAAN PEMBANGUNAN DESA
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Pelaksanaan Pembangunan Desa', 'sub_judul' => 'Sub Bidang Kesehatan', 'anggaran' => 314423364, 'realisasi' => 304061880],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Pelaksanaan Pembangunan Desa', 'sub_judul' => 'Sub Bidang Pekerjaan Umum dan Penetapan Ruang', 'anggaran' => 36687440, 'realisasi' => 34404520],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Pelaksanaan Pembangunan Desa', 'sub_judul' => 'Sub Bidang Kawasan Permukiman', 'anggaran' => 7210000, 'realisasi' => 7210000],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Pelaksanaan Pembangunan Desa', 'sub_judul' => 'Sub Bidang Perhubungan, Komunikasi dan Informatika', 'anggaran' => 45003050, 'realisasi' => 43484000],

            // BIDANG PEMBINAAN KEMASYARAKATAN
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Pembinaan Kemasyarakatan', 'sub_judul' => 'Sub Bidang Kebudayaan dan Keagamaan', 'anggaran' => 3944008, 'realisasi' => 3940000],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Pembinaan Kemasyarakatan', 'sub_judul' => 'Sub Bidang Kelembagaan Masyarakat', 'anggaran' => 2500000, 'realisasi' => 2400000],

            // BIDANG PEMBERDAYAAN MASYARAKAT
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Pemberdayaan Masyarakat', 'sub_judul' => 'Sub Bidang Pertanian dan Peternakan', 'anggaran' => 149058272, 'realisasi' => 138164536],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Pemberdayaan Masyarakat', 'sub_judul' => 'Sub Bidang Peningkatan Kapasitas Aparatur Desa', 'anggaran' => 6000000, 'realisasi' => 6000000],

            // BIDANG PENANGGULANGAN BENCANA, KEADAAN DARURAT, DAN MENDESAK
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Penanggulangan Bencana, Keadaan Darurat, dan Mendesak', 'sub_judul' => 'Sub Bidang Penanggulangan Bencana', 'anggaran' => 43050000, 'realisasi' => 0],
            ['id_apbdes' => 1, 'kategori' => 'belanja', 'judul' => 'Bidang Penanggulangan Bencana, Keadaan Darurat, dan Mendesak', 'sub_judul' => 'Sub Bidang Keadaan Mendesak', 'anggaran' => 187200000, 'realisasi' => 187200000],

            // PENERIMAAN PEMBIAYAAN
            ['id_apbdes' => 1, 'kategori' => 'pembiayaan', 'judul' => 'Penerimaan Pembiayaan', 'sub_judul' => 'SILPA Tahun 2023', 'anggaran' => 81729568, 'realisasi' => 81729568],

            // PENGELUARAN PEMBIAYAAN
            ['id_apbdes' => 1, 'kategori' => 'pembiayaan', 'judul' => 'Pengeluaran Pembiayaan', 'sub_judul' => 'Pengeluaran Pembiayaan/Penyertaan Modal', 'anggaran' => 5000000, 'realisasi' => 0],
        ];

        foreach ($data as $item) {
            DB::table('detail_apbdes')->insert([
                'id_apbdes' => $item['id_apbdes'],
                'kategori' => $item['kategori'],
                'judul' => $item['judul'],
                'sub_judul' => $item['sub_judul'],
                'anggaran' => $item['anggaran'],
                'realisasi' => $item['realisasi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
