<?php

namespace App\Exports;

use App\Models\Barang;
use App\Models\DataBarang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataBarangTotalSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $barangs = Barang::with('dataBarang.lokasi')->get();

        $barangs->map(function ($barang, $key) {
            $totalQty = $barang->dataBarang->sum(function ($dataBarang) {
                return $dataBarang->lokasi->sum('pivot.qty');
            });

            $barang['total_qty'] = max(0, $totalQty);

            return $barang;
        });
        
        $data = [];

        foreach($barangs as $key => $value){
            $data[] = [
                'No.' => $key + 1,
                'Kode JS' => $value->kode_js,
                'Nama Barang' => $value->nama,
                'Satuan' => $value->satuan,
                'Min' => $value->min,
                'Max' => $value->max,
                'Price$' => $value->price,
                'Qty' => $value->total_qty,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No.',
            'Kode JS',
            'Nama Barang',
            'Satuan',
            'Min',
            'Max',
            'Price$',
            'Qty'
        ];
    }

    public function title(): string
    {
        return "Total Barang";
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
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '9ef0e6']],
                ]);
                
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);

                foreach (range('A','H') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }

                //$event->sheet->getStyle('A:A')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            },
        ];
    }
}
