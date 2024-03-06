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
        'requested_qty'
    ];

    public function pesanan()
    {
        return $this->belongsToMany(Pesanan::class, 'barang_pesanan', 'kode_js', 'pesanan_id')->withPivot('qty');
    }

    public function dataBarang()
    {
        return $this->hasMany(DataBarang::class, 'kode_js', 'kode_js');
    }

    public function keranjang()
    {
        return $this->belongsToMany(Keranjang::class, 'barang_keranjang', 'kode_js', 'keranjang_id')->withPivot('qty');
    }

    public function moveToLocation(string $lokasiAwal, $lokasiAkhir, $qty): void
    {
        $availableDataBarang = $this->dataBarang()
            ->with('lokasi')
            ->whereHas('lokasi', function ($query) use ($lokasiAwal) {
                $query->where('lokasi.id', $lokasiAwal);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $remainingQuantity = $qty;

        foreach ($availableDataBarang as $dataBarang) {
            if ($dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty >= $remainingQuantity) {
                $newQuantity = $dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty - $remainingQuantity;
                if ($newQuantity > 0) {
                    $dataBarang->lokasi()->updateExistingPivot($lokasiAwal, ['qty' => $newQuantity]);
                } else {
                    $dataBarang->lokasi()->detach($lokasiAwal);
                }

                $existingBarang = $dataBarang->lokasi()->where('lokasi_id', $lokasiAkhir)->first();
                if ($existingBarang) {
                    $existingBarang->pivot->qty += $remainingQuantity;
                    $existingBarang->pivot->save();
                } else {
                    $dataBarang->lokasi()->attach($lokasiAkhir, ['qty' => $remainingQuantity]);
                }

                $remainingQuantity = 0;
                break;
            } else {
                $movedQuantity = $dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty;

                $dataBarang->lokasi()->detach($lokasiAwal);

                $existingBarang = $dataBarang->lokasi()->where('lokasi_id', $lokasiAkhir)->first();
                if ($existingBarang) {
                    $existingBarang->pivot->qty += $movedQuantity;
                    $existingBarang->pivot->save();
                } else {
                    $dataBarang->lokasi()->attach($lokasiAkhir, ['qty' => $movedQuantity]);
                }

                $remainingQuantity -= $movedQuantity;
            }
        }

        if ($remainingQuantity > 0) {
            // Not enough available quantity, throw an exception or handle appropriately
            throw new \Exception("Insufficient quantity available for moving.");
        }
    }
}
