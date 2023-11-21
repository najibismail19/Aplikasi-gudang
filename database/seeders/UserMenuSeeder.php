<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::beginTransaction();
        try {

            DB::table("user_menu")->insert([
                "menu_id" => "001",
                "nama" => "Profile",
                "icon" => "fa-solid fa-user"
            ]);

            DB::table("user_menu")->insert([
                "menu_id" => "002",
                "nama" => "Dashboard",
                "icon" => "fa-solid fa-house"
            ]);

            DB::table("user_menu")->insert([
                "menu_id" => "003",
                "nama" => "List Users",
                "icon" => "fa-solid fa-users"
            ]);

            DB::table("user_menu")->insert([
                "menu_id" => "004",
                "nama" => "Manajement-Menu",
                "icon" => "fa-solid fa-bars"
            ]);

            DB::table("user_menu")->insert([
                "menu_id" => "005",
                "nama" => "Suppliers",
                "icon" => "fa-solid fa-truck-fast"
            ]);

            DB::table("user_menu")->insert([
                "menu_id" => "006",
                "nama" => "Customers",
                "icon" => "fa-solid fa-car"
            ]);

            DB::table("user_menu")->insert([
                "menu_id" => "007",
                "nama" => "Master Produk",
                "icon" => "fa-solid fa-clipboard"
            ]);

            DB::table("user_menu")->insert([
                "menu_id" => "008",
                "nama" => "Transaksi",
                "icon" => "fa-solid fa-chart-shopping"
            ]);

            DB::table("user_menu")->insert([
                "menu_id" => "009",
                "nama" => "Prakitan",
                "icon" => "fa-solid fa-layer-group"
            ]);

            DB::table("user_menu")->insert([
                "menu_id" => "010",
                "nama" => "Master Stok",
                "icon" => "fa-solid fa-chart-simple"
            ]);

            // DB::table("user_menu")->insert([
            //     "menu_id" => "2",
            //     "nama" => "Manajemen-menu",
            //     "icon" => "archive"
            // ]);

            // DB::table("user_menu")->insert([
            //     "menu_id" => "3",
            //     "nama" => "Supplier",
            //     "icon" => ""
            // ]);

            // DB::table("user_menu")->insert([
            //     "menu_id" => "4",
            //     "nama" => "Customer",
            //     "icon" => ""
            // ]);

            // DB::table("user_menu")->insert([
            //     "menu_id" => "5",
            //     "nama" => "Transaksi",
            //     "icon" => ""
            // ]);

            // DB::table("user_menu")->insert([
            //     "menu_id" => "6",
            //     "nama" => "Master-Stok",
            //     "icon" => ""
            // ]);
    

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            throw $e;
        }
    }
}
