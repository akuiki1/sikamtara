<?php

namespace Database\Factories;

use App\Models\Pendapatan;
use App\Models\TahunAnggaran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pendapatan>
 */
class PendapatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Pendapatan::class;

    public function definition()
    {
        $anggaran = $this->faker->randomFloat(2, 10000000, 50000000);
        $realisasi = $this->faker->randomFloat(2, 0, $anggaran);

        return [
            'id_tahun_anggaran' => TahunAnggaran::inRandomOrder()->first()->id_tahun_anggaran ?? TahunAnggaran::factory(),
            'nama' => $this->faker->words(3, true),
            'anggaran' => $anggaran,
            'realisasi' => $realisasi,
        ];
    }
}
