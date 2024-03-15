<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';

    protected $fillable = [
        'nama',
    ];

    public function dataBarang()
    {
        return $this->belongsToMany(DataBarang::class)->withPivot('qty');
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
