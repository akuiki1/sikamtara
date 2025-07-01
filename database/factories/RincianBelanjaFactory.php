<?php

namespace Database\Factories;

use App\Models\Belanja;
use App\Models\TahunAnggaran;
use App\Models\RincianBelanja;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RincianBelanja>
 */
class RincianBelanjaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = RincianBelanja::class;

    public function definition(): array
    {
        return [
            'id_belanja' => Belanja::factory(),
            'id_tahun_anggaran' => TahunAnggaran::factory(),
            'nama' => $this->faker->sentence,
            'anggaran' => 0,
            'realisasi' => 0,
        ];
    }

    public function withStaticData(): array
    {
        $tahun = TahunAnggaran::firstOrCreate(['tahun' => 2024]);

        // Mapping Belanja Nama ke Rincian Belanja
        $data = [
            'BIDANG PENYELENGGARAAN PEMERINTAHAN DESA' => [
                ['Sub Bidang Penyelenggaraan Belanja Siltap, Tunjangan dan Operasional Pemerintahan Desa', 482340433, 458627188.52],
                ['Sub Bidang Penyediaan Sarana Prasarana Pemerintahan Desa', 49154943, 44631303],
                ['Sub Bidang Pengelolaan Administrasi Kependudukan, Pencatatan Sipil, Statistik dan Kearsipan', 3700000, 3700000],
                ['Sub Bidang Penyelenggaraan Tata Praja Pemerintahan, Perencanaan, Keuangan dan Pelaporan', 18693000, 19630000],
                ['Pertanahan', 5000000, 5000000],
            ],
            'BIDANG PELAKSANAAN PEMBANGUNAN DESA' => [
                ['Sub Bidang Kesehatan', 314423364, 304061880],
                ['Sub Bidang Pekerjaan Umum dan Penataan Ruang', 36876740, 34044520],
                ['Sub Bidang Kawasan Permukiman', 7210000, 7210000],
                ['Sub Bidang Perhubungan, Komunikasi dan Informatika', 45003450, 43488000],
            ],
            'BIDANG PEMBINAAN KEMASYARAKATAN' => [
                ['Sub Bidang Kebudayaan dan Keagamaan', 3944008.73, 3900000],
                ['Sub Bidang Kelembagaan Masyarakat', 2500000, 2400000],
            ],
            'BIDANG PEMBERDAYAAN MASYARAKAT' => [
                ['Sub Bidang Pertanian dan Peternakan', 149058272, 138164536],
                ['Sub Bidang Peningkatan Kapasitas Aparatur Desa', 6000000, 6000000],
            ],
            'BIDANG PENANGGULANGAN BENCANA, KEADAAN DARURAT, DAN MENDESAK' => [
                ['Sub Bidang Penanggulangan Bencana', 43050000, 43050000],
                ['Sub Bidang Keadaan Mendesak', 187000000, 187000000],
            ],
        ];

        $factories = [];

        foreach ($data as $belanjaNama => $subItems) {
            $belanja = Belanja::firstOrCreate(['nama' => $belanjaNama]);

            foreach ($subItems as [$nama, $anggaran, $realisasi]) {
                $factories[] = new RincianBelanja([
                    'id_belanja' => $belanja->id_belanja,
                    'id_tahun_anggaran' => $tahun->id_tahun_anggaran,
                    'nama' => $nama,
                    'anggaran' => $anggaran,
                    'realisasi' => $realisasi,
                ]);
            }
        }

        return $factories;
    }
}
