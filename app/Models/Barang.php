<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'kode_js';
    public $incrementing = false;

    protected $fillable = [
        'kode_js',
        'nama',
        'harga',
        'min_stok',
        'max_stok',
    ];

    public function pesanan()
    {
        return $this->belongsToMany(Pesanan::class, 'barang_pesanan', 'kode_js', 'pesanan_id')->withPivot('qty');
    }

    public function dataBarang()
    {
        return $this->hasMany(DataBarang::class, 'kode_js', 'kode_js');
    }
}
