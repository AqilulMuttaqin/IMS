<?php

namespace Database\Seeders;

use Database\Factories\LokasiFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LokasiFactory::times(10)->create();
    }
}
