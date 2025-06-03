<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PengajuanAdministrasi>
 */
class PengajuanAdministrasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_administrasi' => \App\Models\Administrasi::factory(),
            'id_user' => \App\Models\User::factory(),
            'tanggal_pengajuan' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'form' => $this->faker->word() . '.pdf',
            'lampiran' => $this->faker->word() . '.pdf',
            'status_pengajuan' => $this->faker->randomElement(['baru', 'ditinjau', 'diproses', 'ditolak', 'selesai']),
            'surat_final' => $this->faker->boolean(70) ? $this->faker->word() . '.pdf' : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
