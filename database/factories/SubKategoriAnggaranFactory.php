<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubKategoriAnggaran>
 */
class SubKategoriAnggaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_kategori_anggaran' => \App\Models\KategoriAnggaran::factory(),
            'nama' => $this->faker->words(2, true),
        ];
    }
}
