<?php

namespace Database\Seeders;

use App\Models\Pesanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = ['pending', 'disiapkan', 'dikirim'];
        for ($i = 0; $i < 10; $i++) {
            $pesanan = Pesanan::create([
              'user_id' => 3,
                'status' => $status[rand(0, 2)],
            ]);
          
            for ($j = 0; $j < rand(1, 5); $j++) {
              $barangId = 'A00' . sprintf('%02d', rand(1, 20));
              $qty = rand(1, 10);
          
              $pesanan->barang()->attach($barangId, ['qty' => $qty]);
            }
          }

    }
}
