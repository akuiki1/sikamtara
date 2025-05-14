<?php

namespace Database\Factories;

use App\Models\keluarga;
use App\Models\penduduk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BeritaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul_berita' => fake()->sentence(),
            'isi_berita' => fake()->text(),
            'gambar_cover' => fake()->image(),
            'tanggal_publish' => now(),
            'penulis_id' => function () {
                // Ambil ID User yang sudah ada atau buat baru
                $user = User::factory()->create();

                // Pastikan User punya Penduduk yang terkait
                $penduduk = penduduk::factory()->create([
                    'nik' => $user->nik,
                    'kode_keluarga' => keluarga::factory()->create()->kode_keluarga, // Relasi ke Keluarga
                ]);

                return $user->id_user; // Relasi ke User
            },
            'status' => 'published',
            'tags' => fake()->lexify(),
        ];
    }
}
