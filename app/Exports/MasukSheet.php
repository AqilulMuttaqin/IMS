<?php

namespace App\Exports;

use App\Models\Barang;
use App\Models\Perubahan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MasukSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithEvents
{
    protected $startDate;
    protected $endDate;
    
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Perubahan::with('data_barang.barang', 'lokasi_awal', 'lokasi_akhir')->whereNull('lokasi_awal_id');

        if ($this->startDate !== null && $this->endDate !== null) {
            $start_date = Carbon::parse($this->startDate)->startOfDay();
            $end_date = Carbon::parse($this->endDate)->endOfDay();
    
            $query->whereBetween('perubahan.created_at', [$start_date, $end_date]);
        }
        
        $history = $query->get();
        $data = [];

        foreach($history as $key => $value){
            $data[] = [
                'Tanggal' => Date::dateTimeToExcel($value->created_at),
                'Kode JS' => $value->data_barang->kode_js,
                'Nama Barang' => $value->data_barang->barang->nama,
                'Invoice Number' => $value->data_barang->inv_number,
                'PO Number' => $value->data_barang->PO_number,
                'Lokasi Awal' => $value->lokasi_awal ? $value->lokasi_awal->nama : null,
                'Lokasi Akhir' => $value->lokasi_akhir ? $value->lokasi_akhir->nama : null,
                'Remark' => $value->remark,
                'Qty' => $value->qty,
                'Qty Awal' => $value->qty_awal ? $value->qty_awal : null,
                'Qty Akhir' => $value->qty_akhir ? $value->qty_akhir : null
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kode JS',
            'Nama Barang',
            'Invoice Number',
            'PO Number',
            'Lokasi Awal',
            'Lokasi Akhir',
            'Remark',
            'Qty',
            'Qty Awal',
            'Qty Akhir'
        ];
    }

    public function title(): string
    {
        return 'Barang Masuk';
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

        $sheet->getStyle('A1:K1')->applyFromArray($styleArray);
        $sheet->getStyle('A2:K' . ($sheet->getHighestRow()))->applyFromArray($styleArray);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:K1';

                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f0e6ad']],
                ]);
                
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);

                foreach (range('A','K') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }

                $event->sheet->getStyle('A:A')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            },
        ];
    }
}
