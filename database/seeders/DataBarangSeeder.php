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
            ['id' => 11, 'kode_js' => 'A0011', 'inv_number' => 'INV011', 'PO_number' => 'PO011'],
            ['id' => 12, 'kode_js' => 'A0012', 'inv_number' => 'INV012', 'PO_number' => 'PO012'],
            ['id' => 13, 'kode_js' => 'A0013', 'inv_number' => 'INV013', 'PO_number' => 'PO013'],
            ['id' => 14, 'kode_js' => 'A0014', 'inv_number' => 'INV014', 'PO_number' => 'PO014'],
            ['id' => 15, 'kode_js' => 'A0015', 'inv_number' => 'INV015', 'PO_number' => 'PO015'],
            ['id' => 16, 'kode_js' => 'A0016', 'inv_number' => 'INV016', 'PO_number' => 'PO016'],
            ['id' => 17, 'kode_js' => 'A0017', 'inv_number' => 'INV017', 'PO_number' => 'PO017'],
            ['id' => 18, 'kode_js' => 'A0018', 'inv_number' => 'INV018', 'PO_number' => 'PO018'],
            ['id' => 19, 'kode_js' => 'A0019', 'inv_number' => 'INV019', 'PO_number' => 'PO019'],
            ['id' => 20, 'kode_js' => 'A0020', 'inv_number' => 'INV020', 'PO_number' => 'PO020'],
            ['id' => 21, 'kode_js' => 'A0001', 'inv_number' => 'INV021', 'PO_number' => 'PO021'],
            ['id' => 22, 'kode_js' => 'A0002', 'inv_number' => 'INV022', 'PO_number' => 'PO022'],
            ['id' => 23, 'kode_js' => 'A0003', 'inv_number' => 'INV023', 'PO_number' => 'PO023'],
            ['id' => 24, 'kode_js' => 'A0004', 'inv_number' => 'INV024', 'PO_number' => 'PO024'],
            ['id' => 25, 'kode_js' => 'A0005', 'inv_number' => 'INV025', 'PO_number' => 'PO025'],
            ['id' => 26, 'kode_js' => 'A0006', 'inv_number' => 'INV026', 'PO_number' => 'PO026'],
            ['id' => 27, 'kode_js' => 'A0007', 'inv_number' => 'INV027', 'PO_number' => 'PO027'],
            ['id' => 28, 'kode_js' => 'A0008', 'inv_number' => 'INV028', 'PO_number' => 'PO028'],
            ['id' => 29, 'kode_js' => 'A0009', 'inv_number' => 'INV029', 'PO_number' => 'PO029'],
            ['id' => 30, 'kode_js' => 'A0010', 'inv_number' => 'INV030', 'PO_number' => 'PO030'],
            ['id' => 31, 'kode_js' => 'A0011', 'inv_number' => 'INV031', 'PO_number' => 'PO031'],
            ['id' => 32, 'kode_js' => 'A0012', 'inv_number' => 'INV032', 'PO_number' => 'PO032'],
            ['id' => 33, 'kode_js' => 'A0013', 'inv_number' => 'INV033', 'PO_number' => 'PO033'],
            ['id' => 34, 'kode_js' => 'A0014', 'inv_number' => 'INV034', 'PO_number' => 'PO034'],
            ['id' => 35, 'kode_js' => 'A0015', 'inv_number' => 'INV035', 'PO_number' => 'PO035'],
            ['id' => 36, 'kode_js' => 'A0016', 'inv_number' => 'INV036', 'PO_number' => 'PO036'],
            ['id' => 37, 'kode_js' => 'A0017', 'inv_number' => 'INV037', 'PO_number' => 'PO037'],
            ['id' => 38, 'kode_js' => 'A0018', 'inv_number' => 'INV038', 'PO_number' => 'PO038'],
            ['id' => 39, 'kode_js' => 'A0019', 'inv_number' => 'INV039', 'PO_number' => 'PO039'],
            ['id' => 40, 'kode_js' => 'A0020', 'inv_number' => 'INV040', 'PO_number' => 'PO040'],
        ];
        
        DB::table('data_barang')->insert($data);
    }
}
