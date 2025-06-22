<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PengeluaranPembiayaan>
 */
class PengeluaranPembiayaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_tahun_anggaran' => \App\Models\TahunAnggaran::factory(),
            'nama' => $this->faker->words(3, true),
            'nilai' => $this->faker->randomFloat(2, 1000000, 100000000),
        ];
    }
}
