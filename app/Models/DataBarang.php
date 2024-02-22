<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    use HasFactory;

    protected $table = 'data_barang';

    protected $fillable = [
        'no_js',
        'lokasi_id',
        'inv_number',
        'PO_number',
        'qty',
    ];
}
