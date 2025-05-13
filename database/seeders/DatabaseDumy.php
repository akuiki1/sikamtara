<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\keluarga;
use App\Models\penduduk;

class DatabaseDumy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       keluarga::factory(20)->create()->each(function ($keluarga) {
        penduduk::factory(rand(2, 5))->create([
            'kode_keluarga' => $keluarga->kode_keluarga
        ]);
    });
    }
}
