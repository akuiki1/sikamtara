<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Keluarga;
use App\Models\Penduduk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $admin = User::create([
        //     'nama' => 'Admin Desa',
        //     'nik' => '6612345678901234',
        //     'email' => 'admin@desa.com',
        //     'password' => Hash::make('admin@123'),
        //     'role' => 'admin',
        //     'verified_is' => true
        // ]);

        // keluarga::factory(50)->recycle([
        //     penduduk::factory(2000)->create(),
        //     User::factory(100)->create(),
        // ])->create();

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
        User::factory(98)->create([
            'nik' => $penduduks->random()->nik, // pilih nik secara acak dari penduduk
            'role' => 'user',
        ]);
    }
}
