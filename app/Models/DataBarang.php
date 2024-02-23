<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    use HasFactory;

    protected $table = 'data_barang';

    protected $fillable = [
        'kode_js',
        'lokasi_id',
        'inv_number',
        'PO_number',
        'qty',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kode_js', 'kode_js');
    }

    public function lokasi()
    {
        return $this->hasMany(Lokasi::class);
    }
}
