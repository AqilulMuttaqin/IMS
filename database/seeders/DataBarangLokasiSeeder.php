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


        for ($i = 1; $i <= 50; $i++) {
            $data[] = [
                'lokasi_id' => rand(1, 10),
                'data_barang_id' => rand(1, 20),
                'qty' => rand(1, 30),
            ];
        }

        DB::table('data_barang_lokasi')->insert($data);
    }
}
