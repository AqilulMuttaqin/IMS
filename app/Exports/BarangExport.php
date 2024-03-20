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

        $barang = Barang::all();

        $data = [];

        foreach ($barang as $key => $value) {
            $data[] = [
                'Kode JS' => $value->kode_js,
                'Nama Barang' => $value->nama,
                'Min Stok' => $value->min_stok,
                'Max Stok' => $value->max_stok,
                'Faktur Pajak' => $value->faktur_pajak,
                'Satuan' => $value->satuan,
                'Kategori' => $value->kategori,
                'Price($)' => $value->harga
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Kode JS',
            'Nama Barang',
            'Min Stok',
            'Max Stok',
            'Faktur Pajak',
            'Satuan',
            'Kategori',
            'Price($)'
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

        $sheet->getStyle('A1:H1')->applyFromArray($styleArray);
        $sheet->getStyle('A2:H' . ($sheet->getHighestRow()))->applyFromArray($styleArray);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:H1';

                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f0e6ad']],
                ]);
                
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);

                //$event->sheet->getDelegate()->getAutoFilter()->setRange($cellRange);

                foreach (range('A','H') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
