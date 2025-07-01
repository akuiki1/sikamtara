<?php

namespace Database\Factories;

use App\Models\Pembiayaan;
use App\Models\TahunAnggaran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pembiayaan>
 */
class PembiayaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Pembiayaan::class;

    public function definition()
    {
        $anggaran = $this->faker->randomFloat(2, 5000000, 50000000);
        $realisasi = $this->faker->randomFloat(2, 0, $anggaran);

        return [
            'id_tahun_anggaran' => TahunAnggaran::inRandomOrder()->first()->id_tahun_anggaran ?? TahunAnggaran::factory(),
            'nama' => $this->faker->words(3, true),
            'jenis' => $this->faker->randomElement(['penerimaan', 'pengeluaran']),
            'anggaran' => $anggaran,
            'realisasi' => $realisasi,
        ];
    }
}
