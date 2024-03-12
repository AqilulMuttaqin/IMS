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
            ['nama' => 'GUDANG PRODUKSI'],
            ['nama' => 'DEPARTEMENT PRODUKSI'],
            ['nama' => 'SIAP SCRAP'],
            ['nama' => 'TWIST (SAI-T)'],
            ['nama' => 'PA 841W (SAI-T)'],
            ['nama' => 'RAYCHAM (SAI-T)'],
            ['nama' => 'TENSILE (SAI T)'],
            ['nama' => 'PA 602W (SAI-T)'],
            ['nama' => 'BC (SAI-T)'],
            ['nama' => 'PA 711W+895B (SAI-T)'],
            ['nama' => 'CASTING (SAI-T)'],
            ['nama' => 'PA 702W (SAI-T)'],
            ['nama' => 'BONDER (SAI-T)'],
            ['nama' => 'PA 885W (SAI T)'],
            ['nama' => 'CRIMP (SAI-T)'],
            ['nama' => 'SHIELD (SAI-T)'],
            ['nama' => 'PA 120D (SAI-T)'],
            ['nama' => 'KOMAX (SAI-T)'],
            ['nama' => 'PA 14PL (SAI-T)'],
            ['nama' => 'PA J72A (SAI-T)'],
            ['nama' => 'SCRAP BRAID (SAI-T)'],
            ['nama' => '1B (SAI-T)'],
            ['nama' => '2A (SAI-T)'],
            ['nama' => '3A (SAI-T)'],
            ['nama' => '4A (SAI-T)'],
            ['nama' => '4B (SAI-T)'],
            ['nama' => '5B (SAI-T)'],
            ['nama' => '5C (SAI-T)'],
            ['nama' => '7C (SAI-T)'],
            ['nama' => '9A (SAI-T)'],
            ['nama' => '11B 1GD (SAI-T)'],
            ['nama' => '12C 82140 (SAI-T)'],
            ['nama' => '12C KOMONO (SAI-T)'],
            ['nama' => '12C FRAME (SAI-T)'],
            ['nama' => '13B L4T (SAI-T)'],
            ['nama' => '12C 48859 (SAI-T)'],
            ['nama' => '14B (SAI-T)'],
            ['nama' => '16A (SAI-T)'],
            ['nama' => '17A (SAI-T)'],
            ['nama' => '18C (SAI-T)'],
            ['nama' => '19B (SAI-T)'],
            ['nama' => '24A (SAI-T)'],
            ['nama' => '24C (SAI-T)'],
            ['nama' => '26A (SAI-T)'],
            ['nama' => '26C (SAI-T)'],
            ['nama' => 'CENTRAL CUTTING (SAI-B)'],
            ['nama' => 'PA JKD (SAI-B)'],
            ['nama' => 'PA J03A (SAI-B)'],
            ['nama' => 'PA J20E (SAI-B)'],
            ['nama' => 'TENSILE (SAI B)'],
            ['nama' => 'PA MTB-XC2B (SAI-B)'],
            ['nama' => 'PA 885W (SAI B)'],
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
