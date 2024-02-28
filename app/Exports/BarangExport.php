<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Barang::all();
    }

    public function headings(): array
    {
        return [
            'Kode JS',
            'Nama Barang',
            'min_stok',
            'max_stok',
            'Price($)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->getStyle('A1:E1')->applyFromArray($styleArray);
        $sheet->getStyle('A2:E' . ($sheet->getHighestRow()))->applyFromArray($styleArray);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:E1';

                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '5181cf']],
                ]);
                
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);

                //$event->sheet->getDelegate()->getAutoFilter()->setRange($cellRange);

                foreach (range('A','E') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
