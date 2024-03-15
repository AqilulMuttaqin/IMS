<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'status',
        'kode_pesanan',
        'lokasi_id',
        'catatan'
    ]; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lokasi(){
        return $this->belongsTo(Lokasi::class);
    }

    public function barang()
    {
        return $this->belongsToMany(Barang::class, 'barang_pesanan', 'pesanan_id', 'kode_js')->withPivot('qty', 'keterangan');
    }
}
