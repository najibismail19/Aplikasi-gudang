<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAccessMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {

            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "1-1"
            ]);
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "2-1"
            ]);
            
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "3-1"
            ]);
            
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "4-1"
            ]);
            
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "4-2"
            ]);
            
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "4-3"
            ]);
            
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "5-1"
            ]);

            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "6-1"
            ]);

            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "7-1"
            ]);
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "8-1"
            ]);
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "8-2"
            ]);
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "8-3"
            ]);
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "9-1"
            ]);
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "9-2"
            ]);
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "10-1"
            ]);
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "10-2"
            ]);
            DB::table("user_access_menu")->insert([
                "id_jabatan" => "J001",
                "sub_menu_id" => "10-3"
            ]);

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            throw $e;
        }
    }
}
