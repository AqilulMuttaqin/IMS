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
        'inv_number',
        'PO_number',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_js', 'kode_js');
    }

    public function lokasi()
    {
        return $this->belongsToMany(Lokasi::class)->withPivot('qty');
    }
}
