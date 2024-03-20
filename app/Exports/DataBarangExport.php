<?php

namespace App\Exports;

use App\Models\DataBarang;
use App\Models\Lokasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataBarangExport implements WithMultipleSheets
{
    protected $lokasi;

    public function __construct($lokasi)
    {
        $this->lokasi = $lokasi;
    }

    public function sheets(): array
    {
        $sheets = [];

        
        if($this->lokasi === null){
            $sheets[] = new DataBarangTotalSheet(null);
            
            $lokasi = Lokasi::whereHas('dataBarang')->pluck('id');
    
            foreach($lokasi as $lokasiId){
                $sheets[] = new DataBarangSheet($lokasiId);
            };
        } else {
            $sheets[] = new DataBarangTotalSheet($this->lokasi);
            $sheets[] = new DataBarangSheet($this->lokasi);
        }

        return $sheets;
    }
}
