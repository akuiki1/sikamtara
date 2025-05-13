<?php

namespace Database\Factories;

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
            'penulis' => 'admin',
            'status' => 'published',
            'tags' => fake()->lexify(),
        ];
    }
}
