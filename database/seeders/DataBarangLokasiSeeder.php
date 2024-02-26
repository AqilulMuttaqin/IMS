<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataBarangLokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DataBarangLokasi::create([
        //     'lokasi_id' => 1,
        //     'kode_js' => 'JS233',
        //     'qty' => 10,
        // ]);

        $data = [
            [
                'lokasi_id' => 1,
                'data_barang_id' => '1',
                'qty' => 10,
            ],
        ];
        DB::table('data_barang_lokasi')->insert($data);
    }
}
