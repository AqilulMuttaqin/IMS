<?php

namespace Database\Seeders;

use App\Models\Barang;
use Database\Factories\BarangFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BarangFactory::times(50)->create();

        Barang::create([
            'kode_js' => 'JS00001',
            'nama' => 'Kaos Polos',
            'harga' => 50000,
            'min_stok' => 10,
            'max_stok' => 100,
        ]);
    }
}
