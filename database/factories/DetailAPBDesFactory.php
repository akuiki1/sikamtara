<?php

namespace Database\Factories;

use App\Models\Apbdes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailAPBDes>
 */
class DetailAPBDesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anggaran = $this->faker->numberBetween(1_000_000, 100_000_000);
        $realisasi = $this->faker->numberBetween(0, $anggaran); // realisasi maksimal anggaran

        return [
            'id_apbdes' => Apbdes::inRandomOrder()->first()?->id_apbdes ?? Apbdes::factory(), // fallback
            'kategori' => $this->faker->randomElement(['pendapatan', 'belanja', 'pembiayaan']),
            'judul' => $this->faker->sentence(3),
            'sub_judul' => $this->faker->sentence(4),
            'anggaran' => $anggaran,
            'realisasi' => $realisasi,
        ];
    }
}
