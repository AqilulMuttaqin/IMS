<?php

namespace App\Exports;

use App\Models\Perubahan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PerubahanExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

        $lokasi = Perubahan::all()->pluck('lokasi_awal_id')->unique();

        foreach($lokasi as $lokasiId){
            $sheets[] = new PerubahanSheet($lokasiId);
        };

        return $sheets;
    }
}
