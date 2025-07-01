<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administrasi>
 */
class AdministrasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaForms = [
            '1748852852_189-Article Text-592-1-10-20230807.pdf',
            '1623456222_205-Formulir Layanan-113-2-09-20230901.pdf',
            '1837729837_109-Surat Keterangan-319-4-11-20230623.pdf',
            '1984622341_212-Formulir Permohonan-420-3-08-20230514.pdf',
            '1523467489_173-Layanan Administrasi-210-7-07-20231012.pdf',
        ];

        $persyaratanList = [
            "- Fotokopi KTP\n- Fotokopi KK\n- Surat Pengantar RT/RW",
            "- KTP asli\n- Pas foto 3x4\n- Formulir permohonan",
            "- Fotokopi akta kelahiran\n- KTP orang tua\n- Kartu Keluarga",
            "- Surat pengantar desa\n- Bukti pembayaran PBB\n- Fotokopi Ijazah terakhir",
            "- KTP dan KK\n- Surat keterangan dari sekolah\n- Bukti pembayaran retribusi",
        ];

        return [
            'nama_administrasi' => $this->faker->randomElement([
                'Permohonan',
                'Surat Keterangan',
                'Pengajuan',
                'Penerbitan',
                'Pendaftaran'
            ]) . ' ' . $this->faker->randomElement([
                'KTP',
                'KK',
                'Domisili',
                'Nikah',
                'Usaha',
                'SKTM',
                'Akta Kelahiran',
                'Cuti Nikah',
                'Beasiswa'
            ]),

            'deskripsi' => $this->faker->sentence(10),
            'persyaratan' => $this->faker->randomElement($persyaratanList),
            'form' => 'form_administrasi/' . $this->faker->randomElement($namaForms),
        ];
    }
}
