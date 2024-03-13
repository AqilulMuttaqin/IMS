<?php

namespace Database\Seeders;

use App\Models\Barang;
use Database\Factories\BarangFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode_js' => 'A0001', 'nama' => 'Bolpoint', 'harga' => 10000, 'min_stok' => 10, 'max_stok' => 1000, 'kategori' => 'tukar'],
            ['kode_js' => 'A0002', 'nama' => 'Pensil', 'harga' => 5000, 'min_stok' => 5, 'max_stok' => 500, 'kategori' => 'tukar'],
            ['kode_js' => 'A0003', 'nama' => 'Kertas', 'harga' => 20000, 'min_stok' => 20, 'max_stok' => 2000, 'kategori' => 'request'],
            ['kode_js' => 'A0004', 'nama' => 'Penggaris', 'harga' => 8000, 'min_stok' => 8, 'max_stok' => 800, 'kategori' => 'tukar'],
            ['kode_js' => 'A0005', 'nama' => 'Stapler', 'harga' => 15000, 'min_stok' => 15, 'max_stok' => 1500, 'kategori' => 'tukar'],
            ['kode_js' => 'A0006', 'nama' => 'Gunting', 'harga' => 7000, 'min_stok' => 7, 'max_stok' => 700, 'kategori' => 'tukar'],
            ['kode_js' => 'A0007', 'nama' => 'Notes', 'harga' => 12000, 'min_stok' => 12, 'max_stok' => 1200, 'kategori' => 'request'],
            ['kode_js' => 'A0008', 'nama' => 'Tinta Printer', 'harga' => 30000, 'min_stok' => 30, 'max_stok' => 3000, 'kategori' => 'tukar'],
            ['kode_js' => 'A0009', 'nama' => 'Mouse', 'harga' => 25000, 'min_stok' => 25, 'max_stok' => 2500, 'kategori' => 'tukar'],
            ['kode_js' => 'A0010', 'nama' => 'Keyboard', 'harga' => 40000, 'min_stok' => 40, 'max_stok' => 4000, 'kategori' => 'tukar'],
            ['kode_js' => 'A0011', 'nama' => 'Monitor', 'harga' => 120000, 'min_stok' => 120, 'max_stok' => 12000, 'kategori' => 'tukar'],
            ['kode_js' => 'A0012', 'nama' => 'USB Flash Drive', 'harga' => 15000, 'min_stok' => 15, 'max_stok' => 1500, 'kategori' => 'tukar'],
            ['kode_js' => 'A0013', 'nama' => 'Headset', 'harga' => 35000, 'min_stok' => 35, 'max_stok' => 3500, 'kategori' => 'tukar'],
            ['kode_js' => 'A0014', 'nama' => 'Laptop Bag', 'harga' => 50000, 'min_stok' => 50, 'max_stok' => 5000, 'kategori' => 'tukar'],
            ['kode_js' => 'A0015', 'nama' => 'Calculator', 'harga' => 18000, 'min_stok' => 18, 'max_stok' => 1800, 'kategori' => 'tukar'],
            ['kode_js' => 'A0016', 'nama' => 'Eraser', 'harga' => 3000, 'min_stok' => 3, 'max_stok' => 300, 'kategori' => 'request'],
            ['kode_js' => 'A0017', 'nama' => 'Whiteboard Marker', 'harga' => 7000, 'min_stok' => 7, 'max_stok' => 700, 'kategori' => 'tukar'],
            ['kode_js' => 'A0018', 'nama' => 'Power Bank', 'harga' => 40000, 'min_stok' => 40, 'max_stok' => 4000, 'kategori' => 'tukar'],
            ['kode_js' => 'A0019', 'nama' => 'Printer', 'harga' => 80000, 'min_stok' => 80, 'max_stok' => 8000, 'kategori' => 'tukar'],
            ['kode_js' => 'A0020', 'nama' => 'External Hard Drive', 'harga' => 120000, 'min_stok' => 120, 'max_stok' => 12000, 'kategori' => 'tukar'],
        ];

        DB::table('barang')->insert($data);
        // BarangFactory::times(50)->create();

        // Barang::create([
        //     'kode_js' => 'JS00001',
        //     'nama' => 'Kaos Polos',
        //     'harga' => 50000,
        //     'min_stok' => 10,
        //     'max_stok' => 100,
        // ]);
    }
}
