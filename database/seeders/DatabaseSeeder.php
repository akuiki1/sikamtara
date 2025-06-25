<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Belanja;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\Pembiayaan;
use App\Models\Pendapatan;
use App\Models\Administrasi;

use App\Models\TahunAnggaran;
use Illuminate\Database\Seeder;
use App\Models\PengajuanAdministrasi;
use Database\Factories\RincianBelanjaFactory;

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

        // apbdes
        TahunAnggaran::factory()->count(3)->create();
        Belanja::factory()->count(5)->withStaticData()->create();
        $factories = (new RincianBelanjaFactory)->withStaticData();
        foreach ($factories as $factory) {
            $factory->save();
        }
        // pembiayaan
        Pembiayaan::insert([
            [
                'id_tahun_anggaran' => 1,
                'nama' => 'PENERIMAAN PEMBIAYAAN',
                'jenis' => 'penerimaan',
                'anggaran' => 81729568,
                'realisasi' => 81729568,
            ],
            [
                'id_tahun_anggaran' => 1,
                'nama' => 'PENGELUARAN PEMBIAYAAN',
                'jenis' => 'pengeluaran',
                'anggaran' => 5000000,
                'realisasi' => 5000000,
            ],
            [
                'id_tahun_anggaran' => 1,
                'nama' => 'PENGELUARAN PEMBIAYAAN / PENYERTAAN MODAL',
                'jenis' => 'pengeluaran',
                'anggaran' => 5000000,
                'realisasi' => 5000000,
            ],
        ]);


        // pendapatan
        Pendapatan::insert([
            [
                'id_tahun_anggaran' => 1,
                'nama' => 'Bagi Hasil BUMDes',
                'anggaran' => 3852340,
                'realisasi' => 3852340,
            ],
            [
                'id_tahun_anggaran' => 1,
                'nama' => 'DANA DESA',
                'anggaran' => 1019855000,
                'realisasi' => 1019855000,
            ],
            [
                'id_tahun_anggaran' => 1,
                'nama' => 'ALOKASI DANA DESA',
                'anggaran' => 643560000,
                'realisasi' => 641560582,
            ],
            [
                'id_tahun_anggaran' => 1,
                'nama' => 'BAGI HASIL PAJAK DAERAH DAN RETRIBUSI DAERAH',
                'anggaran' => 14266920,
                'realisasi' => 12827000,
            ],
            [
                'id_tahun_anggaran' => 1,
                'nama' => 'BUNGA BANK',
                'anggaran' => 4000000,
                'realisasi' => 2240747.59,
            ],
        ]);
    }
}
