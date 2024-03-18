<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perubahan extends Model
{
    protected $table = 'perubahan';

    protected $fillable =[
        'data_barang_id',
        'lokasi_awal_id',
        'lokasi_akhir_id',
        'remark',
        'qty',
        'qty_awal',
        'qty_akhir'
    ];

    use HasFactory;

    public function data_barang()
    {
        return $this->belongsTo(DataBarang::class, 'data_barang_id');
    }

    public function lokasi_awal()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_awal_id');
    }

    public function lokasi_akhir()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_akhir_id');
    }
}
