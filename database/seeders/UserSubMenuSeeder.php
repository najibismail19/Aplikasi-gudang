<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "1-1",
                "menu_id" => "001",
                "title" => "Profile",
                "url" => "/profile",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "2-1",
                "menu_id" => "002",
                "title" => "Dashboard",
                "url" => "/dashboard",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "3-1",
                "menu_id" => "003",
                "title" => "List Users",
                "url" => "/users",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "4-1",
                "menu_id" => "004",
                "title" => "Menu",
                "url" => "/manajement-menu/user-menu",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "4-2",
                "menu_id" => "004",
                "title" => "Sub Menu",
                "url" => "/manajement-menu/user-sub-menu",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "4-3",
                "menu_id" => "004",
                "title" => "Role Access",
                "url" => "/manajement-menu/user-role-access",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "5-1",
                "menu_id" => "005",
                "title" => "Supplier",
                "url" => "/supplier",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "6-1",
                "menu_id" => "006",
                "title" => "Customer",
                "url" => "/customers",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "7-1",
                "menu_id" => "007",
                "title" => "Produk",
                "url" => "/produk",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "8-1",
                "menu_id" => "008",
                "title" => "Pembelian",
                "url" => "/pembelian",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "8-2",
                "menu_id" => "008",
                "title" => "Penerimaan",
                "url" => "/penerimaan",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "8-3",
                "menu_id" => "008",
                "title" => "Penjualan",
                "url" => "/penjualan",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);
            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "9-1",
                "menu_id" => "009",
                "title" => "Prakitan",
                "url" => "/prakitan",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "9-2",
                "menu_id" => "009",
                "title" => "Master Prakitan",
                "url" => "/master-prakitan",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "10-1",
                "menu_id" => "010",
                "title" => "Kartu Stok",
                "url" => "/kartu-stok",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "10-2",
                "menu_id" => "010",
                "title" => "Stok Barang Mentah",
                "url" => "/stok-barang-mentah",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::table("user_sub_menu")->insert([
                "sub_menu_id" => "10-3",
                "menu_id" => "010",
                "title" => "Stok Barang Jadi",
                "url" => "/stok-barang-jadi",
                "icon" => "far fa-circle nav-icon mr-2",
                "is_active" => true,
            ]);

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            throw $e;
        }
    }
}
