<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            //admin
            [
                'name' =>  'Granger',
                'nik' => '222222',
                'password' => Hash::make('222222'),
                'role' => 'admin',
                'pw' => '222222',
                'lokasi_id' => 1
            ],

            //spv
            [
                'name' =>  'Anisa',
                'nik' => '333333',
                'password' => Hash::make('333333'),
                'role' => 'spv',
                'pw' => '333333',
                'lokasi_id' => 2
            ],

            //user
            [
                'name' =>  'Pororo',
                'nik' => '111111',
                'password' => Hash::make('111111'),
                'role' => 'user',
                'pw' => '111111',
                'lokasi_id' => 6
            ]
        ]);
    }
}
