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
            'id_sub_kategori_anggaran' => 1,
            'id_tahun_anggaran' => 1,
            'nama' => $this->faker->sentence(3),
            'anggaran' => $this->faker->numberBetween(1000000, 100000000),
            'realisasi' => $this->faker->numberBetween(1000000, 100000000),
        ];
    }
}
