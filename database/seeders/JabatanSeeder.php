<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jabatan')->insert([
            'id_jabatan' => 'J001',
            'nama_jabatan' => 'Admin'
        ]);

        DB::table('jabatan')->insert([
            'id_jabatan' => 'J002',
            'nama_jabatan' => 'Manajer Gudang'
        ]);

        DB::table('jabatan')->insert([
            'id_jabatan' => 'J003',
            'nama_jabatan' => 'Supervisor Gudang'
        ]);

        DB::table('jabatan')->insert([
            'id_jabatan' => 'J004',
            'nama_jabatan' => 'Operator Prakitan'
        ]);

        DB::table('jabatan')->insert([
            'id_jabatan' => 'J005',
            'nama_jabatan' => 'Staff Pembelian'
        ]);

        DB::table('jabatan')->insert([
            'id_jabatan' => 'J006',
            'nama_jabatan' => 'Staff Penerimaan'
        ]);

        DB::table('jabatan')->insert([
            'id_jabatan' => 'J007',
            'nama_jabatan' => 'Staff Penjualan'
        ]);
    }
}
