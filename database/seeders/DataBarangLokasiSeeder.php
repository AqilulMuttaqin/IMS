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
            ['lokasi_id' => 1, 'data_barang_id' => 1, 'qty' => 1000],
            ['lokasi_id' => 1, 'data_barang_id' => 2, 'qty' => 1000],
            ['lokasi_id' => 1, 'data_barang_id' => 3, 'qty' => 1000],
            ['lokasi_id' => 1, 'data_barang_id' => 4, 'qty' => 500],
            ['lokasi_id' => 1, 'data_barang_id' => 5, 'qty' => 200],
            ['lokasi_id' => 1, 'data_barang_id' => 6, 'qty' => 100],
            ['lokasi_id' => 1, 'data_barang_id' => 7, 'qty' => 250],
            ['lokasi_id' => 1, 'data_barang_id' => 8, 'qty' => 500],
            ['lokasi_id' => 1, 'data_barang_id' => 9, 'qty' => 250],
            ['lokasi_id' => 1, 'data_barang_id' => 10, 'qty' => 300],
            ['lokasi_id' => 1, 'data_barang_id' => 11, 'qty' => 1000],
            ['lokasi_id' => 1, 'data_barang_id' => 12, 'qty' => 800],
            ['lokasi_id' => 1, 'data_barang_id' => 13, 'qty' => 250],
            ['lokasi_id' => 1, 'data_barang_id' => 14, 'qty' => 300],
            ['lokasi_id' => 1, 'data_barang_id' => 15, 'qty' => 400],
            ['lokasi_id' => 1, 'data_barang_id' => 16, 'qty' => 500],
            ['lokasi_id' => 1, 'data_barang_id' => 17, 'qty' => 100],
            ['lokasi_id' => 1, 'data_barang_id' => 18, 'qty' => 150],
            ['lokasi_id' => 1, 'data_barang_id' => 19, 'qty' => 200],
            ['lokasi_id' => 1, 'data_barang_id' => 20, 'qty' => 500],
            ['lokasi_id' => 1, 'data_barang_id' => 21, 'qty' => 1000],
            ['lokasi_id' => 1, 'data_barang_id' => 22, 'qty' => 1000],
            ['lokasi_id' => 1, 'data_barang_id' => 23, 'qty' => 1000],
            ['lokasi_id' => 1, 'data_barang_id' => 24, 'qty' => 500],
            ['lokasi_id' => 1, 'data_barang_id' => 25, 'qty' => 200],
            ['lokasi_id' => 1, 'data_barang_id' => 26, 'qty' => 100],
            ['lokasi_id' => 1, 'data_barang_id' => 27, 'qty' => 250],
            ['lokasi_id' => 1, 'data_barang_id' => 28, 'qty' => 500],
            ['lokasi_id' => 1, 'data_barang_id' => 29, 'qty' => 250],
            ['lokasi_id' => 1, 'data_barang_id' => 30, 'qty' => 300],
            ['lokasi_id' => 1, 'data_barang_id' => 31, 'qty' => 1000],
            ['lokasi_id' => 1, 'data_barang_id' => 32, 'qty' => 800],
            ['lokasi_id' => 1, 'data_barang_id' => 33, 'qty' => 250],
            ['lokasi_id' => 1, 'data_barang_id' => 34, 'qty' => 300],
            ['lokasi_id' => 1, 'data_barang_id' => 35, 'qty' => 400],
            ['lokasi_id' => 1, 'data_barang_id' => 36, 'qty' => 500],
            ['lokasi_id' => 1, 'data_barang_id' => 37, 'qty' => 100],
            ['lokasi_id' => 1, 'data_barang_id' => 38, 'qty' => 150],
            ['lokasi_id' => 1, 'data_barang_id' => 39, 'qty' => 200],
            ['lokasi_id' => 1, 'data_barang_id' => 40, 'qty' => 500],
        ];

        // for ($i = 1; $i <= 20; $i++) {
        //     $data[] = [
        //         'lokasi_id' => rand(2, 10),
        //         'data_barang_id' => rand(1, 40),
        //         'qty' => rand(1, 10),
        //     ];
        // }

        DB::table('data_barang_lokasi')->insert($data);
    }
}
