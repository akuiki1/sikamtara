<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Keluarga;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PendudukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => $this->faker->unique()->numerify('################'), // 16 digit
            'nama' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-18 years'),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha']),
            'pendidikan' => $this->faker->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1']),
            'pekerjaan' => $this->faker->jobTitle(),
            'hubungan' => $this->faker->randomElement(['Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Menantu', 'Orang tua', 'Mertua', 'Pembantu']),
            'status_perkawinan' => $this->faker->randomElement(['Belum Kawin', 'Kawin', 'Cerai']),
            'golongan_darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'kewarganegaraan' => 'WNI',

            'kode_keluarga' => keluarga::inRandomOrder()->first()?->kode_keluarga ?? keluarga::factory(), // relasi ke KK

            'rt' => $this->faker->numberBetween(1, 10),
            'rw' => $this->faker->numberBetween(1, 5),
            'alamat' => $this->faker->address(),

            'status_tinggal' => $this->faker->randomElement(['Tetap', 'Pindah', 'Meninggal']),
        ];
    }
}
