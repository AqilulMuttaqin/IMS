<?php

namespace Database\Seeders;

use Database\Factories\BarangFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BarangFactory::times(50)->create();
    }
}
