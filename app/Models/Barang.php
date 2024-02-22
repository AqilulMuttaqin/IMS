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
        'stok',
        'stok_dipesan',
    ];

    public function pesanan()
    {
        return $this->belongsToMany(Pesanan::class)->withPivot('qty');
    }
}
