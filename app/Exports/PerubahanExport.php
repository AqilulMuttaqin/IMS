<?php

namespace App\Exports;

use App\Models\Perubahan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PerubahanExport implements WithMultipleSheets
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

        if ($this->startDate && $this->endDate) {
            $start_date = Carbon::parse($this->startDate)->startOfDay();
            $end_date = Carbon::parse($this->endDate)->endOfDay();

            $lokasi = Perubahan::whereBetween('created_at', [$start_date, $end_date])->pluck('lokasi_awal_id')->unique();
            foreach($lokasi as $lokasiId){
                $sheets[] = new PerubahanSheet($lokasiId, $this->startDate, $this->endDate);
            };
        } else {
            $lokasi = Perubahan::all()->pluck('lokasi_awal_id')->unique();
            foreach($lokasi as $lokasiId){
                $sheets[] = new PerubahanSheet($lokasiId, null, null);
            };
        }

        return $sheets;
    }
}