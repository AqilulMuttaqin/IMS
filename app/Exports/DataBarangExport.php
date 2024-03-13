<?php

namespace App\Exports;

use App\Models\DataBarang;
use App\Models\Lokasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataBarangExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new DataBarangTotalSheet();

        $lokasi = Lokasi::all()->pluck('id');

        foreach($lokasi as $lokasiId){
            $sheets[] = new DataBarangSheet($lokasiId);
        };

        return $sheets;
    }
}
