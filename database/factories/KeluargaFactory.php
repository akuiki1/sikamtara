<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class KeluargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_keluarga' => $this->faker->unique()->numerify('################'), // 16 digit
            'nik_kepala_keluarga' => $this->faker->unique()->numerify('################'),
            'alamat' => $this->faker->address(),
            'rt' => $this->faker->numberBetween(1, 10),
            'rw' => $this->faker->numberBetween(1, 5),
        ];
    }
}
