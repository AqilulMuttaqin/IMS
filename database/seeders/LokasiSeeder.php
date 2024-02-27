<?php

namespace Database\Seeders;

use Database\Factories\LokasiFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Gudang Utama'],
            ['nama' => 'Departement Produksi'],
            ['nama' => 'Kantor Pemasaran'],
            ['nama' => 'Ruang Rapat'],
            ['nama' => 'Lobby Utama'],
            ['nama' => 'Kantin'],
            ['nama' => 'Departement Keuangan'],
            ['nama' => 'Gudang Bahan Baku'],
            ['nama' => 'Ruang Server'],
            ['nama' => 'Departement Sumber Daya Manusia'],
        ];

        DB::table('lokasi')->insert($data);
        // LokasiFactory::times(10)->create();
    }
}
