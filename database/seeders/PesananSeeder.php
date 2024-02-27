<?php

namespace Database\Seeders;

use App\Models\Pesanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pesanan = Pesanan::create([
            'nik' => '111111',
        ]);

        $pesanan->barang()->attach('A0001', ['qty' => 2]);

    }
}
