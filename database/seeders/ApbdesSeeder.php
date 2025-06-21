<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TahunAnggaran;
use App\Models\KategoriAnggaran;
use App\Models\SubKategoriAnggaran;
use App\Models\RincianAnggaran;
use App\Models\PenerimaanPembiayaan;
use App\Models\PengeluaranPembiayaan;

class ApbdesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tahun Anggaran
        $tahun = TahunAnggaran::create(['tahun' => 2024]);

        // 2. Kategori
        $kategoriPendapatan = KategoriAnggaran::create(['nama' => 'Pendapatan']);
        $kategoriBelanja    = KategoriAnggaran::create(['nama' => 'Belanja']);
        $kategoriPembiayaan = KategoriAnggaran::create(['nama' => 'Pembiayaan']);

        // 3. Sub Kategori Belanja
        $subPemerintahan = SubKategoriAnggaran::create([
            'kategori_id' => $kategoriBelanja->id,
            'nama' => 'Bidang Penyelenggaraan Pemerintahan Desa'
        ]);

        $subPembangunan = SubKategoriAnggaran::create([
            'kategori_id' => $kategoriBelanja->id,
            'nama' => 'Bidang Pelaksanaan Pembangunan Desa'
        ]);

        // 4. Rincian Anggaran
        RincianAnggaran::create([
            'sub_kategori_id' => $subPemerintahan->id,
            'tahun_id' => $tahun->id,
            'nama' => 'Sub Bidang Penyelenggaraan Belanja Siltap',
            'anggaran' => 50000000,
            'realisasi' => 47000000,
        ]);

        RincianAnggaran::create([
            'sub_kategori_id' => $subPembangunan->id,
            'tahun_id' => $tahun->id,
            'nama' => 'Sub Bidang Kesehatan',
            'anggaran' => 30000000,
            'realisasi' => 29500000,
        ]);

        // 5. Penerimaan Pembiayaan
        PenerimaanPembiayaan::create([
            'tahun_id' => $tahun->id,
            'nama' => 'SILPA Tahun 2023',
            'nilai' => 81729568,
        ]);

        // 6. Pengeluaran Pembiayaan
        PengeluaranPembiayaan::create([
            'tahun_id' => $tahun->id,
            'nama' => 'Penyertaan Modal',
            'nilai' => 5000000,
        ]);
    }
}
