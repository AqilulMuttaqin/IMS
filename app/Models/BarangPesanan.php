<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangPesanan extends Model
{
    use HasFactory;

    protected $table = 'barang_pesanan';
    public $timestamps = true;

    protected $fillable = [
        'pesanan_id',
        'kode_js',
        'qty',
        'keterangan'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_js', 'kode_js');
    }
}
