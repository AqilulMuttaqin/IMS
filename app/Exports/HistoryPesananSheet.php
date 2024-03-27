<?php

namespace App\Exports;

use App\Models\Pesanan;
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

class HistoryPesananSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $lokasi;
    protected $startDate;
    protected $endDate;

    public function __construct($lokasi, $startDate, $endDate)
    {
        $this->lokasi = $lokasi;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Pesanan::with(['user', 'lokasi'])
            ->where('pesanan.lokasi_id', $this->lokasi->id);
        
        if ($this->startDate && $this->endDate) {
            $start_date = Carbon::parse($this->startDate)->startOfDay();
            $end_date = Carbon::parse($this->endDate)->endOfDay();
    
            $query->whereBetween('pesanan.updated_at', [$start_date, $end_date])->where('status', 'selesai');
        }
        
        $pesanan = $query->get();

        $data = [];

        foreach ($pesanan as $p) {
            $data[] = [
                'Kode Pesan' => $p->kode_pesanan,
                'Nama Pemesan' => $p->nama,
                'Lokasi' => $p->lokasi,
                'Tanggal Pesan' => Date::dateTimeToExcel($p->created_at),
                'Tanggal Selesai' => Date::dateTimeToExcel($p->updated_at),
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Kode Pesan',
            'Nama Pemesan',
            'Lokasi',
            'Tanggal Pesan',
            'Tanggal Selesai',
        ];
    }

    public function title(): string
    {
        return $this->lokasi->nama;
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

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY, 
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:E1';

                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '97cfa6']],
                ]);
                
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);

                //$event->sheet->getDelegate()->getAutoFilter()->setRange($cellRange);

                foreach (range('A','E') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
                $event->sheet->getStyle('A:A')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            },
        ];
    }
}
