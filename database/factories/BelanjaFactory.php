<?php

namespace Database\Factories;

use App\Models\Belanja;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Belanja>
 */
class BelanjaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Belanja::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->sentence,
        ];
    }

    public function withStaticData()
    {
        return $this->state(fn() => [
            'nama' => $this->faker->randomElement([
                'BIDANG PENYELENGGARAAN PEMERINTAHAN DESA',
                'BIDANG PELAKSANAAN PEMBANGUNAN DESA',
                'BIDANG PEMBINAAN KEMASYARAKATAN',
                'BIDANG PEMBERDAYAAN MASYARAKAT',
                'BIDANG PENANGGULANGAN BENCANA, KEADAAN DARURAT, DAN MENDESAK',
            ]),
        ]);
    }
}
