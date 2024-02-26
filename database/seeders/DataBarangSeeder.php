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
            [
                'kode_js' => 'JS028',
                'inv_number' => 'INV001',
                'PO_number' => 'PO001',
            ],
        ];
        DB::table('data_barang')->insert($data);
    }
}
