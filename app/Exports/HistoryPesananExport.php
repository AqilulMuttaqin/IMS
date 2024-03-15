<?php

namespace App\Exports;

use App\Models\Pesanan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class HistoryPesananExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function sheets(): array
    {
        $sheets = [];
        
        $query = Pesanan::with(['users', 'lokasi', 'barang_pesanan']);

        if ($this->startDate && $this->endDate) {
            $start_date = Carbon::parse($this->startDate)->startOfDay();
            $end_date = Carbon::parse($this->endDate)->endOfDay();
            $query->whereBetween('pesanan.updated_at', [$start_date, $end_date])->where('status', 'selesai');
        }
        
        $pesanan = $query->get();

        $groupedPesanan = $pesanan->groupBy('id_lokasi');

        foreach ($groupedPesanan as $lokasiId => $pesananGroup) {
            $lokasi = $pesananGroup->first()->lokasi;
            $sheets[] = new HistoryPesananSheet($lokasi, $start_date, $end_date);
        }

        return $sheets;
    }
}
