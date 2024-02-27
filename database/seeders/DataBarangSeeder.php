<?php

namespace Database\Seeders;

use App\Models\DataBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DataBarang::create([
        //     'kode_js' => 'JS233',
        //     'lokasi_id' => 1,
        //     'inv_number' => 'INV001',
        //     'PO_number' => 'PO001',
        //     'qty' => 10,
        // ]);

        $data = [
            ['id' => 1, 'kode_js' => 'A0001', 'inv_number' => 'INV001', 'PO_number' => 'PO001'],
            ['id' => 2, 'kode_js' => 'A0002', 'inv_number' => 'INV002', 'PO_number' => 'PO002'],
            ['id' => 3, 'kode_js' => 'A0003', 'inv_number' => 'INV003', 'PO_number' => 'PO003'],
            ['id' => 4, 'kode_js' => 'A0004', 'inv_number' => 'INV004', 'PO_number' => 'PO004'],
            ['id' => 5, 'kode_js' => 'A0005', 'inv_number' => 'INV005', 'PO_number' => 'PO005'],
            ['id' => 6, 'kode_js' => 'A0006', 'inv_number' => 'INV006', 'PO_number' => 'PO006'],
            ['id' => 7, 'kode_js' => 'A0007', 'inv_number' => 'INV007', 'PO_number' => 'PO007'],
            ['id' => 8, 'kode_js' => 'A0008', 'inv_number' => 'INV008', 'PO_number' => 'PO008'],
            ['id' => 9, 'kode_js' => 'A0009', 'inv_number' => 'INV009', 'PO_number' => 'PO009'],
            ['id' => 10, 'kode_js' => 'A0010', 'inv_number' => 'INV010', 'PO_number' => 'PO010'],
            ['id' => 11, 'kode_js' => 'A0001', 'inv_number' => 'INV011', 'PO_number' => 'PO011'],
            ['id' => 12, 'kode_js' => 'A0002', 'inv_number' => 'INV012', 'PO_number' => 'PO012'],
            ['id' => 13, 'kode_js' => 'A0003', 'inv_number' => 'INV013', 'PO_number' => 'PO013'],
            ['id' => 14, 'kode_js' => 'A0011', 'inv_number' => 'INV014', 'PO_number' => 'PO014'],
            ['id' => 15, 'kode_js' => 'A0012', 'inv_number' => 'INV015', 'PO_number' => 'PO015'],
            ['id' => 16, 'kode_js' => 'A0013', 'inv_number' => 'INV016', 'PO_number' => 'PO016'],
            ['id' => 17, 'kode_js' => 'A0004', 'inv_number' => 'INV017', 'PO_number' => 'PO017'],
            ['id' => 18, 'kode_js' => 'A0005', 'inv_number' => 'INV018', 'PO_number' => 'PO018'],
            ['id' => 19, 'kode_js' => 'A0006', 'inv_number' => 'INV019', 'PO_number' => 'PO019'],
            ['id' => 20, 'kode_js' => 'A0014', 'inv_number' => 'INV020', 'PO_number' => 'PO020'],
        ];
        
        DB::table('data_barang')->insert($data);
    }
}
