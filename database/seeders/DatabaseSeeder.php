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

        // Buat 5 APBDes
        $apbdesList = Apbdes::factory(5)->create();

        // Untuk tiap APBDes, buat 10 rincian
        $apbdesList->each(function ($apbdes) {
            DetailApbdes::factory(10)->create([
                'id_apbdes' => $apbdes->id_apbdes,
            ]);
        });

        // 3 Tahun Anggaran
        $tahunList = TahunAnggaran::factory()->count(3)->create();

        // 5 Kategori + SubKategori + Rincian
        $kategoriList = KategoriAnggaran::factory()->count(5)->create();

        $kategoriList->each(function ($kategori) use ($tahunList) {
            $subKategoriList = SubKategoriAnggaran::factory()->count(3)->create([
                'id_kategori_anggaran' => $kategori->id_kategori_anggaran,
            ]);

            foreach ($subKategoriList as $sub) {
                foreach ($tahunList as $tahun) {
                    RincianAnggaran::factory()->count(2)->create([
                        'id_sub_kategori_anggaran' => $sub->id_sub_kategori_anggaran,
                        'id_tahun_anggaran' => $tahun->id_tahun_anggaran,
                    ]);
                }
            }
        });

        // Pembiayaan
        foreach ($tahunList as $tahun) {
            PenerimaanPembiayaan::factory()->count(2)->create([
                'id_tahun_anggaran' => $tahun->id_tahun_anggaran,
            ]);

            PengeluaranPembiayaan::factory()->count(2)->create([
                'id_tahun_anggaran' => $tahun->id_tahun_anggaran,
            ]);
        }
    }
}
