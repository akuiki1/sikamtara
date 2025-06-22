<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RincianAnggaran>
 */
class RincianAnggaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_sub_kategori_anggaran' => \App\Models\SubKategoriAnggaran::factory(),
            'id_tahun_anggaran' => \App\Models\TahunAnggaran::factory(),
            'nama' => $this->faker->sentence(3),
            'anggaran' => $this->faker->randomFloat(2, 1000000, 100000000),
            'realisasi' => fn(array $attributes) => $this->faker->randomFloat(2, 0, $attributes['anggaran']),
        ];
    }
}
