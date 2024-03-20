<?php

namespace App\Exports;

use App\Models\DataBarang;
use App\Models\Lokasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataBarangSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithEvents
{
    protected $lokasi;
    protected $lokasiNama;
    
    public function __construct(int $lokasi)
    {
        $this->lokasi = $lokasi;
        $this->lokasiNama = Lokasi::find($lokasi)->nama;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $lokasiId = $this->lokasi;
        $dataBarang = DataBarang::whereHas('lokasi', function ($query) use ($lokasiId) {
            $query->where('lokasi_id', $lokasiId);
        })->with(['barang', 'lokasi' => function ($query) use ($lokasiId) {
            $query->where('lokasi_id', $lokasiId);
        }])->get();
    
        $dataBarang->each(function ($item) use ($lokasiId) {
            $item->qty = $item->lokasi->firstWhere('id', $lokasiId)->pivot->qty;
        });

        $data = [];

        foreach($dataBarang as $key => $value){
            $data[] = [
                'No.' => $key + 1,
                'Kode JS' => $value->kode_js,
                'Nama Barang' => $value->barang->nama,
                'Invoice Number' => $value->barang->inv_number,
                'PO Number' => $value->PO_number,
                'Satuan' => $value->barang->satuan,
                'Min' => $value->barang->min,
                'Max' => $value->barang->max,
                'Price$' => $value->barang->price,
                'Qty' => $value->qty,
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
            'Invoice Number',
            'PO Number',
            'Satuan',
            'Min',
            'Max',
            'Price$',
            'Qty'
        ];
    }

    public function title(): string
    {
        return $this->lokasiNama;
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

        $sheet->getStyle('A1:J1')->applyFromArray($styleArray);
        $sheet->getStyle('A2:J' . ($sheet->getHighestRow()))->applyFromArray($styleArray);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:J1';

                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '9ef0e6']],
                ]);
                
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);

                foreach (range('A','J') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }

                //$event->sheet->getStyle('A:A')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            },
        ];
    }
}
