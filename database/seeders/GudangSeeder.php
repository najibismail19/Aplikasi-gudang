<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gudang')->insert([
            'id_gudang' => 'G001',
            'nama_gudang' => 'Gudang A'
        ]);

        DB::table('gudang')->insert([
            'id_gudang' => 'G002',
            'nama_gudang' => 'Gudang B'
        ]);

        DB::table('gudang')->insert([
            'id_gudang' => 'G003',
            'nama_gudang' => 'Gudang C'
        ]);

        DB::table('gudang')->insert([
            'id_gudang' => 'G004',
            'nama_gudang' => 'Gudang D'
        ]);

        DB::table('gudang')->insert([
            'id_gudang' => 'G005',
            'nama_gudang' => 'Gudang E'
        ]);
    }
}
