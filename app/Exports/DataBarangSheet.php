<?php

namespace App\Exports;

use App\Models\DataBarang;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataBarangSheet implements FromCollection
{
    protected $lokasi;
    
    public function __construct(int $lokasi)
    {
        $this->lokasi = $lokasi;
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

        return $dataBarang;
    }
}
