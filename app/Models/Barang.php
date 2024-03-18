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
        'requested_qty',
        'satuan',
        'kategori'
    ];

    public function pesanan()
    {
        return $this->belongsToMany(Pesanan::class, 'barang_pesanan', 'kode_js', 'pesanan_id')->withPivot('qty', 'keterangan');
    }

    public function dataBarang()
    {
        return $this->hasMany(DataBarang::class, 'kode_js', 'kode_js');
    }

    public function keranjang()
    {
        return $this->belongsToMany(Keranjang::class, 'barang_keranjang', 'kode_js', 'keranjang_id')->withPivot('qty', 'keterangan');
    }

    public function moveToLocation(string $lokasiAwal, $lokasiAkhir, $qty, $remark): void
    {
        $availableDataBarang = $this->dataBarang()
            ->with('lokasi')
            ->whereHas('lokasi', function ($query) use ($lokasiAwal) {
                $query->where('lokasi.id', $lokasiAwal);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $remainingQuantity = $qty;
        
        if($this->kategori !== "request"){
            if($remark === "tukar"){
                $lokasiScrap = Lokasi::where('nama', 'SIAP SCRAP')->pluck('id')->first();
                $this->moveToLocation($lokasiAkhir, $lokasiScrap, $qty, 'Siap Scrap');
            }

            foreach ($availableDataBarang as $dataBarang) {
                if ($dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty >= $remainingQuantity) {
                    $newQuantity = $dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty - $remainingQuantity;
                    $record = Perubahan::create([
                        'data_barang_id' => $dataBarang->id,
                        'lokasi_awal_id' => $lokasiAwal,
                        'lokasi_akhir_id' => $lokasiAkhir,
                        'remark' => $remark,
                        'qty' => $remainingQuantity,
                    ]);
                    if(request()->remark !== 'Siap Scrap'){
                        $record->update(['qty_awal' => $dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty]);
                    }

                    if ($newQuantity > 0) {
                        $dataBarang->lokasi()->updateExistingPivot($lokasiAwal, ['qty' => $newQuantity]);
                    } else {
                        $dataBarang->lokasi()->detach($lokasiAwal);
                    }
                    if(request()->remark !== 'Siap Scrap'){
                        $record->update(['qty_akhir' => $dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty]);
                    }
                    
                    $record->save();

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
                    $record = Perubahan::create([
                        'data_barang_id' => $dataBarang->id,
                        'lokasi_awal_id' => $lokasiAwal,
                        'lokasi_akhir_id' => $lokasiAkhir,
                        'remark' => $remark,
                        'qty' => $movedQuantity,
                        'qty_awal' => $dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty,
                    ]);

                    $dataBarang->lokasi()->detach($lokasiAwal);

                    $record->update(['qty_akhir' => $dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty]);
                    $record->save();

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
        } else {
            foreach ($availableDataBarang as $dataBarang) {
                if ($dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty >= $remainingQuantity) {
                    $newQuantity = $dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty - $remainingQuantity;
                    $record = Perubahan::create([
                        'data_barang_id' => $dataBarang->id,
                        'lokasi_awal_id' => $lokasiAwal,
                        'remark' => $remark,
                        'qty' => $remainingQuantity,
                        'qty_awal' => $dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty,
                    ]);
                    if ($newQuantity > 0) {
                        $dataBarang->lokasi()->updateExistingPivot($lokasiAwal, ['qty' => $newQuantity]);
                    } else {
                        $dataBarang->lokasi()->detach($lokasiAwal);
                    }

                    $record->update(['qty_akhir' => $dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty]);
                    $record->save();
                    
                    $remainingQuantity = 0;
                    break;
                } else {
                    $movedQuantity = $dataBarang->lokasi()->where('lokasi_id', $lokasiAwal)->first()->pivot->qty;

                    $dataBarang->lokasi()->detach($lokasiAwal);
                    $remainingQuantity -= $movedQuantity;
                }
            }
        }

        if ($remainingQuantity > 0) {
            throw new \Exception("Insufficient quantity available for moving.");
        }
    }
}
