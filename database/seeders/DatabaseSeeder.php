<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Apbdes;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\Administrasi;
use App\Models\DetailApbdes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\PengajuanAdministrasi;

use App\Models\KategoriAnggaran;
use App\Models\SubKategoriAnggaran;
use App\Models\TahunAnggaran;
use App\Models\RincianAnggaran;
use App\Models\PenerimaanPembiayaan;
use App\Models\PengeluaranPembiayaan;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Kemudian buat data keluarga dengan referensi ke penduduk dan user
        keluarga::factory(50)->create();

        // Pertama buat 2000 data penduduk
        $penduduks = penduduk::factory(2000)->create();

        // Buat 1 user dengan role 'admin'
        User::factory()->create([
            'nik' => $penduduks->random()->nik, // pilih nik secara acak dari penduduk
            'role' => 'admin',
        ]);

        // Buat 1 user dengan role 'kepala desa'
        User::factory()->create([
            'nik' => $penduduks->random()->nik, // pilih nik secara acak dari penduduk
            'role' => 'kepala desa',
        ]);

        // Buat sisa 98 user dengan role 'user'
        $penduduksUser = $penduduks->random(98); // ambil 98 nik acak dan unik

        $penduduksUser->each(function ($penduduk) {
            User::factory()->create([
                'nik' => $penduduk->nik,
                'role' => 'user',
            ]);
        });


        // Buat 20 data dummy untuk tabel administrasi
        Administrasi::factory(20)->create();

        // Ambil semua user dan administrasi
        $users = User::all();
        $administrasis = Administrasi::all();

        // Buat 20 pengajuan acak
        for ($i = 0; $i < 20; $i++) {
            PengajuanAdministrasi::factory()->create([
                'id_user' => $users->random()->id_user,
                'id_administrasi' => $administrasis->random()->id_administrasi,
            ]);
        }

        // 1. tahun anggaran apbdes
        
        $tahun = TahunAnggaran::factory()->create([
            'tahun' => 2024
        ]);

        // 2. Kategori & SubKategori Anggaran
        $kategoriMap = [
            'PENDAPATAN DESA' => [
                ['nama' => 'Bagi Hasil BUMDes', 'anggaran' => 3852340.00, 'realisasi' => 3852340.00],
                ['nama' => 'Dana Desa', 'anggaran' => 1019855000.00, 'realisasi' => 1019855000.00],
                ['nama' => 'Alokasi Dana Desa', 'anggaran' => 645360000.00, 'realisasi' => 641560582.00],
                ['nama' => 'Bagi Hasil Pajak Daerah dan Retribusi Daerah', 'anggaran' => 14266920.00, 'realisasi' => 12827000.00],
                ['nama' => 'Bunga Bank', 'anggaran' => 400000.00, 'realisasi' => 224047.59],
            ],
            'BELANJA DESA - BIDANG PENYELENGGARAAN PEMERINTAHAN DESA' => [
                ['nama' => 'Belanja Siltap, Tunjangan dan Operasional Pemerintahan Desa', 'anggaran' => 482340433.00, 'realisasi' => 458627188.52],
                ['nama' => 'Penyediaan Sarana Prasarana Pemerintahan Desa', 'anggaran' => 49154943.00, 'realisasi' => 446313.00],
                ['nama' => 'Administrasi Kependudukan, Pencatatan Sipil, Statistik dan Kearsipan', 'anggaran' => 3700000.00, 'realisasi' => 3700000.00],
                ['nama' => 'Tata Praja Pemerintahan, Perencanaan, Keuangan dan Pelaporan', 'anggaran' => 18693000.00, 'realisasi' => 1963000.00],
                ['nama' => 'Pertanahan', 'anggaran' => 5000000.00, 'realisasi' => 5000000.00],
            ],
            'BELANJA DESA - BIDANG PELAKSANAAN PEMBANGUNAN DESA' => [
                ['nama' => 'Bidang Kesehatan', 'anggaran' => 314423364.00, 'realisasi' => 304061880.00],
                ['nama' => 'Bidang Pekerjaan Umum dan Penataan Ruang', 'anggaran' => 36876847.00, 'realisasi' => 34404520.00],
                ['nama' => 'Bidang Kawasan Permukiman', 'anggaran' => 7210000.00, 'realisasi' => 7210000.00],
                ['nama' => 'Bidang Perhubungan, Komunikasi dan Informatika', 'anggaran' => 4503500.00, 'realisasi' => 4348800.00],
            ],
            'BELANJA DESA - BIDANG PEMBINAAN KEMASYARAKATAN' => [
                ['nama' => 'Bidang Kebudayaan dan Keagamaan', 'anggaran' => 3944008.73, 'realisasi' => 3940000.00],
                ['nama' => 'Bidang Kelembagaan Masyarakat', 'anggaran' => 2500000.00, 'realisasi' => 2400000.00],
            ],
            'BELANJA DESA - BIDANG PEMBERDAYAAN MASYARAKAT' => [
                ['nama' => 'Bidang Pertanian dan Peternakan', 'anggaran' => 149058272.00, 'realisasi' => 138164536.00],
                ['nama' => 'Bidang Peningkatan Kapasitas Aparatur Desa', 'anggaran' => 6000000.00, 'realisasi' => 6000000.00],
            ],
            'BELANJA DESA - BIDANG PENANGGULANGAN BENCANA, DARURAT, DAN MENDESAK' => [
                ['nama' => 'Penanggulangan Bencana', 'anggaran' => 43050000.00, 'realisasi' => 0.00],
                ['nama' => 'Keadaan Mendesak', 'anggaran' => 187200000.00, 'realisasi' => 187200000.00],
            ],
        ];


        foreach ($kategoriMap as $kategori => $subList) {
            $kategoriModel = KategoriAnggaran::factory()->create(['nama' => $kategori]);

            foreach ($subList as $sub) {
                $subModel = SubKategoriAnggaran::factory()->create([
                    'id_kategori_anggaran' => $kategoriModel->id_kategori_anggaran,
                    'nama' => $sub['nama']
                ]);

                RincianAnggaran::factory()->create([
                    'id_sub_kategori_anggaran' => $subModel->id_sub_kategori_anggaran,
                    'id_tahun_anggaran' => $tahun->id_tahun_anggaran,
                    'nama' => $sub['nama'],
                    'anggaran' => $sub['anggaran'],
                    'realisasi' => $sub['realisasi'],
                ]);
            }
        }

        // 3. Pembiayaan
        PenerimaanPembiayaan::factory()->create([
            'id_tahun_anggaran' => $tahun->id_tahun_anggaran,
            'nama' => 'SILPA Tahun 2023',
            'nilai' => 81729568.00
        ]);

        PengeluaranPembiayaan::factory()->create([
            'id_tahun_anggaran' => $tahun->id_tahun_anggaran,
            'nama' => 'Pengeluaran Pembiayaan / Penyertaan Modal',
            'nilai' => 5000000.00
        ]);
    }
}
