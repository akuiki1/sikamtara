<?php

namespace App\Exports;

use App\Models\Apbdes;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class ApbdesExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $apbdes = Apbdes::where('tahun', $this->tahun)->firstOrFail();

        return view('exports.apbdes', [
            'tahun' => $this->tahun,
            'details' => $apbdes->detail_apbdes()->orderBy('kategori')->orderBy('judul')->get()
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Lebar kolom otomatis
                foreach (range('A', 'E') as $col) {
                    $sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }

                // Style umum
                $lastRow = $sheet->getDelegate()->getHighestRow();

                // Border semua sel
                $sheet->getStyle("A4:E{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    ],
                ]);

                // Bold dan center untuk header
                $sheet->getStyle("A1:E2")->applyFromArray([
                    'alignment' => ['horizontal' => 'center'],
                    'font' => ['bold' => true],
                ]);

                // Bold untuk header kolom "Anggaran dst"
                $sheet->getStyle("A4:E4")->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center'],
                ]);
            }
        ];
    }
}
