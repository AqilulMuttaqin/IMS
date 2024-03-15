<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perubahan extends Model
{
    protected $table = 'perubahan';

    use HasFactory;

    public function data_barang()
    {
        return $this->belongsTo(DataBarang::class, 'id_data_barang');
    }

    public function lokasiAwal()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_awal_id');
    }

    public function lokasiAkhir()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_akhir_id');
    }
}
