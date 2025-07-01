<?php

namespace App\Imports;

use App\Models\TahunAnggaran;
use App\Models\Pendapatan;
use App\Models\Belanja;
use App\Models\RincianBelanja;
use App\Models\Pembiayaan;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class APBDesImport implements ToCollection, WithCalculatedFormulas
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = TahunAnggaran::firstOrCreate(['tahun' => $tahun]);
    }

    public function collection(Collection $rows)
    {
        $currentSection = null;
        $currentBelanja = null;

        foreach ($rows as $row) {
            $nama = trim((string) ($row[0] ?? ''));
            $anggaran = $this->parseNumber($row[1] ?? null);
            $realisasi = $this->parseNumber($row[2] ?? null);

            if ($nama === '') continue;

            $lowerNama = Str::of($nama)->lower();

            if ($lowerNama->contains('pendapatan')) {
                $currentSection = 'pendapatan';
                continue;
            }

            if ($lowerNama->contains('belanja')) {
                $currentSection = 'belanja';
                continue;
            }

            if ($lowerNama->contains('pembiayaan')) {
                $currentSection = 'pembiayaan';
                continue;
            }

            // =====================
            // PENDAPATAN
            // =====================
            if ($currentSection === 'pendapatan' && $anggaran !== null) {
                Pendapatan::create([
                    'id_tahun_anggaran' => $this->tahun->id_tahun_anggaran,
                    'nama' => $nama,
                    'anggaran' => $anggaran,
                    'realisasi' => $realisasi,
                ]);
            }

            // =====================
            // BELANJA
            // =====================
            if ($currentSection === 'belanja') {
                // Deteksi baris Bidang
                if (preg_match('/^Bidang/i', $nama)) {
                    $currentBelanja = Belanja::firstOrCreate(['nama' => $nama]);
                }
                // Deteksi Rincian di bawah Bidang (apapun namanya)
                elseif ($currentBelanja && ($anggaran > 0 || $realisasi > 0)) {
                    RincianBelanja::create([
                        'id_belanja' => $currentBelanja->id_belanja,
                        'id_tahun_anggaran' => $this->tahun->id_tahun_anggaran,
                        'nama' => $nama,
                        'anggaran' => $anggaran,
                        'realisasi' => $realisasi,
                    ]);
                }
            }

            // =====================
            // PEMBIAYAAN
            // =====================
            if ($currentSection === 'pembiayaan' && $anggaran !== null) {
                $jenis = Str::contains($lowerNama, 'pengeluaran') ? 'pengeluaran' : 'penerimaan';

                Pembiayaan::create([
                    'id_tahun_anggaran' => $this->tahun->id_tahun_anggaran,
                    'nama' => $nama,
                    'jenis' => $jenis,
                    'anggaran' => $anggaran ?? 0,
                    'realisasi' => $realisasi ?? 0,
                ]);
            }
        }
    }

    protected function parseNumber($value)
    {
        if (is_null($value)) return 0;

        // Pastikan string
        $value = trim((string) $value);

        // Jika sudah numerik dari Excel (float), langsung kembalikan
        if (is_numeric($value)) return floatval($value);

        // Kalau format Amerika (1,000,000.00)
        if (preg_match('/^\d{1,3}(,\d{3})*(\.\d+)?$/', $value)) {
            $value = str_replace(',', '', $value);
            return floatval($value);
        }

        // Kalau format Indonesia (1.000.000,00)
        if (preg_match('/^\d{1,3}(\.\d{3})*(,\d+)?$/', $value)) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
            return floatval($value);
        }

        // Default fallback
        return is_numeric($value) ? floatval($value) : 0;
    }
}
