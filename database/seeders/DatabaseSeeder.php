<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\Administrasi;
use Illuminate\Database\Seeder;
use App\Models\PengajuanAdministrasi;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat 1 keluarga
        $keluarga = Keluarga::factory()->create([
            'kode_keluarga' => '0857720316462722',
        ]);

        // 2. Buat 5 penduduk untuk keluarga ini
        $penduduks = Penduduk::factory(5)->create([
            'kode_keluarga' => $keluarga->kode_keluarga,
        ]);

        // Ambil array-nya
        $pendudukArray = $penduduks->values();

        // 3. Buat 1 user role admin
        User::factory()->create([
            'nik' => $pendudukArray[0]->nik,
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // 4. Buat 1 user role user dengan email tertentu
        User::factory()->create([
            'nik' => $pendudukArray[1]->nik,
            'email' => 'user@user.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
        ]);

        // 5. Buat 3 user biasa (email acak)
        for ($i = 2; $i < 5; $i++) {
            User::factory()->create([
                'nik' => $pendudukArray[$i]->nik,
                'role' => 'user',
                'password' => Hash::make('12345678'),
            ]);
        }

        // 6. Buat 5 administrasi
        Administrasi::factory(5)->create();

        // 7. Buat 5 pengajuan administrasi acak
        $users = User::all();
        $administrasis = Administrasi::all();

        for ($i = 0; $i < 5; $i++) {
            PengajuanAdministrasi::factory()->create([
                'id_user' => $users->random()->id_user,
                'id_administrasi' => $administrasis->random()->id_administrasi,
            ]);
        }
    }
}
