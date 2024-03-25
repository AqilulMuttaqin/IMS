<?php

namespace App\Exports;

use App\Models\Lokasi;
use App\Models\STO;
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

class STOExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithEvents
{
    
    protected $bulan;
    protected $lokasi;

    public function __construct($bulan, $lokasi = null)
    {
        $this->bulan = $bulan;
        if($lokasi == null){
            $this->lokasi = Lokasi::where('nama', 'GUDANG PRODUKSI')->first()->id;
        } else{
            $this->lokasi = $lokasi;
        }
    }

    public function collection()
    {
        list($selectedYear, $selectedMonth) = explode('-', $this->bulan);
        $sto = STO::with('barang')->whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', $selectedMonth)->get();

        $data = [];

        foreach($sto as $key => $value){
            $data[] = [
                'No.' => $key + 1,
                'Tanggal' => Date::dateTimeToExcel($value->created_at),
                'Kode JS' => $value->kode_js,
                'Nama Barang' => $value->barang->nama,
                'Satuan' => $value->barang->satuan,
                'Qty' => $value->qty,
                'STO' => $value->actual_qty,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No.',
            'Tanggal',
            'Kode JS',
            'Nama Barang',
            'Satuan',
            'Qty',
            'STO'
        ];
    }

    public function title(): string
    {
        return "STO Gudang";
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

        $sheet->getStyle('A1:G1')->applyFromArray($styleArray);
        $sheet->getStyle('A2:G' . ($sheet->getHighestRow()))->applyFromArray($styleArray);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:G1';

                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '9ef0e6']],
                ]);
                
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);

                foreach (range('A','G') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }

                $event->sheet->getStyle('B:B')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            },
        ];
    }
}
