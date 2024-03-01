<?php

namespace Database\Seeders;

use App\Models\Keranjang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeranjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keranjang = Keranjang::create([
            'user_id' => 3,
        ]);

        $keranjang->barang()->attach('A0001', ['qty' => 2]);
        $keranjang->barang()->attach('A0002', ['qty' => 4]);
        $keranjang->barang()->attach('A0004', ['qty' => 1]);
    }
}
