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
            ['nama' => 'GUDANG UTAMA'],
            ['nama' => 'DEPARTEMENT PRODUKSI'],
            ['nama' => 'TWIST'],
            ['nama' => 'PA 841W'],
            ['nama' => 'RAYCHAM'],
            ['nama' => 'TENSILE (SAI T)'],
            ['nama' => 'PA 602W'],
            ['nama' => 'BC'],
            ['nama' => 'PA 711W+895B'],
            ['nama' => 'CASTING'],
            ['nama' => 'PA 702W'],
            ['nama' => 'BONDER'],
            ['nama' => 'PA 885W (SAI T)'],
            ['nama' => 'CRIMP'],
            ['nama' => 'SHIELD'],
            ['nama' => 'PA 120D'],
            ['nama' => 'KOMAX'],
            ['nama' => 'PA 14PL'],
            ['nama' => 'PA J72A'],
            ['nama' => 'SCRAP BRAID'],
            ['nama' => 'CENTRAL CUTTING'],
            ['nama' => 'PA JKD'],
            ['nama' => 'PA J03A'],
            ['nama' => 'PA J20E'],
            ['nama' => 'TENSILE (SAI B)'],
            ['nama' => 'PA MTB-XC2B'],
            ['nama' => 'PA 885W (SAI B)'],
            ['nama' => '1B'],
            ['nama' => '2A'],
            ['nama' => '3A'],
            ['nama' => '4A'],
            ['nama' => '4B'],
            ['nama' => '5B'],
            ['nama' => '5C'],
            ['nama' => '7C'],
            ['nama' => '9A'],
            ['nama' => '11B 1GD'],
            ['nama' => '12C 82140'],
            ['nama' => '12C KOMONO'],
            ['nama' => '12C FRAME'],
            ['nama' => '13B L4T'],
            ['nama' => '12C 48859'],
            ['nama' => '14B'],
            ['nama' => '16A'],
            ['nama' => '17A'],
            ['nama' => '18C'],
            ['nama' => '19B'],
            ['nama' => '24A'],
            ['nama' => '24C'],
            ['nama' => '26A'],
            ['nama' => '26C'],
            ['nama' => '3A (SAI B)'],
            ['nama' => '3B (SAI B)'],
            ['nama' => '3C (SAI B)'],
            ['nama' => '4A (SAI B)'],
            ['nama' => '4C (SAI B)'],
            ['nama' => '5B (SAI B)'],
            ['nama' => '6A (SAI B)'],
            ['nama' => '6B (SAI B)'],
            ['nama' => '6C (SAI B)'],
            ['nama' => '7A (SAI B)'],
            ['nama' => '7B (SAI B)'],
            ['nama' => '8A (SAI B)'],
            ['nama' => '12C (SAI B)'],
            ['nama' => '13B (SAI B)'],
            ['nama' => '14C (SAI B)'],
            ['nama' => '15C (SAI B)'],
        ];

        DB::table('lokasi')->insert($data);
        // LokasiFactory::times(10)->create();
    }
}
