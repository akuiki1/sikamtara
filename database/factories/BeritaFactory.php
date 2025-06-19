<?php

namespace Database\Factories;

use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BeritaFactory extends Factory
{
    public function definition(): array
    {
        // Pastikan ada user terlebih dahulu
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        // Pastikan juga user punya NIK yang sesuai dengan penduduk (jika data belum ada)
        if (!Penduduk::where('nik', $user->nik)->exists()) {
            Penduduk::factory()->create([
                'nik' => $user->nik,
                'kode_keluarga' => Keluarga::factory()->create()->kode_keluarga,
            ]);
        }

        return [
            'judul_berita' => fake()->sentence(),
            'isi_berita' => fake()->paragraph(5),
            'gambar_cover' => 'default.jpg', // atau pakai fake()->imageUrl() jika ingin dummy dari internet
            'tanggal_publish' => now(),
            'penulis' => $user->id_user,
            'status' => 'published',
            ];
    }
}
