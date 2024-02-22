<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'no_js',
        'nama',
        'harga',
        'min_stok',
        'max_stok',
    ];

    public function pesanan()
    {
        return $this->belongsToMany(Pesanan::class)->withPivot('qty');
    }
}
