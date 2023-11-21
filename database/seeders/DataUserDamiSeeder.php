<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Hash;

class DataUserDamiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        DB::beginTransaction();
        try {

            DB::table("gudang")->insert([
                "id_gudang" => "G001",
                "nama_gudang" => "Gudang A",
            ]);
    
            DB::table("gudang")->insert([
                "id_gudang" => "G002",
                "nama_gudang" => "Gudang B",
            ]);
            
            DB::table("gudang")->insert([
                "id_gudang" => "G003",
                "nama_gudang" => "Gudang C",
            ]);
    
            // Insert Jabatan
    
            DB::table("jabatan")->insert([
                "id_jabatan" => "J001",
                "nama_jabatan" => "Admin Pusat"
            ]);
    
            DB::table("jabatan")->insert([
                "id_jabatan" => "J002",
                "nama_jabatan" => "Manajer Gudang"
            ]);
    
    
    
            DB::table("jabatan")->insert([
                "id_jabatan" => "J003",
                "nama_jabatan" => "Supervisor"
            ]);
    
    
            DB::table("jabatan")->insert([
                "id_jabatan" => "J004",
                "nama_jabatan" => "Staff Pembelian"
            ]);
    
    
            DB::table("jabatan")->insert([
                "id_jabatan" => "J005",
                "nama_jabatan" => "Staff penerimaan"
            ]);
    
            DB::table("jabatan")->insert([
                "id_jabatan" => "J006",
                "nama_jabatan" => "Staff Penjualan"
            ]);
    
            DB::table("jabatan")->insert([
                "id_jabatan" => "J007",
                "nama_jabatan" => "Operator Prakitan"
            ]);
    
    
            DB::table("karyawan")->insert([
                "nik" => "001",
                "nama" => "Najib Ismail",
                "email" => $faker->email,
                "password" => Hash::make("rahasia"),
                "id_jabatan" => "J001",
                "id_gudang" => "G001"
            ]);

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            throw $e;
        }
    }
}
