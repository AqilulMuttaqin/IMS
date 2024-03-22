<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class STO extends Model
{
    use HasFactory;

    protected $table = 'sto';

    protected $fillable = [
        'kode_js',
        'month',
        'year',
        'qty',
        'actual_qty'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_js', 'kode_js');
    }
}
